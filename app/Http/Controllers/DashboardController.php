<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the dashboard with dynamic products and content.
     */
    public function index()
    {
        // Fetch ALL products from database with pagination (12 per page) - aligned with products page
        $products = Product::with('reviews')->paginate(12);

        // Calculate average rating for each product
        $products->getCollection()->transform(function ($product) {
            $product->rating = round((float) $product->reviews()->avg('rating') ?? 4.5, 1);
            return $product;
        });

        return view('dashboard', compact('products'));
    }
}
