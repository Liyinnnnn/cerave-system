<?php

namespace App\Http\Controllers;

use App\Models\DrCMessage;
use App\Models\DrCSession;
use App\Models\Product;
use App\Traits\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DrCController extends Controller
{
    use ResponseHelper;

    /**
     * Show Dr. C chat interface.
     */
    public function chat(Request $request)
    {
        try {
            $user = auth()->user();
            $session = null;
            $sessionId = $request->query('session');
            $newChat = $request->query('new') === '1';

            // If session ID provided, load that session
            if ($sessionId && $user) {
                $session = DrCSession::where('session_token', $sessionId)
                    ->where('user_id', $user->id)
                    ->where('status', 'active')
                    ->firstOrFail();
            } 
            // If no session specified and not requesting new chat, load most recent active session
            elseif ($user && !$newChat) {
                $session = DrCSession::where('user_id', $user->id)
                    ->where('status', 'active')
                    ->latest('updated_at')
                    ->first();
            }

            // Get chat history
            $history = [];
            if ($session) {
                $history = $session->messages()->oldest()->get();
            }

            // Recent sessions list for sidebar
            $recentSessions = [];
            if ($user) {
                $recentSessions = DrCSession::where('user_id', $user->id)
                    ->latest('created_at')
                    ->withCount('messages')
                    ->limit(8)
                    ->get();
            }

            // Calculate rate limit remaining
            $rateLimitRemaining = null;
            if ($user) {
                $recentMessages = DrCMessage::where('user_id', $user->id)
                    ->where('created_at', '>', now()->subHour())
                    ->count();
                $rateLimitRemaining = max(0, 20 - $recentMessages);
            }

            return view('dr-c.chat', compact('history', 'user', 'session', 'rateLimitRemaining', 'recentSessions'));
        } catch (\Exception $e) {
            \Log::error('Dr. C chat view failed', ['error' => $e->getMessage()]);
            return redirect()->route('welcome')->with('error', 'Failed to load Dr. C chat.');
        }
    }

    /**
     * Send message to Dr. C (streaming response).
     * Rate limited: 20 messages per hour per user/IP.
     */
    public function send(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|min:5|max:1000',
                'session_token' => 'nullable|string',
            ]);

            $user = auth()->user();
            $userIdentifier = $user?->id ?? $request->ip();
            $message = $request->message;

            // Rate limiting per user/IP (20 per hour)
            $recentMessages = DrCMessage::where(
                $user ? 'user_id' : 'ip_address',
                $user ? $user->id : $request->ip()
            )
                ->where('created_at', '>', now()->subHour())
                ->count();

            if ($recentMessages >= 20) {
                return $this->error(
                    'You have reached the maximum number of messages per hour. Please try again later.',
                    'ERR_RATE_LIMIT',
                    statusCode: 429,
                    json: true
                );
            }

            // Get or create session
            $session = null;
            $sessionToken = $request->input('session_token');
            
            if ($user) {
                if ($sessionToken) {
                    $session = DrCSession::where('session_token', $sessionToken)
                        ->where('user_id', $user->id)
                        ->where('status', 'active')
                        ->first();
                }

                if (!$session) {
                    $session = DrCSession::create([
                        'user_id' => $user->id,
                        'session_token' => DrCSession::generateToken(),
                        'status' => 'active',
                    ]);
                }
            }

            // Detect skin concerns from message
            $skinConcerns = $this->extractSkinConcerns($message);

            // Update session concerns if new ones found
            if ($session && $session->concerns !== $skinConcerns) {
                $session->update([
                    'concerns' => $skinConcerns,
                ]);
            }

            // Build system prompt
            $systemPrompt = $this->buildSystemPrompt();

            $apiKey = config('services.gemini.api_key');
            if (blank($apiKey)) {
                return $this->error(
                    'Dr. C is not configured yet. Please add GEMINI_API_KEY to your .env file.',
                    'ERR_DR_C_CONFIG',
                    statusCode: 500,
                    json: true
                );
            }

            // Call Google Gemini API
            $response = Http::timeout(45)
                ->retry(2, 1000)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $systemPrompt . "\n\nUser: " . $message . "\n\nDr. C:"]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 2000,
                        'topP' => 0.95,
                    ],
                    'safetySettings' => [
                        [
                            'category' => 'HARM_CATEGORY_HARASSMENT',
                            'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                        ],
                        [
                            'category' => 'HARM_CATEGORY_HATE_SPEECH',
                            'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                        ],
                        [
                            'category' => 'HARM_CATEGORY_DANGEROUS_CONTENT',
                            'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                        ]
                    ]
                ]);

            if (!$response->successful()) {
                \Log::warning('Gemini API failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return $this->error(
                    'Dr. C is experiencing technical difficulties. Please try again later.',
                    'ERR_DR_C_UNAVAILABLE',
                    statusCode: 503,
                    json: true
                );
            }

            $responseData = $response->json();

            if (!isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                \Log::error('Unexpected Gemini response', ['response' => $responseData]);

                return $this->error(
                    'Dr. C could not generate a response. Please try again.',
                    'ERR_DR_C_INVALID_RESPONSE',
                    json: true
                );
            }

            $drCReply = $responseData['candidates'][0]['content']['parts'][0]['text'];
            $tokensUsed = ($responseData['usageMetadata']['promptTokenCount'] ?? 0) + ($responseData['usageMetadata']['candidatesTokenCount'] ?? 0);

            // Get recommended products
            $recommendedProducts = $this->recommendProducts($skinConcerns);

            // Save user message
            $userMessage = DrCMessage::create([
                'user_id' => $user?->id,
                'session_id' => $session?->id,
                'message' => $message,
                'response' => null,
                'message_type' => 'user',
                'tokens_used' => 0,
                'skin_concerns' => $skinConcerns,
                'ip_address' => $request->ip(),
            ]);

            // Save Dr. C response
            $assistantMessage = DrCMessage::create([
                'user_id' => $user?->id,
                'session_id' => $session?->id,
                'message' => $drCReply,
                'message_type' => 'assistant',
                'response' => $drCReply,
                'tokens_used' => $tokensUsed,
                'recommended_products' => $recommendedProducts,
                'ip_address' => $request->ip(),
            ]);

            // Update session
            if ($session) {
                $session->increment('message_count', 2);
                $session->increment('tokens_used', $tokensUsed);
            }

            // Return JSON response
            return response()->json([
                'status' => 'ok',
                'data' => [
                    'user_message_id' => $userMessage->id,
                    'assistant_message_id' => $assistantMessage->id,
                    'user_message' => $message,
                    'dr_c_response' => $drCReply,
                    'timestamp' => $assistantMessage->created_at,
                    'products' => $recommendedProducts,
                    'session_token' => $session?->session_token,
                ],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            \Log::error('Dr. C send failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->error(
                'An unexpected error occurred. Please try again.',
                'ERR_DRC_SEND_FAILED',
                statusCode: 500,
                json: true
            );
        }
    }

    /**
     * End current session and generate report.
     */
    public function endSession(DrCSession $session)
    {
        try {
            $user = auth()->user();

            if (!$user || $session->user_id !== $user->id) {
                return $this->unauthorized('You cannot end this session.');
            }

            // Generate report
            $report = $this->generateReport($session);

            // Save report
            $session->update([
                'report' => $report,
                'status' => 'completed',
                'ended_at' => now(),
            ]);

            return redirect()->route('dr-c.viewReport', ['session' => $session->id])
                ->with('success', 'Session ended and report generated.');
        } catch (\Exception $e) {
            \Log::error('End session failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to end session.');
        }
    }

    /**
     * Get all sessions for authenticated user.
     */
    public function sessions(Request $request)
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return $this->unauthorized('You must be logged in.');
            }

            $sessions = DrCSession::where('user_id', $user->id)
                ->with('messages')
                ->orderByDesc('created_at')
                ->paginate(10);

            return view('dr-c.sessions', compact('sessions'));
        } catch (\Exception $e) {
            \Log::error('Get sessions failed', ['error' => $e->getMessage()]);
            return redirect()->route('dr-c.chat')->with('error', 'Failed to load sessions.');
        }
    }

    /**
     * View session report.
     */
    public function viewReport(DrCSession $session)
    {
        try {
            $user = auth()->user();

            // Check authorization
            if ($user->isAdmin()) {
                // Admins can view any report
            } elseif ($user->isConsultant()) {
                // Consultants can view any user's reports
            } else {
                // Users can only view their own
                if ($session->user_id !== $user->id) {
                    return $this->unauthorized('You cannot view this report.');
                }
            }

            // Get messages and extract product IDs
            $messages = $session->messages()->where('message_type', 'assistant')->get();
            $productIds = collect();
            
            foreach ($messages as $message) {
                preg_match_all('/\[PRODUCT:(\d+)\]/', $message->message, $matches);
                if (!empty($matches[1])) {
                    $productIds = $productIds->merge($matches[1]);
                }
            }
            
            // Get unique recommended products from database
            $recommendedProducts = Product::whereIn('id', $productIds->unique())->get();

            return view('dr-c.report', compact('session', 'recommendedProducts'));
        } catch (\Exception $e) {
            \Log::error('View report failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to load report.');
        }
    }

    /**
     * Delete session (user can delete own, admin can delete all).
     */
    public function deleteSession(DrCSession $session)
    {
        try {
            $user = auth()->user();

            if (!$user || (!$user->isAdmin() && $session->user_id !== $user->id)) {
                return $this->unauthorized('You cannot delete this session.');
            }

            $redirectRoute = $user->isAdmin() ? 'admin.dr-c.sessions' : 'dr-c.sessions';
            
            $session->delete();

            return redirect()->route($redirectRoute)
                ->with('success', 'Session deleted successfully.');
        } catch (\Exception $e) {
            \Log::error('Delete session failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to delete session.');
        }
    }

    /**
     * Admin: Get all Dr. C sessions.
     */
    public function adminSessions(Request $request)
    {
        try {
            $user = auth()->user();

            if (!$user->isAdmin()) {
                return $this->unauthorized('Only admins can view all sessions.');
            }

            $sessions = DrCSession::with('user')
                ->latest('created_at')
                ->paginate(20);

            return view('dr-c.admin-sessions', compact('sessions'));
        } catch (\Exception $e) {
            \Log::error('Admin sessions failed', ['error' => $e->getMessage()]);
            return $this->error('Failed to load sessions.', 'ERR_ADMIN_SESSIONS');
        }
    }

    /**
     * Get chat history (authenticated users only).
     */
    public function history(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return $this->unauthorized('You must be logged in to view history.');
            }

            $history = DrCMessage::where('user_id', $user->id)
                ->whereNull('session_id')
                ->latest()
                ->paginate(20);

            return response()->json([
                'status' => 'ok',
                'data' => $history,
            ]);
        } catch (\Exception $e) {
            \Log::error('Dr. C history failed', ['error' => $e->getMessage()]);
            return $this->error('Failed to load history.', 'ERR_DRC_HISTORY');
        }
    }

    /**
     * Delete a chat message (owner only).
     */
    public function deleteMessage(DrCMessage $message)
    {
        try {
            $user = auth()->user();

            if (!$user || $message->user_id !== $user->id) {
                return $this->unauthorized('You cannot delete this message.');
            }

            $message->delete();

            return $this->success('Message deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Message deletion failed', ['error' => $e->getMessage()]);
            return $this->error('Failed to delete message.', 'ERR_MESSAGE_DELETE');
        }
    }

    /**
     * Generate consultation report for a session.
     */
    private function generateReport(DrCSession $session): string
    {
        $messages = $session->messages()->orderBy('created_at')->get();
        $userMessages = $messages->where('message_type', 'user')->count();
        $totalTokens = $messages->sum('tokens_used');

        // Get unique products recommended
        $products = [];
        foreach ($messages as $msg) {
            if ($msg->recommended_products) {
                foreach ($msg->recommended_products as $product) {
                    $products[$product['id']] = $product;
                }
            }
        }

        // Build HTML report
        $report = '<div class="report-container">';
        $report .= '<h2>Dr. C Consultation Report</h2>';
        $report .= '<div class="report-section">';
        $report .= '<h3>Session Summary</h3>';
        $report .= '<p><strong>Duration:</strong> ' . $session->session_duration . '</p>';
        $report .= '<p><strong>Messages:</strong> ' . $userMessages . ' questions</p>';
        $report .= '<p><strong>Concerns:</strong> ' . ($session->concerns ?? 'General skincare') . '</p>';
        $report .= '<p><strong>Date:</strong> ' . $session->created_at->format('F d, Y g:i A') . '</p>';
        $report .= '</div>';

        $report .= '<div class="report-section">';
        $report .= '<h3>Conversation Highlights</h3>';
        $report .= '<ul>';
        foreach ($messages->where('message_type', 'user') as $userMsg) {
            $report .= '<li><strong>Q:</strong> ' . htmlspecialchars($userMsg->message) . '</li>';
        }
        $report .= '</ul>';
        $report .= '</div>';

        if (!empty($products)) {
            $report .= '<div class="report-section">';
            $report .= '<h3>Recommended Products</h3>';
            $report .= '<ul>';
            foreach ($products as $product) {
                $report .= '<li><strong>' . htmlspecialchars($product['name']) . '</strong> - $' . number_format($product['price'], 2) . '</li>';
            }
            $report .= '</ul>';
            $report .= '</div>';
        }

        $report .= '<div class="report-section">';
        $report .= '<p><em>Generated on ' . now()->format('F d, Y g:i A') . '</em></p>';
        $report .= '</div>';
        $report .= '</div>';

        return $report;
    }

    /**
     * Extract skin concerns from user message.
     */
    private function extractSkinConcerns(string $message): string
    {
        $keywords = [
            'acne' => 'Acne',
            'pimple' => 'Acne',
            'breakout' => 'Acne',
            'dry' => 'Dry Skin',
            'dryness' => 'Dry Skin',
            'oily' => 'Oily Skin',
            'oiliness' => 'Oily Skin',
            'shine' => 'Oily Skin',
            'sensitive' => 'Sensitive Skin',
            'sensitivity' => 'Sensitive Skin',
            'irritation' => 'Irritation',
            'wrinkle' => 'Aging',
            'fine line' => 'Aging',
            'aging' => 'Aging',
            'dark spot' => 'Hyperpigmentation',
            'hyperpigmentation' => 'Hyperpigmentation',
            'eczema' => 'Eczema',
            'psoriasis' => 'Psoriasis',
            'rash' => 'Rash',
            'redness' => 'Redness',
            'rosacea' => 'Rosacea',
            'dehydration' => 'Dehydration',
            'texture' => 'Texture Issues',
            'bumpy' => 'Texture Issues',
        ];

        $found = [];
        foreach ($keywords as $keyword => $label) {
            if (stripos($message, $keyword) !== false && !in_array($label, $found)) {
                $found[] = $label;
            }
        }

        return !empty($found) ? implode(', ', $found) : 'General skincare';
    }

    /**
     * Recommend products based on skin concerns.
     */
    private function recommendProducts(string $concerns): array
    {
        $concernArray = array_map('trim', explode(',', $concerns));

        $products = Product::query()
            ->where(function ($query) use ($concernArray) {
                foreach ($concernArray as $concern) {
                    $query->orWhere('benefits', 'like', "%{$concern}%")
                        ->orWhere('skin_type', 'like', "%{$concern}%");
                }
            })
            ->limit(4)
            ->get(['id', 'name', 'price', 'image_url', 'images', 'category', 'description'])
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->getPrimaryImage(),
                    'image_url' => $product->image_url,
                    'category' => $product->category,
                    'description' => strip_tags($product->description),
                    'rating' => 4.5, // Default rating
                ];
            })
            ->toArray();

        return $products;
    }

    /**
     * Build system prompt for Dr. C.
     */
    private function buildSystemPrompt(): string
    {
        return "You are Dr. C, an expert AI skincare advisor for CeraVe. Your role is to provide personalized skincare advice, routines, and product recommendations based on user concerns. "
            . "\n\nGuidelines:\n"
            . "1. Be empathetic and professional in tone.\n"
            . "2. Keep responses concise (6-10 sentences max).\n"
            . "3. Provide actionable skincare routines (cleanse, tone, treat, moisturize, protect).\n"
            . "4. Include 2-4 relevant product recommendations from the CeraVe catalog when appropriate.\n"
            . "5. Always prioritize skin safety and suggest dermatologist consultation for severe conditions.\n"
            . "6. Do not diagnose medical conditions; instead, recommend seeing a dermatologist.\n"
            . "7. Focus on CeraVe's gentle, dermatologist-recommended approach with ceramides.\n"
            . "8. Be honest about what skincare can and cannot fix.\n"
            . "9. Consider user's skin type (dry, oily, combination, sensitive) when recommending routines.\n"
            . "10. Recommend natural and gradual improvement timelines.\n";
    }
}
