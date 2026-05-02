@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-base-200">
    {{-- Hero Section --}}
    <div class="hero min-h-screen bg-base-100">
        <div class="hero-content text-center">
            <div class="max-w-lg">
                <h1 class="text-5xl font-bold text-primary">KISS</h1>
                <p class="py-6 text-lg text-base-content/70">Knowledge & Information Support System</p>
                
                <div class="mt-8 flex flex-col gap-4 sm:flex-row justify-center">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-home mr-2"></i> Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt mr-2"></i> Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-outline btn-primary">
                                    <i class="fas fa-user-plus mr-2"></i> Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                {{-- Features --}}
                <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="card bg-base-100 shadow-lg">
                        <div class="card-body items-center text-center">
                            <div class="text-4xl text-primary mb-4">
                                <i class="fas fa-history"></i>
                            </div>
                            <h3 class="card-title">History Replacement</h3>
                            <p>Lihat history pergantian komponen dari semua mekanik</p>
                        </div>
                    </div>
                    <div class="card bg-base-100 shadow-lg">
                        <div class="card-body items-center text-center">
                            <div class="text-4xl text-secondary mb-4">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <h3 class="card-title">Input Activity</h3>
                            <p>Input aktivitas pergantian komponen dengan mudah</p>
                        </div>
                    </div>
                    <div class="card bg-base-100 shadow-lg">
                        <div class="card-body items-center text-center">
                            <div class="text-4xl text-accent mb-4">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h3 class="card-title">APL Components</h3>
                            <p>Kelola file komponen ML dengan terstruktur</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
