@extends('layouts.guest')

@php use Illuminate\Support\Str; @endphp

@section('content')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .hero-gradient {
            background: linear-gradient(90deg, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0.9) 50%, rgba(255, 255, 255, 0) 100%);
        }

        .custom-checkbox {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #0077b6;
            border-radius: 4px;
            outline: none;
            cursor: pointer;
            position: relative;
        }

        .custom-checkbox:checked {
            background-color: #0077b6;
        }

        .custom-checkbox:checked::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 6px;
            width: 6px;
            height: 12px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .custom-switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .custom-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #0077b6;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        .custom-radio {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #0077b6;
            border-radius: 50%;
            outline: none;
            cursor: pointer;
            position: relative;
        }

        .custom-radio:checked {
            border: 2px solid #0077b6;
        }

        .custom-radio:checked::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #0077b6;
        }

        .custom-range {
            -webkit-appearance: none;
            width: 100%;
            height: 8px;
            border-radius: 5px;
            background: #e0e0e0;
            outline: none;
        }

        .custom-range::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #0077b6;
            cursor: pointer;
        }

        .custom-range::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #0077b6;
            cursor: pointer;
            border: none;
        }
    </style>
        <!-- Header -->
        {{-- <header class="bg-white shadow-sm sticky top-0 z-50">
            <div class="container mx-auto px-4 py-3 flex items-center justify-between">
                <div class="flex items-center">
                    <a href="#" class="text-3xl font-['Pacifico'] text-primary mr-10">CeraVe</a>
                    <nav class="hidden md:flex space-x-8">
                        <a href="https://readdy.ai/home/9aae7cdb-f05b-4449-8f4e-4fc150ba59bd/6a3883ca-87bf-4fe9-9c5e-e4986db27172"
                            data-readdy="true" class="text-gray-800 hover:text-primary font-medium">Products</a>
                        <a href="#" class="text-gray-800 hover:text-primary font-medium">Skin Concerns</a>
                        <a href="#" class="text-gray-800 hover:text-primary font-medium">Dr. C Consultation</a>
                        <a href="#" class="text-gray-800 hover:text-primary font-medium">Appointments</a>
                        <a href="#" class="text-gray-800 hover:text-primary font-medium">Locate Us</a>
                    </nav>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative w-10 h-10 flex items-center justify-center">
                        <i class="ri-search-line text-gray-600 ri-xl"></i>
                    </div>
                    <div class="relative w-10 h-10 flex items-center justify-center">
                        <i class="ri-user-line text-gray-600 ri-xl"></i>
                    </div>
                    <div class="relative w-10 h-10 flex items-center justify-center">
                        <i class="ri-shopping-bag-line text-gray-600 ri-xl"></i>
                        <span
                            class="absolute -top-1 -right-1 bg-primary text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">3</span>
                    </div>
                    <button
                        class="bg-primary text-white px-6 py-2 !rounded-button font-medium whitespace-nowrap hidden md:block">Sign
                        In</button>
                </div>
            </div>
        </header> --}}
        <!-- Hero Section -->
        <section class="relative overflow-hidden">
            <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover z-0">
                <source src="{{ asset('videos/CERAMIDES_MODULE_Video_Finalmp4.mp4') }}" type="video/mp4">
            </video>
            <div class="relative container mx-auto px-4 py-20 flex items-center">
                <div class="hero-gradient w-full md:w-1/2 p-10 rounded-lg">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">Healthy Skin Starts with Science</h1>
                    <p class="text-lg text-gray-700 mb-8">Developed with dermatologists, our skincare solutions are designed
                        to restore and maintain your skin's natural protective barrier.</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('products.index') }}" class="bg-primary text-white px-8 py-3 !rounded-button font-medium whitespace-nowrap inline-flex items-center justify-center">Our
                            Products</a>
                        <button
                            class="bg-white border-2 border-primary text-primary px-8 py-3 !rounded-button font-medium whitespace-nowrap">Consult
                            Dr. C</button>
                    </div>
                </div>
            </div>
        </section>
        <!-- Featured Products -->
        <section id="products" data-section="products" class="py-16 bg-gray-50 dark:bg-indigo-900">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4 dark:text-white">Our Bestselling Products</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto dark:text-blue-200">Discover our most loved formulations, designed to address
                        various skin concerns while maintaining your skin's natural barrier.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    @forelse ($products as $product)
                        <a href="{{ route('products.show', $product->id, false) }}" class="block bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1 cursor-pointer dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                            <div class="h-64 overflow-hidden bg-gray-200 flex items-center justify-center">
                                @php
                                    $primaryImage = $product->getPrimaryImage();
                                @endphp
                                @if($primaryImage)
                                    <img src="{{ $primaryImage }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover object-top">
                                @else
                                    <div class="flex flex-col items-center justify-center h-full text-gray-400">
                                        <svg class="w-20 h-20 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-sm">No image</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="bg-blue-100 text-primary text-xs px-3 py-1 rounded-full dark:bg-blue-900 dark:text-blue-200">{{ $product->category ?? 'Featured' }}</span>
                                    <div class="flex">
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($i < floor($product->rating ?? 4))
                                                <i class="ri-star-fill text-yellow-400"></i>
                                            @else
                                                <i class="ri-star-line text-yellow-400"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800 mb-2 dark:text-white">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-sm mb-4 dark:text-gray-300">{{ Str::limit(strip_tags($product->description), 50) }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full text-center py-12">
                            <p class="text-gray-500">No products available yet.</p>
                        </div>
                    @endforelse
                </div>
                <!-- Pagination - Only show if using Paginator (has links method) -->
                @if (method_exists($products, 'links'))
                    <div class="flex justify-center my-8">
                        {{ $products->links('pagination::tailwind') }}
                    </div>
                @endif
                <div class="text-center mt-10">
                    <a href="{{ route('products.index') }}"
                        class="inline-block bg-white border-2 border-primary text-primary px-8 py-3 !rounded-button font-medium whitespace-nowrap dark:bg-transparent dark:border-blue-400 dark:text-blue-200">View
                        All Products</a>
                </div>
            </div>
        </section>
        <!-- Dr. C Consultation -->
        <section id="consultant" data-section="consultant" class="py-16 bg-white dark:bg-indigo-900">
            <div class="container mx-auto px-4">
                <div class="flex flex-col lg:flex-row items-center gap-12">
                    <div class="lg:w-1/2">
                        <img src="https://readdy.ai/api/search-image?query=Futuristic%20AI%20skincare%20consultation%20interface%20with%20blue%20holographic%20elements%2C%20showing%20skin%20analysis%2C%20professional%20medical%20technology%2C%20dermatology%20diagnostic%20tool%2C%20clean%20clinical%20aesthetic%2C%20high-tech%20skincare%20analysis%2C%20digital%20skin%20assessment&width=600&height=500&seq=drc&orientation=landscape"
                            alt="Dr. C Consultation" class="rounded-xl shadow-lg w-full">
                    </div>
                    <div class="lg:w-1/2">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4 dark:text-white">Meet Dr. C: Your AI Skincare Advisor</h2>
                        <p class="text-gray-600 mb-6 dark:text-blue-200">Get personalized skincare recommendations based on your unique skin
                            profile. Our advanced AI analyzes your skin concerns and suggests the perfect routine for your
                            needs.</p>
                        <div class="space-y-4 mb-8">
                            <div class="flex items-start">
                                <div class="w-10 h-10 flex items-center justify-center bg-blue-100 rounded-full mr-4 dark:bg-blue-900">
                                    <i class="ri-checkbox-circle-line text-primary ri-lg"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800 dark:text-white">Personalized Analysis</h3>
                                    <p class="text-gray-600 text-sm dark:text-blue-200">Get a detailed assessment of your skin's unique needs
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-10 h-10 flex items-center justify-center bg-blue-100 rounded-full mr-4 dark:bg-blue-900">
                                    <i class="ri-chat-1-line text-primary ri-lg"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800 dark:text-white">Interactive Consultation</h3>
                                    <p class="text-gray-600 text-sm dark:text-blue-200">Chat with our AI to discuss your skin concerns in
                                        detail</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-10 h-10 flex items-center justify-center bg-blue-100 rounded-full mr-4 dark:bg-blue-900">
                                    <i class="ri-file-list-3-line text-primary ri-lg"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800 dark:text-white">Custom Routine</h3>
                                    <p class="text-gray-600 text-sm dark:text-blue-200">Receive a tailored skincare regimen with product
                                        recommendations</p>
                                </div>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('consultation.submit') }}" class="space-y-4 mt-6">
                            @csrf
                            <label for="concerns" class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">Describe your skin
                                concerns</label>
                            <textarea id="concerns" data-section="concerns" name="concerns" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary"
                                placeholder="E.g. dry patches, acne, sensitivity..."></textarea>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <button
                                    class="bg-primary text-white px-8 py-3 !rounded-button font-medium whitespace-nowrap">Start
                                    Consultation</button>
                        </form>
                        @if (session('response'))
                            <div class="mt-6 bg-blue-50 p-4 rounded shadow text-gray-800">
                                <h4 class="font-semibold mb-2">Dr. C's Recommendation:</h4>
                                <p>{{ session('response') }}</p>
                            </div>
                        @endif
                        <button
                            class="bg-white border-2 border-primary text-primary px-8 py-3 !rounded-button font-medium whitespace-nowrap dark:bg-transparent dark:border-blue-400 dark:text-blue-200">Book
                            with a Consultant</button>
                    </div>
                </div>
            </div>
            </div>
        </section>
        <!-- Skin Concerns -->
        <section id="concerns" data-section="concerns" class="py-16 bg-gray-50 dark:bg-indigo-900">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4 dark:text-white">Solutions for Every Skin Concern</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto dark:text-blue-200">Explore targeted solutions for specific skin needs,
                        developed with dermatologists to address your unique concerns.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Concern 1 -->
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                        <div class="h-48 overflow-hidden">
                            <img src="https://readdy.ai/api/search-image?query=Close-up%20of%20dry%20skin%20with%20flaky%20texture%2C%20clinical%20dermatology%20image%2C%20medical%20skin%20condition%2C%20professional%20photography%2C%20clean%20white%20background%2C%20dermatological%20reference%20image&width=500&height=300&seq=skin1&orientation=landscape"
                                alt="Dry Skin" class="w-full h-full object-cover object-top">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-3 dark:text-white">Dry Skin</h3>
                            <p class="text-gray-600 mb-4 dark:text-blue-200">Restore moisture and strengthen your skin's natural barrier with
                                our hydrating formulas.</p>
                            <a href="#" class="text-primary font-medium flex items-center">
                                Explore Solutions
                                <i class="ri-arrow-right-line ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Concern 2 -->
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                        <div class="h-48 overflow-hidden">
                            <img src="https://readdy.ai/api/search-image?query=Close-up%20of%20acne-prone%20skin%20with%20visible%20blemishes%2C%20clinical%20dermatology%20image%2C%20medical%20skin%20condition%2C%20professional%20photography%2C%20clean%20white%20background%2C%20dermatological%20reference%20image&width=500&height=300&seq=skin2&orientation=landscape"
                                alt="Acne-Prone Skin" class="w-full h-full object-cover object-top">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-3 dark:text-white">Acne-Prone Skin</h3>
                            <p class="text-gray-600 mb-4 dark:text-blue-200">Clear breakouts and prevent new ones with our gentle yet
                                effective acne-fighting products.</p>
                            <a href="#" class="text-primary font-medium flex items-center">
                                Explore Solutions
                                <i class="ri-arrow-right-line ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Concern 3 -->
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                        <div class="h-48 overflow-hidden">
                            <img src="https://readdy.ai/api/search-image?query=Close-up%20of%20sensitive%20skin%20with%20redness%20and%20irritation%2C%20clinical%20dermatology%20image%2C%20medical%20skin%20condition%2C%20professional%20photography%2C%20clean%20white%20background%2C%20dermatological%20reference%20image&width=500&height=300&seq=skin3&orientation=landscape"
                                alt="Sensitive Skin" class="w-full h-full object-cover object-top">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-3 dark:text-white">Sensitive Skin</h3>
                            <p class="text-gray-600 mb-4 dark:text-blue-200">Soothe irritation and strengthen your skin's protective barrier
                                with our gentle formulations.</p>
                            <a href="#" class="text-primary font-medium flex items-center">
                                Explore Solutions
                                <i class="ri-arrow-right-line ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Concern 4 -->
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                        <div class="h-48 overflow-hidden">
                            <img src="https://readdy.ai/api/search-image?query=Close-up%20of%20aging%20skin%20with%20fine%20lines%20and%20wrinkles%2C%20clinical%20dermatology%20image%2C%20medical%20skin%20condition%2C%20professional%20photography%2C%20clean%20white%20background%2C%20dermatological%20reference%20image&width=500&height=300&seq=skin4&orientation=landscape"
                                alt="Aging Skin" class="w-full h-full object-cover object-top">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-3 dark:text-white">Aging Skin</h3>
                            <p class="text-gray-600 mb-4 dark:text-blue-200">Target fine lines and improve elasticity with our anti-aging
                                formulas that work with your skin.</p>
                            <a href="#" class="text-primary font-medium flex items-center">
                                Explore Solutions
                                <i class="ri-arrow-right-line ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Concern 5 -->
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                        <div class="h-48 overflow-hidden">
                            <img src="https://readdy.ai/api/search-image?query=Close-up%20of%20oily%20skin%20with%20visible%20shine%20and%20enlarged%20pores%2C%20clinical%20dermatology%20image%2C%20medical%20skin%20condition%2C%20professional%20photography%2C%20clean%20white%20background%2C%20dermatological%20reference%20image&width=500&height=300&seq=skin5&orientation=landscape"
                                alt="Oily Skin" class="w-full h-full object-cover object-top">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-3 dark:text-white">Oily Skin</h3>
                            <p class="text-gray-600 mb-4 dark:text-blue-200">Balance oil production without stripping your skin with our
                                lightweight, non-comedogenic formulas.</p>
                            <a href="#" class="text-primary font-medium flex items-center">
                                Explore Solutions
                                <i class="ri-arrow-right-line ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Concern 6 -->
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                        <div class="h-48 overflow-hidden">
                            <img src="https://readdy.ai/api/search-image?query=Close-up%20of%20skin%20with%20hyperpigmentation%20and%20dark%20spots%2C%20clinical%20dermatology%20image%2C%20medical%20skin%20condition%2C%20professional%20photography%2C%20clean%20white%20background%2C%20dermatological%20reference%20image&width=500&height=300&seq=skin6&orientation=landscape"
                                alt="Hyperpigmentation" class="w-full h-full object-cover object-top">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-3 dark:text-white">Hyperpigmentation</h3>
                            <p class="text-gray-600 mb-4 dark:text-blue-200">Even out skin tone and reduce dark spots with our brightening and
                                protective formulations.</p>
                            <a href="#" class="text-primary font-medium flex items-center">
                                Explore Solutions
                                <i class="ri-arrow-right-line ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Appointment Scheduling -->
        <section id="appointment" data-section="appointment" class="py-16 bg-white dark:bg-indigo-900">
            <div class="container mx-auto px-4">
                <div class="flex flex-col lg:flex-row items-center gap-12">
                    <div class="lg:w-1/2">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4 dark:text-white">Book a Consultation with Our Experts</h2>
                        <p class="text-gray-600 mb-6 dark:text-blue-200">Schedule a personalized consultation with our skincare professionals.
                            Choose between in-store visits or convenient online sessions.</p>
                        <div class="space-y-4 mb-8">
                            <div class="flex items-start">
                                <div class="w-10 h-10 flex items-center justify-center bg-blue-100 rounded-full mr-4 dark:bg-blue-900">
                                    <i class="ri-calendar-check-line text-primary ri-lg"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800 dark:text-white">Flexible Scheduling</h3>
                                    <p class="text-gray-600 text-sm dark:text-blue-200">Choose a time that works best for your schedule</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-10 h-10 flex items-center justify-center bg-blue-100 rounded-full mr-4 dark:bg-blue-900">
                                    <i class="ri-store-line text-primary ri-lg"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800 dark:text-white">Multiple Locations</h3>
                                    <p class="text-gray-600 text-sm dark:text-blue-200">Visit us at any of our convenient store locations</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-10 h-10 flex items-center justify-center bg-blue-100 rounded-full mr-4 dark:bg-blue-900">
                                    <i class="ri-video-chat-line text-primary ri-lg"></i>
                                </div>
                                <div>
                                    <h3 class="font-medium text-gray-800 dark:text-white">Online Consultations</h3>
                                    <p class="text-gray-600 text-sm dark:text-blue-200">Connect with our experts from the comfort of your home
                                    </p>
                                </div>
                            </div>
                        </div>
                        <button
                            class="bg-primary text-white px-8 py-3 !rounded-button font-medium whitespace-nowrap">Schedule
                            Now</button>
                    </div>
                    @if (session('success'))
                        <div class="fixed top-4 right-4 z-[9999] bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-2xl max-w-md">
                            <div class="flex items-center gap-3">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <p class="text-green-700 font-medium">{{ strtoupper(session('success')) }}</p>
                            </div>
                        </div>
                        <script>
                            setTimeout(() => {
                                document.querySelector('.bg-green-50')?.remove();
                            }, 5000);
                        </script>
                    @endif

                    <div class="lg:w-1/2 bg-white rounded-xl shadow-lg p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                        <h3 class="text-xl font-semibold text-gray-800 mb-6 dark:text-white">Quick Appointment Request</h3>
                        @if (session('error'))
                            <div class="bg-red-100 text-red-800 p-4 rounded mb-4 dark:bg-red-900 dark:text-red-200">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="bg-red-100 text-red-800 p-4 rounded mb-4 dark:bg-red-900 dark:text-red-200">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="appointmentForm" method="POST" action="{{ route('appointments.store') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">Full
                                    Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="Enter your full name">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">Email
                                    Address</label>
                                <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="Enter your email address">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">Phone
                                    Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="Enter your phone number">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">Preferred
                                        Date</label>
                                    <input type="date" id="date" name="preferred_date" value="{{ old('preferred_date') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                                <div>
                                    <label for="time" class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">Preferred
                                        Time</label>
                                    <input type="time" id="time" name="preferred_time" value="{{ old('preferred_time') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">Consultation Type</label>
                                <div class="flex space-x-4">
                                    <label class="flex items-center">
                                        <input type="radio" name="consultation_type" value="in-store"
                                            class="custom-radio" @checked(old('consultation_type', 'in-store') === 'in-store') required onchange="toggleLocation()">
                                        <span class="ml-2 text-gray-700 dark:text-blue-200">In-Store</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="consultation_type" value="online"
                                            class="custom-radio" @checked(old('consultation_type') === 'online') onchange="toggleLocation()">
                                        <span class="ml-2 text-gray-700 dark:text-blue-200">Online</span>
                                    </label>
                                </div>
                            </div>
                            <div id="locationField" style="display: {{ old('consultation_type', 'in-store') === 'in-store' ? 'block' : 'none' }}">
                                <label class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">Store Location</label>
                                <select name="location" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                                    <option value="">-- Select Location --</option>
                                    <option value="SM Manila" @selected(old('location') === 'SM Manila')>SM Manila</option>
                                    <option value="SM Megamall" @selected(old('location') === 'SM Megamall')>SM Megamall</option>
                                    <option value="SM North EDSA" @selected(old('location') === 'SM North EDSA')>SM North EDSA</option>
                                    <option value="SM Makati" @selected(old('location') === 'SM Makati')>SM Makati</option>
                                    <option value="SM Aura" @selected(old('location') === 'SM Aura')>SM Aura</option>
                                    <option value="Ayala Malls Manila Bay" @selected(old('location') === 'Ayala Malls Manila Bay')>Ayala Malls Manila Bay</option>
                                </select>
                            </div>
                            <div>
                                <label for="concerns" class="block text-sm font-medium text-gray-700 mb-1 dark:text-blue-200">Skin
                                    Concerns</label>
                                <textarea id="concerns" name="concerns" data-section="concerns" rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                                    placeholder="Please describe your skin concerns">{{ old('concerns') }}</textarea>
                            </div>
                            <button type="submit"
                                class="w-full bg-primary text-white px-6 py-3 !rounded-button font-medium whitespace-nowrap">Request
                                Appointment</button>
                        </form>
                        <script>
                            function toggleLocation() {
                                const consultationType = document.querySelector('input[name="consultation_type"]:checked').value;
                                const locationField = document.getElementById('locationField');
                                if (consultationType === 'in-store') {
                                    locationField.style.display = 'block';
                                } else {
                                    locationField.style.display = 'none';
                                }
                            }
                        </script>
                    </div>
                </div>
            </div>
        </section>
        <!-- Testimonials -->
        <section class="py-16 bg-gray-50 dark:bg-indigo-900">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4 dark:text-white">What Our Customers Say</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto dark:text-blue-200">Hear from real people who have experienced the difference
                        our products make.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Testimonial 1 -->
                    <div class="bg-white rounded-lg shadow-md p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                        <div class="flex mb-4">
                            <i class="ri-star-fill text-yellow-400"></i>
                            <i class="ri-star-fill text-yellow-400"></i>
                            <i class="ri-star-fill text-yellow-400"></i>
                            <i class="ri-star-fill text-yellow-400"></i>
                            <i class="ri-star-fill text-yellow-400"></i>
                        </div>
                        <p class="text-gray-600 mb-6 dark:text-blue-200">"I've struggled with dry, sensitive skin for years. After consulting
                            with Dr. C and following the recommended routine, my skin feels completely transformed. The
                            Moisturizing Cream has become my holy grail product!"</p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                <span class="text-primary font-semibold">SA</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800 dark:text-white">Sarah Anderson</h4>
                                <p class="text-gray-500 text-sm dark:text-blue-300">Kuala Lumpur</p>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial 2 -->
                    <div class="bg-white rounded-lg shadow-md p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                        <div class="flex mb-4">
                            <i class="ri-star-fill text-yellow-400"></i>
                            <i class="ri-star-fill text-yellow-400"></i>
                            <i class="ri-star-fill text-yellow-400"></i>
                            <i class="ri-star-fill text-yellow-400"></i>
                            <i class="ri-star-fill text-yellow-400"></i>
                        </div>
                        <p class="text-gray-600 mb-6 dark:text-blue-200">"The in-store consultation was incredibly helpful. The consultant
                            took time to understand my acne concerns and recommended products that actually worked. Three
                            months later, my skin is clearer than it's been in years!"</p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                <span class="text-primary font-semibold">JT</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800 dark:text-white">Jason Tan</h4>
                                <p class="text-gray-500 text-sm dark:text-blue-300">Penang</p>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial 3 -->
                    <div class="bg-white rounded-lg shadow-md p-6 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                        <div class="flex mb-4">
                            <i class="ri-star-fill text-yellow-400"></i>
                            <i class="ri-star-fill text-yellow-400"></i>
                            <i class="ri-star-fill text-yellow-400"></i>
                            <i class="ri-star-fill text-yellow-400"></i>
                            <i class="ri-star-half-fill text-yellow-400"></i>
                        </div>
                        <p class="text-gray-600 mb-6 dark:text-blue-200">"I was skeptical about the AI consultation, but Dr. C gave me
                            personalized advice that really worked for my combination skin. The Hydrating Cleanser and AM
                            Facial Moisturizer have become staples in my routine."</p>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                <span class="text-primary font-semibold">RL</span>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-800 dark:text-white">Rachel Lim</h4>
                                <p class="text-gray-500 text-sm dark:text-blue-300">Johor Bahru</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Educational Content -->
        <section id="skincare" data-section="skincare" class="py-16 bg-white dark:bg-indigo-900">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4 dark:text-white">Skincare Education</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto dark:text-blue-200">Learn about skincare fundamentals and advanced topics from
                        our dermatologists.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Article 1 -->
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                        <div class="h-48 overflow-hidden">
                            <img src="https://readdy.ai/api/search-image?query=Close-up%20of%20skincare%20routine%20with%20blue%20bottles%20and%20jars%2C%20hands%20applying%20product%2C%20clean%20white%20background%2C%20professional%20skincare%20photography%2C%20educational%20skincare%20content%2C%20dermatologist%20approved%2C%20clinical%20appearance&width=500&height=300&seq=edu1&orientation=landscape"
                                alt="Skincare Basics" class="w-full h-full object-cover object-top">
                        </div>
                        <div class="p-6">
                            <span class="text-xs text-gray-500 dark:text-blue-300">June 20, 2025</span>
                            <h3 class="text-xl font-semibold text-gray-800 my-2 dark:text-white">The Fundamentals of a Good Skincare
                                Routine</h3>
                            <p class="text-gray-600 mb-4 dark:text-blue-200">Learn the essential steps every skincare routine should include,
                                regardless of your skin type.</p>
                            <a href="#" class="text-primary font-medium flex items-center">
                                Read More
                                <i class="ri-arrow-right-line ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Article 2 -->
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                        <div class="h-48 overflow-hidden">
                            <img src="https://readdy.ai/api/search-image?query=Close-up%20of%20skincare%20ingredients%20with%20scientific%20laboratory%20equipment%2C%20clean%20white%20background%2C%20professional%20skincare%20photography%2C%20educational%20skincare%20content%2C%20dermatologist%20approved%2C%20clinical%20appearance&width=500&height=300&seq=edu2&orientation=landscape"
                                alt="Skincare Ingredients" class="w-full h-full object-cover object-top">
                        </div>
                        <div class="p-6">
                            <span class="text-xs text-gray-500 dark:text-blue-300">June 18, 2025</span>
                            <h3 class="text-xl font-semibold text-gray-800 my-2 dark:text-white">Understanding Skincare Ingredients</h3>
                            <p class="text-gray-600 mb-4 dark:text-blue-200">A comprehensive guide to common skincare ingredients and how they
                                benefit your skin.</p>
                            <a href="#" class="text-primary font-medium flex items-center">
                                Read More
                                <i class="ri-arrow-right-line ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Article 3 -->
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden transition-transform hover:shadow-lg hover:-translate-y-1 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                        <div class="h-48 overflow-hidden">
                            <img src="https://readdy.ai/api/search-image?query=Close-up%20of%20sun%20protection%20products%20with%20sunscreen%20and%20hat%2C%20clean%20white%20background%2C%20professional%20skincare%20photography%2C%20educational%20skincare%20content%2C%20dermatologist%20approved%2C%20clinical%20appearance&width=500&height=300&seq=edu3&orientation=landscape"
                                alt="Sun Protection" class="w-full h-full object-cover object-top">
                        </div>
                        <div class="p-6">
                            <span class="text-xs text-gray-500 dark:text-blue-300">June 15, 2025</span>
                            <h3 class="text-xl font-semibold text-gray-800 my-2 dark:text-white">The Importance of Sun Protection</h3>
                            <p class="text-gray-600 mb-4 dark:text-blue-200">Why sunscreen is the most important anti-aging product and how to
                                choose the right one.</p>
                            <a href="#" class="text-primary font-medium flex items-center">
                                Read More
                                <i class="ri-arrow-right-line ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-10">
                    <button
                        class="bg-white border-2 border-primary text-primary px-8 py-3 !rounded-button font-medium whitespace-nowrap dark:bg-transparent dark:border-blue-400 dark:text-blue-200">View
                        All Articles</button>
                </div>
            </div>
        </section>
        <!-- Store Locator -->
        <section id="locate" data-section="locate" class="py-16 bg-gray-50 dark:bg-indigo-900">
            <div class="container mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800 mb-4 dark:text-white">Find a CeraVe Store Near You</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto dark:text-blue-200">Visit one of our stores for personalized consultations and
                        product recommendations.</p>
                </div>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                    <div class="h-96 relative"
                        style="background-image: url('https://public.readdy.ai/gen_page/map_placeholder_1280x720.png'); background-position: center; background-size: cover;">
                    </div>
                    <div class="p-6">
                        <div class="mb-6">
                            <div class="relative">
                                <input type="text" placeholder="Enter your location"
                                    class="w-full px-4 py-3 pr-10 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-white dark:text-gray-800 dark:border-gray-300">
                                <div
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 w-6 h-6 flex items-center justify-center">
                                    <i class="ri-search-line text-gray-500 dark:text-blue-300"></i>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Store 1 -->
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition-colors dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-slate-800">
                                <h3 class="font-semibold text-gray-800 mb-2 dark:text-white">CeraVe Pavilion KL</h3>
                                <p class="text-gray-600 text-sm mb-3 dark:text-blue-200">168, Jalan Bukit Bintang, Kuala Lumpur, 55100</p>
                                <div class="flex items-center text-gray-600 text-sm mb-2 dark:text-blue-200">
                                    <i class="ri-time-line mr-2"></i>
                                    <span>9:00 AM - 10:00 PM</span>
                                </div>
                                <div class="flex items-center text-gray-600 text-sm mb-3 dark:text-blue-200">
                                    <i class="ri-phone-line mr-2"></i>
                                    <span>+60 3-2118 8833</span>
                                </div>
                                <div class="flex space-x-2">
                                    <button
                                        class="bg-primary text-white px-3 py-2 !rounded-button text-sm whitespace-nowrap">Get
                                        Directions</button>
                                    <button
                                        class="bg-white border border-primary text-primary px-3 py-2 !rounded-button text-sm whitespace-nowrap dark:bg-transparent dark:border-blue-400 dark:text-blue-200">Book
                                        Appointment</button>
                                </div>
                            </div>
                            <!-- Store 2 -->
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition-colors dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-slate-800">
                                <h3 class="font-semibold text-gray-800 mb-2 dark:text-white">CeraVe Mid Valley</h3>
                                <p class="text-gray-600 text-sm mb-3 dark:text-blue-200">Mid Valley Megamall, Lingkaran Syed Putra, Kuala
                                    Lumpur, 59200</p>
                                <div class="flex items-center text-gray-600 text-sm mb-2 dark:text-blue-200">
                                    <i class="ri-time-line mr-2"></i>
                                    <span>10:00 AM - 10:00 PM</span>
                                </div>
                                <div class="flex items-center text-gray-600 text-sm mb-3 dark:text-blue-200">
                                    <i class="ri-phone-line mr-2"></i>
                                    <span>+60 3-2282 1111</span>
                                </div>
                                <div class="flex space-x-2">
                                    <button
                                        class="bg-primary text-white px-3 py-2 !rounded-button text-sm whitespace-nowrap">Get
                                        Directions</button>
                                    <button
                                        class="bg-white border border-primary text-primary px-3 py-2 !rounded-button text-sm whitespace-nowrap dark:bg-transparent dark:border-blue-400 dark:text-blue-200">Book
                                        Appointment</button>
                                </div>
                            </div>
                            <!-- Store 3 -->
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-primary transition-colors dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border-slate-800">
                                <h3 class="font-semibold text-gray-800 mb-2 dark:text-white">CeraVe Sunway Pyramid</h3>
                                <p class="text-gray-600 text-sm mb-3 dark:text-blue-200">3, Jalan PJS 11/15, Bandar Sunway, Petaling Jaya,
                                    47500</p>
                                <div class="flex items-center text-gray-600 text-sm mb-2 dark:text-blue-200">
                                    <i class="ri-time-line mr-2"></i>
                                    <span>10:00 AM - 10:00 PM</span>
                                </div>
                                <div class="flex items-center text-gray-600 text-sm mb-3 dark:text-blue-200">
                                    <i class="ri-phone-line mr-2"></i>
                                    <span>+60 3-5635 6333</span>
                                </div>
                                <div class="flex space-x-2">
                                    <button
                                        class="bg-primary text-white px-3 py-2 !rounded-button text-sm whitespace-nowrap">Get
                                        Directions</button>
                                    <button
                                        class="bg-white border border-primary text-primary px-3 py-2 !rounded-button text-sm whitespace-nowrap dark:bg-transparent dark:border-blue-400 dark:text-blue-200">Book
                                        Appointment</button>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-6">
                            <button
                                class="bg-white border-2 border-primary text-primary px-6 py-2 !rounded-button font-medium whitespace-nowrap dark:bg-transparent dark:border-blue-400 dark:text-blue-200">View
                                All Locations</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Newsletter -->
        <section class="py-16 bg-white dark:bg-indigo-900">
            <div class="container mx-auto px-4">
                <div id="newsletterSection" class="bg-blue-50 rounded-2xl p-8 md:p-12 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
                    <div class="max-w-3xl mx-auto text-center">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4 dark:text-white">Join Our Skincare Community</h2>
                        <p class="text-gray-600 mb-8 dark:text-blue-200">Subscribe to receive skincare tips, exclusive offers, and early
                            access to new products.</p>
                        <div class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
                            <input type="email" placeholder="Enter your email address"
                                class="flex-1 px-4 py-3 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-white dark:text-gray-800 dark:border-gray-300">
                            <button
                                class="bg-primary text-white px-6 py-3 !rounded-button font-medium whitespace-nowrap">Subscribe</button>
                        </div>
                        <p class="text-gray-500 text-sm mt-4 dark:text-blue-300">By subscribing, you agree to our Privacy Policy and consent
                            to receive updates from CeraVe.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Footer -->
        <footer class="bg-gray-900 text-white pt-16 pb-8">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                    <div>
                        <a href="#" class="text-3xl font-['Pacifico'] text-white mb-6 block">CeraVe</a>
                        <p class="text-gray-400 mb-6">Developed with dermatologists, our skincare products help restore and
                            maintain your skin's natural protective barrier.</p>
                        <div class="flex space-x-4">
                            <a href="#"
                                class="w-10 h-10 flex items-center justify-center bg-gray-800 rounded-full hover:bg-primary transition-colors">
                                <i class="ri-facebook-fill"></i>
                            </a>
                            <a href="#"
                                class="w-10 h-10 flex items-center justify-center bg-gray-800 rounded-full hover:bg-primary transition-colors">
                                <i class="ri-instagram-line"></i>
                            </a>
                            <a href="#"
                                class="w-10 h-10 flex items-center justify-center bg-gray-800 rounded-full hover:bg-primary transition-colors">
                                <i class="ri-twitter-x-line"></i>
                            </a>
                            <a href="#"
                                class="w-10 h-10 flex items-center justify-center bg-gray-800 rounded-full hover:bg-primary transition-colors">
                                <i class="ri-youtube-line"></i>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-6">Products</h3>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Cleansers</a>
                            </li>
                            <li><a href="#"
                                    class="text-gray-400 hover:text-white transition-colors">Moisturizers</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Serums</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Sun
                                    Protection</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Body Care</a>
                            </li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Baby Care</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-6">Resources</h3>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Skin
                                    Concerns</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Skincare
                                    Education</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Ingredient
                                    Glossary</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Skincare
                                    Quiz</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">FAQs</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-6">Contact</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <i class="ri-map-pin-line mr-3 mt-1"></i>
                                <span class="text-gray-400">Level 13, Menara Lien Hoe, Petaling Jaya, 47301 Malaysia</span>
                            </li>
                            <li class="flex items-center">
                                <i class="ri-phone-line mr-3"></i>
                                <span class="text-gray-400">+60 3-7491 0000</span>
                            </li>
                            <li class="flex items-center">
                                <i class="ri-mail-line mr-3"></i>
                                <span class="text-gray-400">contact@ceravemy.com</span>
                            </li>
                        </ul>
                        <div class="mt-6">
                            <h4 class="font-medium mb-3">Payment Methods</h4>
                            <div class="flex space-x-3">
                                <i class="ri-visa-fill text-2xl text-gray-400"></i>
                                <i class="ri-mastercard-fill text-2xl text-gray-400"></i>
                                <i class="ri-paypal-fill text-2xl text-gray-400"></i>
                                <i class="ri-alipay-fill text-2xl text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-800 pt-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <p class="text-gray-400 text-sm mb-4 md:mb-0">© 2025 CeraVe Malaysia. All rights reserved.</p>
                        <div class="flex space-x-6">
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Privacy
                                Policy</a>
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Terms of
                                Service</a>
                            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Cookie
                                Policy</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <script id="productInteractions">
            document.addEventListener('DOMContentLoaded', function() {
                const addToCartButtons = document.querySelectorAll('.ri-shopping-cart-line');
                addToCartButtons.forEach(button => {
                    button.parentElement.addEventListener('click', function() {
                        const productName = this.closest('.p-6').querySelector('h3').textContent;
                        alert(`${productName} has been added to your cart!`);
                    });
                });
            });
        </script>
        <!-- Removed custom intercept script: allow native form POST to Laravel route -->
        <script id="newsletterSubscription">
            document.addEventListener('DOMContentLoaded', function() {
                const subscribeButton = document.querySelector('#newsletterSection button');
                const emailInput = document.querySelector('#newsletterSection input[type="email"]');
                if (subscribeButton && emailInput) {
                    subscribeButton.addEventListener('click', function() {
                        const email = emailInput.value;
                        if (!email || !email.includes('@')) {
                            alert('Please enter a valid email address.');
                            return;
                        }
                        alert('Thank you for subscribing to our newsletter!');
                        emailInput.value = '';
                    });
                }
            });
        </script>
@endsection
