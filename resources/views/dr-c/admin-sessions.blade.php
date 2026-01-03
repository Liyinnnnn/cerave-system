@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Dr. C Session Management</h1>
            <p class="text-gray-600 mt-2">View and manage all user consultation sessions</p>
        </div>

        @if($sessions && count($sessions) > 0)
            <!-- Sessions Table -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b-2 border-gray-300">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Duration</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Messages</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Concerns</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($sessions as $session)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <!-- User -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $session->user->name ?? 'Unknown' }}</p>
                                            <p class="text-xs text-gray-500">{{ $session->user->email ?? '' }}</p>
                                        </div>
                                    </td>

                                    <!-- Date -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        {{ $session->created_at->format('M d, Y H:i') }}
                                    </td>

                                    <!-- Duration -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                        {{ $session->session_duration }}
                                    </td>

                                    <!-- Messages -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full font-semibold">
                                            {{ $session->message_count }}
                                        </span>
                                    </td>

                                    <!-- Concerns -->
                                    <td class="px-6 py-4 text-sm text-gray-800">
                                        @if($session->concerns)
                                            <div class="flex flex-wrap gap-1">
                                                @php
                                                    $concerns = is_string($session->concerns) ? explode(',', $session->concerns) : [];
                                                @endphp
                                                @foreach(array_slice($concerns, 0, 2) as $concern)
                                                    <span class="inline-block px-2 py-1 bg-amber-100 text-amber-800 rounded text-xs">
                                                        {{ trim($concern) }}
                                                    </span>
                                                @endforeach
                                                @if(count($concerns) > 2)
                                                    <span class="inline-block px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">
                                                        +{{ count($concerns) - 2 }}
                                                    </span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $session->status === 'completed' ? 'bg-green-100 text-green-800' : ($session->status === 'active' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($session->status) }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                        <a href="/dr-c/sessions/{{ $session->id }}" class="text-indigo-600 hover:text-indigo-900 transition duration-200">
                                            View Report
                                        </a>
                                        <span class="mx-2 text-gray-300">|</span>
                                        <form method="POST" action="/dr-c/sessions/{{ $session->id }}" style="display: inline;" onsubmit="return confirm('Delete this session permanently?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 transition duration-200">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($sessions->hasPages())
                    <div class="bg-gray-50 border-t px-6 py-4">
                        {{ $sessions->links() }}
                    </div>
                @endif
            </div>

            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-600 text-sm font-semibold">Total Sessions</p>
                    <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $sessions->total() }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-600 text-sm font-semibold">Active Sessions</p>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $sessions->where('status', 'active')->count() }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-600 text-sm font-semibold">Completed Sessions</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $sessions->where('status', 'completed')->count() }}</p>
                </div>
                <div class="bg-white rounded-lg shadow p-6">
                    <p class="text-gray-600 text-sm font-semibold">Total Messages</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">{{ $sessions->sum('message_count') }}</p>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                <svg class="w-24 h-24 text-gray-300 mx-auto mb-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"></path>
                </svg>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">No Sessions Yet</h3>
                <p class="text-gray-600">Users will appear here once they start consulting with Dr. C.</p>
            </div>
        @endif
    </div>
</div>
@endsection
