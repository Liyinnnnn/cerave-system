<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Consultation;
use App\Models\DrCMessage;
use App\Traits\ResponseHelper;

class ConsultationController extends Controller
{
    use ResponseHelper;

    /**
     * Submit consultation concerns to Dr. C (AI skincare advisor).
     * Rate limit: 10 per user per hour.
     */
    public function submit(Request $request)
    {
        try {
            $request->validate([
                'concerns' => 'required|string|min:10|max:1000',
            ]);

            $user = auth()->user();
            $concerns = $request->concerns;

            // Rate limiting per user (10 per hour)
            $recentMessages = DrCMessage::where('user_id', $user?->id)
                ->where('created_at', '>', now()->subHour())
                ->count();

            if ($recentMessages >= 10) {
                return $this->error(
                    'You have reached the maximum number of consultations per hour. Please try again later.',
                    'ERR_RATE_LIMIT'
                );
            }

            // Build system prompt for Dr. C
            $systemPrompt = "You are Dr. C, a professional AI skincare advisor for Cerave. "
                . "You provide personalized skincare routines and product recommendations based on user concerns. "
                . "Keep responses concise (6-10 sentences max). Include 2-4 relevant product recommendations when possible. "
                . "Be professional, empathetic, and accurate.";

            $userPrompt = "Based on the following skin concerns, provide a personalized skincare routine and product recommendations from our catalog:\n\n{$concerns}";

            // Call OpenAI API with timeout and retry
            $response = Http::timeout(30)
                ->retry(2, 1000)
                ->withToken(config('services.openai.api_key'))
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userPrompt],
                    ],
                    'max_tokens' => 300,
                    'temperature' => 0.7,
                ]);

            if (!$response->successful()) {
                \Log::warning('OpenAI API failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return $this->error(
                    'Dr. C is experiencing technical difficulties. Please try again later.',
                    'ERR_DR_C_UNAVAILABLE'
                );
            }

            $responseData = $response->json();

            if (!isset($responseData['choices'][0]['message']['content'])) {
                \Log::error('Unexpected OpenAI response', ['response' => $responseData]);

                return $this->error(
                    'Dr. C could not generate a response. Please try again.',
                    'ERR_DR_C_INVALID_RESPONSE'
                );
            }

            $drCReply = $responseData['choices'][0]['message']['content'];
            $tokensUsed = $responseData['usage']['total_tokens'] ?? 0;

            // Save to database
            DrCMessage::create([
                'user_id' => $user?->id,
                'message' => $concerns,
                'response' => $drCReply,
                'tokens_used' => $tokensUsed,
                'ip_address' => $request->ip(),
            ]);

            // Also save to consultation table if user is logged in
            if ($user) {
                Consultation::create([
                    'user_id' => $user->id,
                    'concerns' => $concerns,
                    'response' => $drCReply,
                ]);
            }

            return back()->with('dr_c_response', $drCReply);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            \Log::error('Dr. C consultation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->error(
                'An unexpected error occurred. Please try again.',
                'ERR_CONSULTATION_FAILED'
            );
        }
    }

    /**
     * View consultation history (user's own or admin's all).
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();

            if ($user->isAdmin()) {
                $consultations = Consultation::with('user')->paginate(15);
            } else {
                $consultations = Consultation::where('user_id', $user->id)->paginate(15);
            }

            return view('consultations.index', compact('consultations'));
        } catch (\Exception $e) {
            \Log::error('Consultations index failed', ['error' => $e->getMessage()]);
            return $this->error('Failed to load consultations.', 'ERR_CONSULTATION_INDEX');
        }
    }

    /**
     * Show single consultation.
     */
    public function show(Consultation $consultation)
    {
        try {
            $user = auth()->user();

            if (!$user->isAdmin() && $consultation->user_id !== $user->id) {
                return $this->unauthorized('You cannot view this consultation.');
            }

            return view('consultations.show', compact('consultation'));
        } catch (\Exception $e) {
            \Log::error('Consultation show failed', ['error' => $e->getMessage()]);
            return $this->notFound();
        }
    }

    /**
     * Delete consultation (user or admin only).
     */
    public function destroy(Consultation $consultation)
    {
        try {
            $user = auth()->user();

            if (!$user->isAdmin() && $consultation->user_id !== $user->id) {
                return $this->unauthorized('You cannot delete this consultation.');
            }

            $consultation->delete();

            return $this->success('Consultation deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Consultation deletion failed', ['error' => $e->getMessage()]);
            return $this->error('Failed to delete consultation.', 'ERR_CONSULTATION_DELETE');
        }
    }
}