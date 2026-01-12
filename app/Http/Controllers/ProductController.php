<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Traits\ResponseHelper;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ResponseHelper;

    /**
     * Handle retailer logo uploads
     */
    private function processRetailerLogos(Request $request, array $validated): array
    {
        $processedLogos = [];
        
        // Get existing logos from hidden inputs
        $existingLogos = $request->input('retailer_logos_existing', []);
        
        // Get uploaded files
        $uploadedFiles = $request->file('retailer_logos', []);
        
        // Determine the maximum count (from external_urls)
        $count = count($validated['external_urls'] ?? []);
        
        for ($index = 0; $index < $count; $index++) {
            // Check if a new file was uploaded for this index
            if (isset($uploadedFiles[$index]) && $uploadedFiles[$index]) {
                // Store new logo in public/retailer-logos folder
                $path = $uploadedFiles[$index]->store('retailer-logos', 'public');
                $processedLogos[] = '/storage/' . $path;
            } else {
                // Keep existing logo if present
                $processedLogos[] = $existingLogos[$index] ?? '';
            }
        }
        
        // Remove empty strings from the array
        $validated['retailer_logos'] = array_values(array_filter($processedLogos, fn($logo) => !empty($logo)));
        
        return $validated;
    }

    /**
     * Display a listing of products (public for all).
     */
    public function index(Request $request)
    {
        try {
            $search = $request->query('search', '');
            $category = $request->query('category', '');
            $skinType = $request->query('skin_type', '');
            $sort = $request->query('sort', 'newest');

            $query = Product::query();

            // Search filter
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('ingredients', 'like', "%{$search}%");
                });
            }

            // Category filter
            if ($category) {
                $query->where('category', $category);
            }

            // Skin type filter
            if ($skinType) {
                $query->where(function($q) use ($skinType) {
                    $q->where('skin_type', 'like', "%{$skinType}%")
                      ->orWhereNull('skin_type')
                      ->orWhere('skin_type', '');
                });
            }

            // Sorting
            switch ($sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'newest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            $products = $query->paginate(12)->appends($request->query());

            // Get filter options
            $categories = Product::distinct()->pluck('category')->filter()->sort()->values();
            $skinTypes = ['dry', 'oily', 'combination', 'sensitive', 'normal'];

            return view('products.index', compact('products', 'search', 'category', 'skinType', 'sort', 'categories', 'skinTypes'));
        } catch (\Exception $e) {
            \Log::error('Products index failed', ['error' => $e->getMessage()]);
            return $this->error('Failed to load products.', 'ERR_PRODUCT_INDEX');
        }
    }

    /**
     * Admin Products Report
     */
    public function report(Request $request)
    {
        // Check admin access
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        try {
            $search = $request->query('search', '');
            $category = $request->query('category', '');
            $skinType = $request->query('skin_type', '');
            $sort = $request->query('sort', 'newest');

            $query = Product::withCount('reviews');

            // Search filter (by name, category, or ID)
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%")
                      ->orWhere('id', $search);
                });
            }

            // Category filter
            if ($category) {
                $query->where('category', $category);
            }

            // Skin type filter
            if ($skinType) {
                $query->where(function($q) use ($skinType) {
                    $q->where('skin_type', 'like', "%{$skinType}%")
                      ->orWhereNull('skin_type')
                      ->orWhere('skin_type', '');
                });
            }

            // Sorting
            switch ($sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'reviews_high':
                    $query->orderBy('reviews_count', 'desc');
                    break;
                case 'reviews_low':
                    $query->orderBy('reviews_count', 'asc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'newest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            $products = $query->paginate(20)->appends($request->query());

            // Statistics
            $stats = [
                'total_products' => Product::count(),
                'total_categories' => Product::distinct()->count('category'),
                'total_reviews' => \App\Models\Review::count(),
                'average_rating' => round(\App\Models\Review::avg('rating'), 2),
            ];

            // Get filter options
            $categories = Product::distinct()->pluck('category')->filter()->sort()->values();
            $skinTypes = ['dry', 'oily', 'combination', 'sensitive', 'normal'];

            return view('products.report', compact('products', 'stats', 'search', 'category', 'skinType', 'sort', 'categories', 'skinTypes'));
        } catch (\Exception $e) {
            \Log::error('Products report failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to load products report.');
        }
    }

    /**
     * Show product detail page (public).
     */
    public function show(Product $product)
    {
        try {
            $reviews = $product->reviews()
                ->with(['user', 'comments.user', 'comments.children.user'])
                ->latest()
                ->paginate(10);
            $averageRating = round((float) $product->reviews()->avg('rating'), 1);
            $reviewCount = $product->reviews()->count();

            return view('products.show', compact('product', 'reviews', 'averageRating', 'reviewCount'));
        } catch (\Exception $e) {
            \Log::error('Product show failed', ['error' => $e->getMessage()]);
            return $this->notFound('Product not found.');
        }
    }

    /**
     * Show form for creating a product (admin only).
     */
    public function create()
    {
        try {
            $imageFiles = array_values(array_filter(scandir(public_path('images')), function($file) {
                return !in_array($file, ['.', '..']) && is_file(public_path('images/' . $file));
            }));
            
            // Get distinct categories from existing products
            $categories = Product::distinct()
                ->whereNotNull('category')
                ->where('category', '!=', '')
                ->orderBy('category')
                ->pluck('category')
                ->unique()
                ->values()
                ->toArray();
            
            return view('products.create', compact('imageFiles', 'categories'));
        } catch (\Exception $e) {
            \Log::error('Product create form failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to load form.');
        }
    }

    /**
     * Store a newly created product (admin only).
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:products',
                'description' => 'nullable|string|max:10000',
                'price' => 'nullable|numeric|min:0.01|max:99999.99',
                'category' => 'required|string|max:100',
                'image_url' => 'nullable|url',
                'images' => 'nullable|array|max:10',
                'images.*' => 'string',
                'ingredients' => 'nullable|string|max:10000',
                'directions' => 'nullable|string|max:10000',
                'skin_types' => 'nullable|array|max:5',
                'skin_types.*' => 'string|in:dry,oily,combination,sensitive,normal',
                'benefits' => 'nullable|string|max:10000',
                'external_url' => 'nullable|url',
                'external_urls' => 'nullable|array|max:10',
                'external_urls.*' => 'url',
                'retailer_names' => 'nullable|array|max:10',
                'retailer_names.*' => 'string|max:255',
                'retailer_logos' => 'nullable|array|max:10',
                'retailer_logos.*' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
                'features' => 'nullable|array|max:20',
                'features.*.image' => 'nullable|string',
                'features.*.text' => 'nullable|string|max:2000',
            ]);

            // Process images array, remove empty strings
            if (isset($validated['images'])) {
                $validated['images'] = array_values(array_filter($validated['images'], fn($url) => !empty($url)));
            }

            // Convert skin_types array to comma-separated string
            if (isset($validated['skin_types']) && is_array($validated['skin_types']) && !empty($validated['skin_types'])) {
                $validated['skin_type'] = implode(',', $validated['skin_types']);
            } else {
                $validated['skin_type'] = null;
            }
            unset($validated['skin_types']);

            // Process external URLs array, remove empty strings
            if (isset($validated['external_urls'])) {
                $validated['external_urls'] = array_values(array_filter($validated['external_urls'], fn($url) => !empty($url)));
            }

            // Process retailer names array, remove empty strings
            if (isset($validated['retailer_names'])) {
                $validated['retailer_names'] = array_values(array_filter($validated['retailer_names'], fn($name) => !empty($name)));
            }

            // Align retailer_names length with external_urls for label mapping
            if (isset($validated['external_urls']) && isset($validated['retailer_names'])) {
                $count = count($validated['external_urls']);
                $validated['retailer_names'] = array_slice($validated['retailer_names'], 0, $count);
                if (count($validated['retailer_names']) < $count) {
                    $validated['retailer_names'] = array_pad($validated['retailer_names'], $count, '');
                }
            }

            // Process features blocks: keep entries having image or text
            if (isset($validated['features'])) {
                $validated['features'] = array_values(array_filter($validated['features'], function ($feature) {
                    if (!is_array($feature)) return false;
                    $image = $feature['image'] ?? '';
                    $text = trim($feature['text'] ?? '');
                    return !empty($image) || !empty($text);
                }));
            }

            // Process retailer logos
            $validated = $this->processRetailerLogos($request, $validated);

            $product = Product::create($validated);

            return redirect()->route('products.show', $product)->with('success', 'Product created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Product creation failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to create product: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show form for editing a product (admin only).
     */
    public function edit(Product $product)
    {
        try {
            $imageFiles = array_values(array_filter(scandir(public_path('images')), function($file) {
                return !in_array($file, ['.', '..']) && is_file(public_path('images/' . $file));
            }));
            $externalUrls = $product->external_urls ?? [];
            
            // Get distinct categories from existing products
            $categories = Product::distinct()
                ->whereNotNull('category')
                ->where('category', '!=', '')
                ->orderBy('category')
                ->pluck('category')
                ->unique()
                ->values()
                ->toArray();
            
            return view('products.edit', compact('product', 'imageFiles', 'externalUrls', 'categories'));
        } catch (\Exception $e) {
            \Log::error('Product edit form failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to load form.');
        }
    }

    /**
     * Update a product (admin only).
     */
    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'name' => "required|string|max:255|unique:products,name,{$product->id}",
                'description' => 'nullable|string|max:10000',
                'price' => 'nullable|numeric|min:0.01|max:99999.99',
                'category' => 'required|string|max:100',
                'image_url' => 'nullable|url',
                'images' => 'nullable|array|max:10',
                'images.*' => 'string',
                'ingredients' => 'nullable|string|max:10000',
                'directions' => 'nullable|string|max:10000',
                'skin_types' => 'nullable|array|max:5',
                'skin_types.*' => 'string|in:dry,oily,combination,sensitive,normal',
                'benefits' => 'nullable|string|max:10000',
                'external_url' => 'nullable|url',
                'external_urls' => 'nullable|array|max:10',
                'external_urls.*' => 'url',
                'retailer_names' => 'nullable|array|max:10',
                'retailer_names.*' => 'string|max:255',
                'retailer_logos' => 'nullable|array|max:10',
                'retailer_logos.*' => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
                'features' => 'nullable|array|max:20',
                'features.*.image' => 'nullable|string',
                'features.*.text' => 'nullable|string|max:2000',
            ]);

            // Process images array, remove empty strings
            if (isset($validated['images'])) {
                $validated['images'] = array_values(array_filter($validated['images'], fn($url) => !empty($url)));
            }

            // Convert skin_types array to comma-separated string
            if (isset($validated['skin_types']) && is_array($validated['skin_types']) && !empty($validated['skin_types'])) {
                $validated['skin_type'] = implode(',', $validated['skin_types']);
            } else {
                $validated['skin_type'] = null;
            }
            unset($validated['skin_types']);

            // Process external URLs array, remove empty strings
            if (isset($validated['external_urls'])) {
                $validated['external_urls'] = array_values(array_filter($validated['external_urls'], fn($url) => !empty($url)));
            }

            // Process retailer names array, remove empty strings
            if (isset($validated['retailer_names'])) {
                $validated['retailer_names'] = array_values(array_filter($validated['retailer_names'], fn($name) => !empty($name)));
            }

            // Align retailer_names length with external_urls for label mapping
            if (isset($validated['external_urls']) && isset($validated['retailer_names'])) {
                $count = count($validated['external_urls']);
                $validated['retailer_names'] = array_slice($validated['retailer_names'], 0, $count);
                if (count($validated['retailer_names']) < $count) {
                    $validated['retailer_names'] = array_pad($validated['retailer_names'], $count, '');
                }
            }

            // Process features blocks: keep entries having image or text
            if (isset($validated['features'])) {
                $validated['features'] = array_values(array_filter($validated['features'], function ($feature) {
                    if (!is_array($feature)) return false;
                    $image = $feature['image'] ?? '';
                    $text = trim($feature['text'] ?? '');
                    return !empty($image) || !empty($text);
                }));
            }

            // Process retailer logos
            $validated = $this->processRetailerLogos($request, $validated);

            $product->update($validated);

            return redirect()->route('products.show', $product)->with('success', 'Product updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Product update failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to update product: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Delete a product (admin only).
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Product deletion failed', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Failed to delete product.');
        }
    }
}
