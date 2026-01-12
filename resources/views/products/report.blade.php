@extends('layouts.guest')
@php use Illuminate\Support\Str; @endphp

@section('content')
<!-- Breadcrumb Navigation -->
<div class="bg-white border-b border-gray-200 shadow-sm sticky top-16 z-40 dark:bg-slate-900 dark:border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-3 text-sm py-3 text-gray-800 dark:text-gray-200">
            <a href="{{ route('products.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400">Products</a>
            <span>&gt;</span>
            <span class="text-gray-500 dark:text-gray-400">Reports</span>
        </nav>
    </div>
</div>

<div class="min-h-screen bg-gradient-to-br from-blue-100 via-blue-50 to-cyan-100 py-12 dark:from-indigo-950 dark:via-slate-900 dark:to-indigo-950">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2 dark:text-white">Products Report</h1>
            <p class="text-gray-600 dark:text-blue-200">Comprehensive overview of all products and inventory</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow-md p-4 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold dark:text-blue-300 uppercase">Total Products</p>
                        <p class="text-2xl font-bold text-gray-800 mt-1 dark:text-white">{{ $stats['total_products'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center dark:bg-blue-900">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold dark:text-blue-300 uppercase">Categories</p>
                        <p class="text-2xl font-bold text-green-600 mt-1 dark:text-green-400">{{ $stats['total_categories'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center dark:bg-green-900">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold dark:text-blue-300 uppercase">Total Reviews</p>
                        <p class="text-2xl font-bold text-yellow-600 mt-1 dark:text-yellow-400">{{ $stats['total_reviews'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center dark:bg-yellow-900">
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-4 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-600 font-semibold dark:text-blue-300 uppercase">Avg Rating</p>
                        <p class="text-2xl font-bold text-purple-600 mt-1 dark:text-purple-400">{{ $stats['average_rating'] ?? 'N/A' }}</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center dark:bg-purple-900">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters & Search -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
            <form action="{{ route('products.report') }}" method="GET" id="filterForm" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">Search Products</label>
                        <input type="text" name="search" placeholder="Search by name or ID..." value="{{ $search ?? '' }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">Category</label>
                        <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" @selected(($category ?? '') === $cat)>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Skin Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">Skin Type</label>
                        <select name="skin_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                            <option value="">All Types</option>
                            @foreach($skinTypes as $type)
                                <option value="{{ $type }}" @selected(($skinType ?? '') === $type)>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition text-sm font-medium dark:bg-blue-700 dark:hover:bg-blue-800">
                            Search
                        </button>
                        <a href="{{ route('products.report') }}" class="px-4 py-2 bg-gray-600 text-white text-center rounded-lg hover:bg-gray-700 transition text-sm font-medium dark:bg-gray-700 dark:hover:bg-gray-800">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Products Table -->
        @if($products->count() > 0)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">Product</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">Skin Type</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">Reviews</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">Created</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider dark:text-blue-200">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            @foreach($products as $product)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @php $primaryImage = $product->getPrimaryImage(); @endphp
                                            @if($primaryImage)
                                                <img src="{{ $primaryImage }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-lg object-cover">
                                            @else
                                                <div class="w-12 h-12 rounded-lg bg-gray-200 dark:bg-slate-700 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $product->name }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit(strip_tags($product->description), 50) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $product->category ?? 'Uncategorized' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($product->skin_type)
                                            @foreach(explode(',', $product->skin_type) as $type)
                                                <span class="inline-block px-2 py-1 rounded text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 mr-1 mb-1">
                                                    {{ ucfirst(trim($type)) }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-gray-400 text-sm dark:text-gray-500">All Types</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            {{ $product->reviews_count }} ⭐
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-blue-300">
                                        {{ $product->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex gap-2">
                                            <a href="{{ route('products.show', $product) }}" class="px-3 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-xs transition shadow-md dark:bg-gray-700 dark:hover:bg-gray-800">
                                                View
                                            </a>
                                            <a href="{{ route('products.edit', $product) }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-xs transition shadow-md dark:bg-blue-700 dark:hover:bg-blue-800">
                                                Edit
                                            </a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-xs transition shadow-md dark:bg-red-700 dark:hover:bg-red-800">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-12 text-center dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <svg class="w-20 h-20 mx-auto text-gray-400 mb-4 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-800 mb-2 dark:text-white">No Products Found</h3>
                <p class="text-gray-600 dark:text-blue-200 mb-6">Try adjusting your filters or create a new product.</p>
                <a href="{{ route('products.create') }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md dark:bg-blue-700 dark:hover:bg-blue-800">
                    Add Product
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
