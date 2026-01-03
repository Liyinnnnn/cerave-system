@extends('layouts.app')

@section('content')
<div class="py-10">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-2xl p-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Write a Review for {{ $product->name }}</h1>

            <form action="{{ route('reviews.store', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Rating</label>
                        <div class="flex items-center gap-1" id="starRating">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" data-value="{{ $i }}" class="p-1">
                                    <svg class="w-6 h-6 text-gray-300" viewBox="0 0 20 20" fill="currentColor"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating') }}" required>
                        @error('rating')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" class="w-full border-gray-300 rounded-lg" required maxlength="100">
                        @error('title')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Review</label>
                    <textarea name="content" rows="4" class="w-full border-gray-300 rounded-lg" required maxlength="2000">{{ old('content') }}</textarea>
                    @error('content')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Attachments (images/videos)</label>
                    <input type="file" name="attachments[]" multiple accept="image/*,video/*" class="w-full border-gray-300 rounded-lg">
                    <p class="text-xs text-gray-500 mt-1">You can upload multiple files. Supported: images and videos.</p>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('products.show', $product) }}" class="px-4 py-2 bg-gray-100 rounded-lg hover:bg-gray-200">Cancel</a>
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 font-semibold shadow-md hover:shadow-lg">Submit Review</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
// Star rating UI
const stars = document.querySelectorAll('#starRating button');
const input = document.getElementById('ratingInput');
function renderStars(val){
    stars.forEach((btn, idx) => {
        const svg = btn.querySelector('svg');
        if (idx < val) { svg.classList.remove('text-gray-300'); svg.classList.add('text-amber-400'); }
        else { svg.classList.add('text-gray-300'); svg.classList.remove('text-amber-400'); }
    });
}
stars.forEach(btn => btn.addEventListener('click', () => { input.value = btn.dataset.value; renderStars(parseInt(input.value)); }));
renderStars(parseInt(input.value || 0));
</script>
@endsection
