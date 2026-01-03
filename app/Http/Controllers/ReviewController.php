<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Traits\ResponseHelper;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ResponseHelper;

    /**
     * Show form for creating a review (consumers only).
     */
    public function create(Product $product)
    {
        try {
            $user = auth()->user();

            if (!$user || (! $user->isConsumer() && ! $user->isConsultant() && ! $user->isAdmin())) {
                return $this->unauthorized('Only consumers, consultants, or admins can leave reviews.');
            }

            return view('reviews.create', compact('product'));
        } catch (\Exception $e) {
            \Log::error('Review create form failed', ['error' => $e->getMessage()]);
            return $this->error('Failed to load form.', 'ERR_REVIEW_FORM');
        }
    }

    /**
     * Store a new review (consumers only).
     */
    public function store(Request $request, Product $product)
    {
        \Log::info('Review store method called', [
            'product_id' => $product->id,
            'user_id' => $request->user() ? $request->user()->id : null,
            'request_data' => $request->all()
        ]);
        
        try {
            $user = $request->user();

            if (!$user || (! $user->isConsumer() && ! $user->isConsultant() && ! $user->isAdmin())) {
                \Log::warning('Unauthorized review attempt');
                return redirect()->back()->with('error', 'Only consumers, consultants, or admins can leave reviews.');
            }

            // Check if user already reviewed this product
            $existingReview = Review::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->first();

            if ($existingReview) {
                \Log::warning('Duplicate review attempt', ['user_id' => $user->id, 'product_id' => $product->id]);
                return redirect()->back()->with('error', 'You have already reviewed this product.');
            }

            $validated = $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'title' => 'required|string|max:100',
                'content' => 'required|string|min:10|max:2000',
                'attachments' => 'nullable',
                'attachments.*' => 'file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi,webm|max:51200',
            ]);

            $validated['user_id'] = $user->id;
            $validated['product_id'] = $product->id;
            $validated['verified_purchase'] = false; // Can be enhanced with order history

            // Handle attachments
            $media = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    if ($file && $file->isValid()) {
                        $path = $file->store('reviews', 'public');
                        $media[] = asset('storage/' . $path);
                    }
                }
            }

            $validated['media'] = $media;

                $review = Review::create($validated);

                \App\Models\Activity::create([
                    'user_id' => $user->id,
                    'action' => 'review.created',
                    'subject_type' => Review::class,
                    'subject_id' => $review->id,
                    'metadata' => [
                        'product_id' => $product->id,
                        'rating' => $validated['rating'],
                        'title' => $validated['title'] ?? null,
                    ],
                ]);
            
            \Log::info('Review created successfully', ['review_id' => $review->id]);

            return redirect()->route('products.show', $product)->with('success', 'Review posted successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Review validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Review creation failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to post review: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show review (public).
     */
    public function show(Review $review)
    {
        try {
            $comments = $review->comments()
                ->with(['user', 'children.user'])
                ->whereNull('parent_id')
                ->latest()
                ->paginate(10);

            return view('reviews.show', compact('review', 'comments'));
        } catch (\Exception $e) {
            \Log::error('Review show failed', ['error' => $e->getMessage()]);
            return $this->notFound('Review not found.');
        }
    }

    /**
     * Show edit form for review (owner or admin only).
     */
    public function edit(Review $review)
    {
        try {
            $user = auth()->user();

            if (!$user || (!$user->isAdmin() && $review->user_id !== $user->id)) {
                return $this->unauthorized('You cannot edit this review.');
            }

            return view('reviews.edit', compact('review'));
        } catch (\Exception $e) {
            \Log::error('Review edit form failed', ['error' => $e->getMessage()]);
            return $this->error('Failed to load form.', 'ERR_REVIEW_EDIT_FORM');
        }
    }

    /**
     * Update review (owner or admin only).
     */
    public function update(Request $request, Review $review)
    {
        try {
            $user = $request->user();

            if (!$user || (!$user->isAdmin() && $review->user_id !== $user->id)) {
                return redirect()->back()->with('error', 'You cannot edit this review.');
            }

            $validated = $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'title' => 'required|string|max:100',
                'content' => 'required|string|min:10|max:2000',
                'attachments' => 'nullable',
                'attachments.*' => 'file|mimes:jpg,jpeg,png,gif,webp,mp4,mov,avi,webm|max:51200',
            ]);

            // Handle attachments merge
            $media = $review->media ?? [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    if ($file && $file->isValid()) {
                        $path = $file->store('reviews', 'public');
                        $media[] = asset('storage/' . $path);
                    }
                }
            }
            $validated['media'] = $media;

                $review->update($validated);

                \App\Models\Activity::create([
                    'user_id' => $user->id,
                    'action' => 'review.updated',
                    'subject_type' => Review::class,
                    'subject_id' => $review->id,
                    'metadata' => [
                        'product_id' => $review->product_id,
                        'rating' => $validated['rating'],
                        'title' => $validated['title'] ?? null,
                    ],
                ]);

            return redirect()->route('products.show', $review->product)->with('success', 'Review updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Review update failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to update review.')->withInput();
        }
    }

    /**
     * Delete review (owner or admin only).
     */
    public function destroy(Review $review)
    {
        try {
            $user = auth()->user();

            if (!$user || (!$user->isAdmin() && $review->user_id !== $user->id)) {
                return redirect()->back()->with('error', 'You cannot delete this review.');
            }

            $productId = $review->product_id;
                $productId = $review->product_id;
                \App\Models\Activity::create([
                    'user_id' => $user->id,
                    'action' => 'review.deleted',
                    'subject_type' => Review::class,
                    'subject_id' => $review->id,
                    'metadata' => [
                        'product_id' => $review->product_id,
                        'title' => $review->title,
                    ],
                ]);
                $review->delete();

            return redirect()->route('products.show', $productId)->with('success', 'Review deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Review deletion failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to delete review.');
        }
    }
}
