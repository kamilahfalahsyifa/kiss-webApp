@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-primary/10 to-white flex flex-col items-center justify-center px-4">
    {{-- Logo/Brand --}}
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-primary">KISS</h1>
        <p class="text-sm text-gray-500 mt-1">Knowledge & Information Support System</p>
    </div>

    {{-- Auth Card --}}
    <div class="w-full max-w-sm">
        @yield('slot')
    </div>

    {{-- Footer --}}
    <div class="mt-8 text-center text-xs text-gray-400">
        &copy; {{ date('Y') }} KISS
    </div>
</div>
@endsection
