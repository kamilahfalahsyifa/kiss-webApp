@extends('layouts.authenticated')

@section('main')
<div class="space-y-4">
    <div class="card bg-base-100 shadow max-w-md mx-auto">
        <div class="card-body">
            <h2 class="card-title text-2xl font-bold justify-center mb-6">Verify Email</h2>
            
            <div class="alert alert-info mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>A verification email has been sent to your email address.</span>
            </div>

            @if (session('status'))
                <div class="alert alert-success mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <p class="text-sm text-base-content/70 mb-4">
                If you didn't receive the email, click below to request another.
            </p>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary">
                        Resend Verification Email
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
