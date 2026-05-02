@extends('layouts.guest')

@section('slot')
<div class="bg-white rounded-3xl shadow-xl p-8 w-full">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Create Account</h2>
    <p class="text-center text-gray-500 text-sm mb-6">Register to get started</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-control mb-4">
            <label class="label py-1"><span class="label-text text-sm font-medium">Name</span></label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Enter your name"
                class="input input-bordered bg-gray-50 @error('name') input-error @enderror" />
            @error('name')
                <label class="label py-1"><span class="label-text-alt text-error text-xs">{{ $message }}</span></label>
            @enderror
        </div>

        <div class="form-control mb-4">
            <label class="label py-1"><span class="label-text text-sm font-medium">Email</span></label>
            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Enter your email"
                class="input input-bordered bg-gray-50 @error('email') input-error @enderror" />
            @error('email')
                <label class="label py-1"><span class="label-text-alt text-error text-xs">{{ $message }}</span></label>
            @enderror
        </div>

        <div class="form-control mb-4">
            <label class="label py-1"><span class="label-text text-sm font-medium">Password</span></label>
            <input type="password" name="password" required autocomplete="new-password" placeholder="Create a password"
                class="input input-bordered bg-gray-50 @error('password') input-error @enderror" />
            @error('password')
                <label class="label py-1"><span class="label-text-alt text-error text-xs">{{ $message }}</span></label>
            @enderror
        </div>

        <div class="form-control mb-4">
            <label class="label py-1"><span class="label-text text-sm font-medium">Confirm Password</span></label>
            <input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm your password"
                class="input input-bordered bg-gray-50 @error('password_confirmation') input-error @enderror" />
            @error('password_confirmation')
                <label class="label py-1"><span class="label-text-alt text-error text-xs">{{ $message }}</span></label>
            @enderror
        </div>

        <div class="form-control mb-6">
            <label class="label py-1"><span class="label-text text-sm font-medium">Role</span></label>
            <select name="role" class="select select-bordered bg-gray-50 @error('role') select-error @enderror">
                <option value="">Pilih Role</option>
                <option value="mekanik" {{ old('role') == 'mekanik' ? 'selected' : '' }}>Mekanik</option>
                <option value="gl" {{ old('role') == 'gl' ? 'selected' : '' }}>GL</option>
                <option value="tere" {{ old('role') == 'tere' ? 'selected' : '' }}>Tere</option>
                <option value="planner" {{ old('role') == 'planner' ? 'selected' : '' }}>Planner</option>
            </select>
            @error('role')
                <label class="label py-1"><span class="label-text-alt text-error text-xs">{{ $message }}</span></label>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-full">Register</button>
    </form>

    <div class="mt-6 text-center text-sm text-gray-500">
        Already have an account? <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Login</a>
    </div>
</div>
@endsection
