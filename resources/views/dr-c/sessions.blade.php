@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">My Dr. C Sessions</h1>
                    <p class="text-gray-600 mt-2">View and manage your consultation history</p>
                </div>
                <a href="/dr-c" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition duration-200">
                    New Chat
                </a>
            </div>
        </div>

        @if($sessions && count($sessions) > 0)
            <!-- Sessions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($sessions as $session)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-200 overflow-hidden">
                        <!-- Session Header -->
                        <div class="bg-gradient-to-r from-indigo-500 to-blue-500 p-4 text-white">
                            <h3 class="font-semibold text-lg truncate">Session {{ $session->id }}</h3>
                            <p class="text-sm text-indigo-100">{{ $session->created_at->format('M d, Y H:i') }}</p>
                        </div>

                        <!-- Session Body -->
                        <div class="p-4">
                            <!-- Duration -->
                            <div class="mb-3">
                                <p class="text-xs text-gray-600 font-semibold">DURATION</p>
                                <p class="text-lg font-bold text-gray-800">{{ $session->session_duration }}</p>
                            </div>

                            <!-- Message Count -->
                            <div class="mb-3">
                                <p class="text-xs text-gray-600 font-semibold">MESSAGES</p>
                                <p class="text-lg font-bold text-gray-800">{{ $session->message_count }} messages</p>
                            </div>

                            <!-- Concerns -->
                            @if($session->concerns)
                                <div class="mb-3">
                                    <p class="text-xs text-gray-600 font-semibold">CONCERNS</p>
                                    <div class="flex flex-wrap gap-1 mt-1">
                                        @php
                                            $concerns = is_string($session->concerns) ? explode(',', $session->concerns) : [];
                                        @endphp
                                        @foreach(array_slice($concerns, 0, 3) as $concern)
                                            <span class="inline-block px-2 py-1 bg-amber-100 text-amber-800 rounded text-xs">
                                                {{ trim($concern) }}
                                            </span>
                                        @endforeach
                                        @if(count($concerns) > 3)
                                            <span class="inline-block px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">
                                                +{{ count($concerns) - 3 }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- Status Badge -->
                            <div class="mb-4">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $session->status === 'completed' ? 'bg-green-100 text-green-800' : ($session->status === 'active' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($session->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="border-t bg-gray-50 p-4 flex gap-2">
                            <a href="/dr-c/sessions/{{ $session->id }}" class="flex-1 text-center px-4 py-2 bg-indigo-600 text-white rounded font-semibold hover:bg-indigo-700 transition duration-200 text-sm">
                                View Report
                            </a>
                            <form method="POST" action="/dr-c/sessions/{{ $session->id }}" style="flex: 1;" onsubmit="return confirm('Delete this session permanently?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded font-semibold hover:bg-red-700 transition duration-200 text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($sessions->hasPages())
                <div class="bg-white rounded-lg shadow p-6">
                    {{ $sessions->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"></path>
                </svg>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">No Sessions Yet</h3>
                <p class="text-gray-600 mb-6">Start your first consultation with Dr. C to see your sessions here.</p>
                <a href="/dr-c" class="inline-block px-8 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition duration-200">
                    Start New Session
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
