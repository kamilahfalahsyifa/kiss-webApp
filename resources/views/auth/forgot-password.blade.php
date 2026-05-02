@extends('layouts.guest')

@section('slot')
<div class="card bg-base-100 shadow-xl">
    <div class="card-body">
        <h2 class="card-title text-2xl font-bold justify-center mb-6">Forgot Password</h2>
        
        <div class="mb-4 text-sm text-base-content/70">
            Enter your email and we'll send you a password reset link.
        </div>

        @if (session('status'))
            <div class="alert alert-success mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-control mb-6">
                <label class="label">
                    <span class="label-text">Email</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="input input-bordered @error('email') input-error @enderror" />
                @error('email')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary">
                    Email Password Reset Link
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
