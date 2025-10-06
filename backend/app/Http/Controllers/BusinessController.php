<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BusinessController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Business::with(['category', 'reviews' => function($q) {
            $q->latest()->take(3)->with('user');
        }]);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('address', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('min_rating')) {
            $query->where('average_rating', '>=', $request->min_rating);
        }

        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');

        switch ($sortBy) {
            case 'rating':
                $query->orderBy('average_rating', $sortOrder);
                break;
            case 'reviews':
                $query->orderBy('total_reviews', $sortOrder);
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('name', $sortOrder);
        }

        $query->where('is_active', true);

        $businesses = $query->paginate(12);

        return response()->json($businesses);
    }

    public function show($id): JsonResponse
    {
        $business = Business::with([
            'category',
            'reviews' => function($q) {
                $q->latest()->with(['user', 'helpfulUsers']);
            }
        ])->findOrFail($id);

        return response()->json($business);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'address' => 'required|string',
            'phone' => 'nullable|string',
            'website' => 'nullable|url',
            'business_hours' => 'nullable|array',
            'images' => 'nullable|array',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180'
        ]);

        $business = Business::create($validated);
        return response()->json($business, 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $business = Business::findOrFail($id);

        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'category_id' => 'exists:categories,id',
            'address' => 'string',
            'phone' => 'nullable|string',
            'website' => 'nullable|url',
            'business_hours' => 'nullable|array',
            'images' => 'nullable|array',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_active' => 'boolean'
        ]);

        $business->update($validated);
        return response()->json($business);
    }

    public function destroy($id): JsonResponse
    {
        $business = Business::findOrFail($id);
        $business->delete();
        return response()->json(['message' => 'Business deleted successfully']);
    }
}