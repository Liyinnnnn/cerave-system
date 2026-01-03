@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex">
        <div class="w-1/2 bg-blue-900 text-white flex items-center justify-center p-16">
            <div class="space-y-4">
                <h1 class="text-3xl font-bold">Skincare Developed with Dermatologists</h1>
                <p class="text-lg">Experience the power of ceramides with dermatologist-developed formulations for healthy,
                    beautiful skin backed by science.</p>
                <div class="flex space-x-4">
                    <a href="/" class="bg-white text-blue-900 px-4 py-2 rounded-full font-semibold">Get Started</a>
                    <a href="{{ route('register') }}" class="border border-white px-4 py-2 rounded-full font-semibold">Create
                        Account</a>
                </div>
            </div>
        </div>