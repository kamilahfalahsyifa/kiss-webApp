@extends('layouts.app')

@section('content')
<div class="min-h-screen flex">
    <!-- LEFT SIDE - Pink Background with Logo -->
    <div class="hidden lg:flex lg:w-1/2 bg-pink-bg flex-col items-center justify-center p-12">
        <div class="text-center">
                <img src="{{ asset('images/logo-kiss-scan.png') }}" alt="Logo KISS" class="w-50 h-50 object-contain">
            <p class="text-3xl text-maroon/70">Keep It Simple System</p>
        </div>
    </div>

    <!-- RIGHT SIDE - White Background with Login Form -->
    <div class="w-full lg:w-1/2 bg-white flex items-center justify-center p-8">
        <div class="w-full max-w-md">
            <!-- Mobile Logo -->
            <div class="lg:hidden text-center mb-8">
                <div class="w-20 h-20 bg-maroon rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-qrcode text-white text-3xl"></i>
                </div>
                <h1 class="text-3xl font-extrabold text-maroon">KISS</h1>
            </div>

            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Login</h2>
                <p class="text-gray-500 mb-8">Enter your email and password to log in</p>

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                        <ul class="list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            placeholder="Enter your email"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" required autocomplete="current-password"
                            placeholder="Enter your password"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-maroon border-gray-300 rounded focus:ring-maroon">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-maroon hover:underline">Forgot Password?</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-maroon text-white py-3 rounded-xl font-semibold hover:bg-maroon-dark transition shadow-md">
                        Log In
                    </button>
                </form>

                <!-- Divider -->
                <div class="flex items-center my-8">
                    <div class="flex-1 border-t border-gray-200"></div>
                    <span class="px-4 text-sm text-gray-400">or</span>
                    <div class="flex-1 border-t border-gray-200"></div>
                </div>

                <!-- Social Login -->
                <div class="grid grid-cols-3 gap-3">
                    <button class="flex items-center justify-center py-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                        <i class="fab fa-google text-red-500 text-xl"></i>
                    </button>
                    <button class="flex items-center justify-center py-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                        <i class="fab fa-facebook text-blue-600 text-xl"></i>
                    </button>
                    <button class="flex items-center justify-center py-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                        <i class="fab fa-apple text-gray-800 text-xl"></i>
                    </button>
                </div>

                <!-- Mobile Access -->
                <div class="mt-6 text-center">
                    <button class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-maroon transition">
                        <i class="fas fa-mobile-alt"></i>
                        Access via Mobile
                    </button>
                </div>
            </div>

            <p class="text-center text-sm text-gray-500 mt-6">
                Don't have an account? <a href="{{ route('register') }}" class="text-maroon font-medium hover:underline">Register</a>
            </p>
        </div>
    </div>
</div>
@endsection