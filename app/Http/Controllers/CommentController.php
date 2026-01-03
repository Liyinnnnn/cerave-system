<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Review;
use App\Traits\ResponseHelper;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use ResponseHelper;

    /**
     * Store a comment on a review (consumers and consultants can reply).
     */
    public function store(Request $request, Review $review)
    {
        try {
            $user = $request->user();

            if (!$user || (! $user->isConsumer() && ! $user->isConsultant() && ! $user->isAdmin())) {
                return redirect()->back()->with('error', 'Only consumers, consultants, or admins can comment.');
            }

            $validated = $request->validate([
                'content' => 'required|string|min:5|max:1000',
                'parent_id' => 'nullable|exists:comments,id',
            ]);

            // Ensure parent comment (if any) belongs to the same review to avoid cross-post replies
            if (!empty($validated['parent_id'])) {
                $parent = Comment::where('id', $validated['parent_id'])->where('review_id', $review->id)->first();
                if (!$parent) {
                    return redirect()->back()->withErrors(['parent_id' => 'Parent comment not found for this review.'])->withInput();
                }
            }

            $validated['user_id'] = $user->id;
            $validated['review_id'] = $review->id;

            $comment = Comment::create($validated);

            \App\Models\Activity::create([
                'user_id' => $user->id,
                'action' => 'comment.created',
                'subject_type' => Comment::class,
                'subject_id' => $comment->id,
                'metadata' => [
                    'review_id' => $review->id,
                    'parent_id' => $validated['parent_id'] ?? null,
                ],
            ]);

            return redirect()->route('products.show', ['product' => $review->product_id])->with('success', 'Comment posted successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Comment creation failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to post comment.')->withInput();
        }
    }

    /**
     * Update comment (owner or admin only).
     */
    public function update(Request $request, Comment $comment)
    {
        try {
            $user = $request->user();

            if (!$user || (!$user->isAdmin() && $comment->user_id !== $user->id)) {
                return $this->unauthorized('You cannot edit this comment.');
            }

            $validated = $request->validate([
                'content' => 'required|string|min:5|max:1000',
            ]);

            $comment->update($validated);

            \App\Models\Activity::create([
                'user_id' => $user->id,
                'action' => 'comment.updated',
                'subject_type' => Comment::class,
                'subject_id' => $comment->id,
                'metadata' => [
                    'review_id' => $comment->review_id,
                ],
            ]);

            return $this->success('Comment updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->validationError($e->errors());
        } catch (\Exception $e) {
            \Log::error('Comment update failed', ['error' => $e->getMessage()]);
            return $this->error('Failed to update comment.', 'ERR_COMMENT_UPDATE');
        }
    }

    /**
     * Delete comment (owner or admin only).
     */
    public function destroy(Comment $comment)
    {
        try {
            $user = auth()->user();

            if (!$user || (!$user->isAdmin() && $comment->user_id !== $user->id)) {
                return redirect()->back()->with('error', 'You cannot delete this comment.');
            }

            $productId = $comment->review->product_id;
            
            \App\Models\Activity::create([
                'user_id' => $user->id,
                'action' => 'comment.deleted',
                'subject_type' => Comment::class,
                'subject_id' => $comment->id,
                'metadata' => [
                    'review_id' => $comment->review_id,
                ],
            ]);
            $comment->delete();

            return redirect()->route('products.show', $productId)->with('success', 'Comment deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Comment deletion failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to delete comment.');
        }
    }
}
