@extends('layouts.guest')
@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 py-12 dark:from-indigo-950 dark:via-slate-900 dark:to-indigo-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800 dark:text-white mb-2">📊 Products Report</h1>
                    <p class="text-gray-600 dark:text-blue-200">Comprehensive overview of all products in the system</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('products.index') }}" class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition shadow-md dark:bg-gray-700 dark:hover:bg-gray-800">
                        ← Back to Products
                    </a>
                    <a href="{{ route('products.create') }}" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md dark:bg-blue-700 dark:hover:bg-blue-800">
                        ➕ Add Product
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-l-blue-400 border-gray-100 dark:border-gray-800 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Total Products</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_products'] }}</p>
                    </div>
                    <div class="text-4xl">📦</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-l-green-400 border-gray-100 dark:border-gray-800 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Categories</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_categories'] }}</p>
                    </div>
                    <div class="text-4xl">🏷️</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-l-purple-400 border-gray-100 dark:border-gray-800 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Total Reviews</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_reviews'] }}</p>
                    </div>
                    <div class="text-4xl">⭐</div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-l-orange-400 border-gray-100 dark:border-gray-800 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Avg Rating</p>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['average_rating'] ?? 'N/A' }}</p>
                    </div>
                    <div class="text-4xl">📊</div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="mb-8 bg-white rounded-xl shadow-lg p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
            <form action="{{ route('products.report') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Search</label>
                        <input type="text" name="search" placeholder="Search by name..." value="{{ $search ?? '' }}" onchange="this.form.submit()"
                            class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Category</label>
                        <select name="category" onchange="this.form.submit()" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" @selected(($category ?? '') === $cat)>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Skin Type -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Skin Type</label>
                        <select name="skin_type" onchange="this.form.submit()" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-800 dark:border-slate-700 dark:text-white">
                            <option value="">All Types</option>
                            @foreach($skinTypes as $type)
                                <option value="{{ $type }}" @selected(($skinType ?? '') === $type)>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-end">
                        <a href="{{ route('products.report') }}" class="w-full px-4 py-2 bg-gray-200 text-center text-gray-700 dark:bg-slate-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition">
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Products Table -->
        @if($products->count() > 0)
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-8 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-slate-800">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider dark:text-gray-300">Product</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider dark:text-gray-300">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider dark:text-gray-300">Skin Type</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider dark:text-gray-300">Reviews</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider dark:text-gray-300">Created</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider dark:text-gray-300">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            @foreach($products as $product)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-800 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            @php $primaryImage = $product->getPrimaryImage(); @endphp
                                            @if($primaryImage)
                                                <img src="{{ $primaryImage }}" alt="{{ $product->name }}" class="w-16 h-16 rounded-lg object-cover border-2 border-blue-100 dark:border-blue-900">
                                            @else
                                                <div class="w-16 h-16 rounded-lg bg-gray-200 dark:bg-slate-700 flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $product->name }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit(strip_tags($product->description), 50) }}</p>
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
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span class="text-gray-900 dark:text-white font-semibold">{{ $product->reviews_count }}</span>
                                            <span class="text-yellow-400">⭐</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-blue-100 text-sm">
                                        {{ $product->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex gap-2 justify-end">
                                            <a href="{{ route('products.show', $product) }}" class="px-3 py-2 bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-gray-200 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 text-sm font-semibold transition">
                                                👁️ View
                                            </a>
                                            <a href="{{ route('products.edit', $product) }}" class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-semibold transition">
                                                ✏️ Edit
                                            </a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-semibold transition">
                                                    🗑️
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
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-12 text-center dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                <div class="text-6xl mb-4">📦</div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No Products Found</h3>
                <p class="text-gray-600 dark:text-blue-200 mb-6">Try adjusting your filters or create a new product.</p>
                <a href="{{ route('products.create') }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    ➕ Add Your First Product
                </a>
            </div>
        @endif
    </div>
</div>

<style>
@media print {
    .no-print { display: none !important; }
}
</style>
@endsection
