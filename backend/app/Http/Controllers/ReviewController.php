<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ReviewController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Review::with(['user', 'business', 'helpfulUsers']);

        if ($request->has('business_id')) {
            $query->where('business_id', $request->business_id);
        }

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('rating')) {
            $query->where('rating', $request->rating);
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        switch ($sortBy) {
            case 'rating':
                $query->orderBy('rating', $sortOrder);
                break;
            case 'helpful':
                $query->orderBy('helpful_count', $sortOrder);
                break;
            default:
                $query->orderBy('created_at', $sortOrder);
        }

        $reviews = $query->paginate(10);

        return response()->json($reviews);
    }

    public function show($id): JsonResponse
    {
        $review = Review::with(['user', 'business', 'helpfulUsers'])->findOrFail($id);
        return response()->json($review);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'rating' => 'required|integer|between:1,5',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'images' => 'nullable|array',
            'visit_date' => 'nullable|date'
        ]);

        // Check if user already reviewed this business
        $existingReview = Review::where('user_id', auth()->id())
                               ->where('business_id', $validated['business_id'])
                               ->first();

        if ($existingReview) {
            return response()->json(['error' => 'You have already reviewed this business'], 400);
        }

        $validated['user_id'] = auth()->id();

        $review = Review::create($validated);
        $review->load(['user', 'business']);

        return response()->json($review, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $review = Review::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'rating' => 'integer|between:1,5',
            'title' => 'string|max:255',
            'content' => 'string',
            'images' => 'nullable|array',
            'visit_date' => 'nullable|date'
        ]);

        $review->update($validated);
        $review->load(['user', 'business']);

        return response()->json($review);
    }

    public function destroy($id): JsonResponse
    {
        $review = Review::where('user_id', auth()->id())->findOrFail($id);
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }

    public function toggleHelpful(Request $request, $id): JsonResponse
    {
        $review = Review::findOrFail($id);
        $user = auth()->user();

        if ($review->user_id === $user->id) {
            return response()->json(['error' => 'Cannot mark your own review as helpful'], 400);
        }

        $isAlreadyHelpful = $review->helpfulUsers()->where('user_id', $user->id)->exists();

        if ($isAlreadyHelpful) {
            $review->helpfulUsers()->detach($user->id);
            $review->decrement('helpful_count');
            $action = 'removed';
        } else {
            $review->helpfulUsers()->attach($user->id);
            $review->increment('helpful_count');
            $action = 'added';
        }

        return response()->json([
            'action' => $action,
            'helpful_count' => $review->fresh()->helpful_count
        ]);
    }
}