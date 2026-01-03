@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-2xl p-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit Review</h1>

            <form action="{{ route('reviews.update', $review) }}" method="POST" class="space-y-5">
                @csrf
                @method('PATCH')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Rating</label>
                        <select name="rating" class="w-full border-gray-300 rounded-lg" required>
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" @selected(old('rating', $review->rating)==$i)>{{ $i }} star{{ $i === 1 ? '' : 's' }}</option>
                            @endfor
                        </select>
                        @error('rating')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" value="{{ old('title', $review->title) }}" class="w-full border-gray-300 rounded-lg" required maxlength="100">
                        @error('title')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Review</label>
                    <textarea name="content" rows="4" class="w-full border-gray-300 rounded-lg" required maxlength="2000">{{ old('content', $review->content) }}</textarea>
                    @error('content')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('products.show', $review->product_id) }}" class="px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200">Cancel</a>
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 font-semibold shadow-md hover:shadow-lg">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
