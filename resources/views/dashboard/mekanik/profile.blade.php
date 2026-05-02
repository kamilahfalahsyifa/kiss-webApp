@extends('layouts.dashboard')

@section('page_title', 'Profile')
@section('page_subtitle', 'Your account information')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
        <div class="flex items-center gap-6 mb-6 pb-6 border-b border-gray-100">
            <div class="w-20 h-20 bg-maroon rounded-full flex items-center justify-center">
                <span class="text-white text-3xl font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-800">{{ Auth::user()->name }}</h3>
                <p class="text-gray-500">{{ Auth::user()->email }}</p>
                <span class="badge bg-pink-bg text-maroon border-0 mt-2">Mekanik</span>
            </div>
        </div>

        <div class="space-y-4">
            <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="text-gray-500">Full Name</span>
                <span class="font-semibold text-gray-800">{{ Auth::user()->name }}</span>
            </div>
            <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="text-gray-500">Email</span>
                <span class="font-semibold text-gray-800">{{ Auth::user()->email }}</span>
            </div>
            <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="text-gray-500">Role</span>
                <span class="font-semibold text-gray-800">Mekanik</span>
            </div>
            <div class="flex justify-between py-3">
                <span class="text-gray-500">Member Since</span>
                <span class="font-semibold text-gray-800">{{ Auth::user()->created_at->format('d M Y') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection