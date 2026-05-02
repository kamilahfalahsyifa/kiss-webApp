@extends('layouts.authenticated')

@section('main')
<div class="space-y-4">
    <div class="card bg-base-100 shadow max-w-md mx-auto">
        <div class="card-body">
            <h2 class="card-title text-2xl font-bold justify-center mb-6">Confirm Password</h2>
            
            <p class="text-sm text-base-content/70 mb-4">
                This is a secure area. Please confirm your password before continuing.
            </p>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <input type="password" name="password" required autocomplete="current-password"
                        class="input input-bordered @error('password') input-error @enderror" />
                    @error('password')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary">
                        Confirm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
