@extends('layouts.guest')

@section('content')
    <div class="min-h-screen flex justify-center items-center bg-blue-50 py-12">
        <div class="bg-white shadow-lg rounded-lg p-8 text-center max-w-md w-full">
            <h2 class="text-xl font-bold text-blue-900">Hey, {{ $user->nickname }}!</h2><br>
            @php($avatar = $user->profile_image_url ?? null)
            <div class="flex justify-center">
                <img src="{{ $avatar ?: asset('images/default-avatar.png') }}"
                    alt="Profile Picture" class="w-24 h-24 rounded-full">
            </div><br>
            {{-- <p class="text-gray-600">{{ $user->name }}</p> --}}
            <p class="text-sm text-gray-500 mt-2">
                @if ($user->gender === 'Male' || $user->gender === 'male')
                    ♂️
                @else
                    ♀️
                @endif |
                {{ \Carbon\Carbon::parse($user->birthday)->toFormattedDateString() }}
            </p>
            <p class="text-gray-600">{{ $user->email }}</p>
            <a href="{{ route('profile.edit') }}"
                class="mt-6 inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Edit
                Profile</a>
        </div>
    </div>
@endsection
