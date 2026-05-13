@extends('layouts.dashboard')

@section('page_title', 'Profile')
@section('page_subtitle', 'Your account information')

@section('content')
<div class="max-w-full sm:max-w-2xl">
    <div class="bg-white rounded-2xl shadow-md p-4 sm:p-6 border border-gray-100">
        <div class="flex flex-col sm:flex-row items-center sm:items-center gap-4 sm:gap-6 mb-4 sm:mb-6 pb-4 sm:pb-6 border-b border-gray-100">
            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-maroon rounded-full flex items-center justify-center">
                <span class="text-white text-2xl sm:text-3xl font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
            </div>
            <div class="text-center sm:text-left">
                <h3 class="text-lg sm:text-xl font-bold text-gray-800">{{ Auth::user()->name }}</h3>
                <p class="text-gray-500 text-sm sm:text-base">{{ Auth::user()->email }}</p>
                <span class="badge bg-pink-bg text-maroon border-0 mt-2">{{ ucfirst(Auth::user()->role) }}</span>
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
                <span class="font-semibold text-gray-800">{{ ucfirst(Auth::user()->role) }}</span>
            </div>
            <div class="flex justify-between py-3">
                <span class="text-gray-500">Member Since</span>
                <span class="font-semibold text-gray-800">{{ Auth::user()->created_at->format('d M Y') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection