@extends('layouts.app') {{-- Or your actual layout file name --}}

@section('title', 'Our Skincare Products')

@section('content')
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-blue-900 mb-6">Our CeraVe Products</h1>

        <div class="grid md:grid-cols-3 sm:grid-cols-2 gap-6">
            {{-- Sample Product Card --}}
            <div class="bg-white shadow-lg rounded-lg p-4">
                <img src="{{ asset('images/sample-product.jpg') }}" alt="Product Image"
                    class="w-full h-48 object-cover rounded">
                <h2 class="text-lg font-semibold mt-4 text-gray-800">Hydrating Facial Cleanser</h2>
                <p class="text-sm text-gray-600 mt-2">Gentle cleanser for normal to dry skin.</p>
                <div class="mt-4">
                    <span class="text-blue-600 font-bold">RM55.90</span>
                </div>
            </div>
            {{-- You can loop your real products here later --}}
        </div>
    </div>
@endsection
