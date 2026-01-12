@extends('layouts.guest')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-100 via-blue-50 to-cyan-100 py-12 dark:from-indigo-950 dark:via-slate-900 dark:to-indigo-950">
    <div class="max-w-5xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2 dark:text-white">Settings</h1>
            <p class="text-gray-600 dark:text-blue-200">Manage site settings and footer content</p>
        </div>

        @if (session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg dark:bg-green-900 dark:bg-opacity-20 dark:border-green-400">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="text-green-700 font-medium dark:text-green-300">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Site Settings Tab -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 dark:text-white">Site Settings</h2>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">Front Page Title</label>
                    <input type="text" name="front_page_title" value="{{ old('front_page_title', $settings['front_page_title']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                    @error('front_page_title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">Front Page Description</label>
                    <textarea name="front_page_description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>{{ old('front_page_description', $settings['front_page_description']) }}</textarea>
                    @error('front_page_description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">Site Name</label>
                        <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                        @error('site_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 dark:text-blue-200">Tagline</label>
                        <input type="text" name="tagline" value="{{ old('tagline', $settings['tagline']) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white" required>
                        @error('tagline')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 font-semibold shadow-md hover:shadow-lg dark:bg-blue-700 dark:hover:bg-blue-800">Save Site Settings</button>
                </div>
            </form>
        </div>

        <!-- Footer Settings Tab -->
        <div class="bg-white rounded-xl shadow-lg p-8 dark:bg-gradient-to-br dark:from-slate-900 dark:to-indigo-950 dark:border dark:border-slate-800">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 dark:text-white">Footer Settings</h2>

            <form method="POST" action="{{ route('admin.footer.update') }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-blue-200">Footer Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">{{ old('description', $footer->description ?? '') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Social Media Links -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 dark:text-white">Social Media Links</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-blue-200">Facebook URL</label>
                            <input type="url" name="facebook_url" value="{{ old('facebook_url', $footer->facebook_url ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                            @error('facebook_url')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-blue-200">Instagram URL</label>
                            <input type="url" name="instagram_url" value="{{ old('instagram_url', $footer->instagram_url ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                            @error('instagram_url')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-blue-200">TikTok URL</label>
                            <input type="url" name="tiktok_url" value="{{ old('tiktok_url', $footer->tiktok_url ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                            @error('tiktok_url')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-blue-200">YouTube URL</label>
                            <input type="url" name="youtube_url" value="{{ old('youtube_url', $footer->youtube_url ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                            @error('youtube_url')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 dark:text-white">Contact Information</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-blue-200">Address</label>
                            <input type="text" name="address" value="{{ old('address', $footer->address ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-blue-200">Phone</label>
                                <input type="text" name="phone" value="{{ old('phone', $footer->phone ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-blue-200">Email</label>
                                <input type="email" name="email" value="{{ old('email', $footer->email ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Copyright Text -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-blue-200">Copyright Text</label>
                    <input type="text" name="copyright_text" value="{{ old('copyright_text', $footer->copyright_text ?? '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:outline-none dark:bg-slate-900 dark:border-slate-700 dark:text-white">
                    @error('copyright_text')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end gap-4">
                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition dark:bg-blue-700 dark:hover:bg-blue-800">
                        Save Footer Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
