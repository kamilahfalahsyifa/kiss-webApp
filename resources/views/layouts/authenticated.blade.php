@extends('layouts.app')

@php
$roleLabels = [
    'mekanik' => 'Mekanik',
    'gl' => 'GL',
    'tere' => 'Tere',
    'planner' => 'Planner',
];
@endphp

@section('content')
<div class="min-h-screen bg-base-200">
    <nav class="navbar bg-white shadow-sm sticky top-0 z-50">
        <div class="flex-1">
            <a href="{{ route('dashboard') }}" class="btn btn-ghost text-lg font-bold text-primary">
                KISS
            </a>
        </div>
        <div class="flex-none">
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost btn-circle">
                    <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center">
                        <span class="text-white font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                </label>
                <ul tabindex="0" class="menu dropdown-content mt-3 z-[1] p-3 shadow-lg bg-base-100 text-base-content rounded-xl w-64">
                    <li class="mb-2">
                        <div class="flex flex-col">
                            <span class="font-semibold">{{ Auth::user()->name }}</span>
                            <span class="badge badge-primary badge-sm mt-1 w-fit">{{ $roleLabels[Auth::user()->role] ?? Auth::user()->role }}</span>
                        </div>
                    </li>
                    <li><a href="{{ route('profile.edit') }}" class="py-2"><i class="fas fa-user mr-2"></i> Profile</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="w-full text-left py-2 text-error"><i class="fas fa-sign-out-alt mr-2"></i> Log Out</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="px-4 py-6 pb-28 max-w-4xl mx-auto">
        @yield('main')
    </main>

    <div class="btm-nav-lg bg-white border-t border-gray-200 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] fixed bottom-0 left-0 right-0 z-50">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }} flex flex-col items-center justify-center py-2 {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-gray-500' }}">
            <i class="fas fa-home text-xl"></i>
            <span class="btm-nav-label text-xs mt-1">Home</span>
        </a>

        @if($permissions['canAccessHistory'] ?? true)
        <a href="{{ route('activity-replacements.index') }}" class="{{ request()->routeIs('activity-replacements.index') || request()->routeIs('activity-replacements.edit') ? 'active' : '' }} flex flex-col items-center justify-center py-2 {{ request()->routeIs('activity-replacements.index') || request()->routeIs('activity-replacements.edit') ? 'text-primary' : 'text-gray-500' }}">
            <i class="fas fa-list text-xl"></i>
            <span class="btm-nav-label text-xs mt-1">History</span>
        </a>
        @endif

        @if($permissions['canAccessInputActivity'] ?? false)
        <a href="{{ route('activity-replacements.create') }}" class="{{ request()->routeIs('activity-replacements.create') || request()->routeIs('activity-replacements.store') ? 'active' : '' }} flex flex-col items-center justify-center py-2 {{ request()->routeIs('activity-replacements.create') || request()->routeIs('activity-replacements.store') ? 'text-primary' : 'text-gray-500' }}">
            <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center -mt-6 shadow-lg">
                <i class="fas fa-plus text-white text-lg"></i>
            </div>
            <span class="btm-nav-label text-xs mt-1 text-primary font-medium">Input</span>
        </a>
        @endif

        @if($permissions['canAccessAplComponents'] ?? false)
        <a href="{{ route('apl-components.index') }}" class="{{ request()->routeIs('apl-components.index') || request()->routeIs('apl-components.create') || request()->routeIs('apl-components.show') || request()->routeIs('apl-components.edit') ? 'active' : '' }} flex flex-col items-center justify-center py-2 {{ request()->routeIs('apl-components.index') || request()->routeIs('apl-components.create') || request()->routeIs('apl-components.show') || request()->routeIs('apl-components.edit') ? 'text-primary' : 'text-gray-500' }}">
            <i class="fas fa-folder text-xl"></i>
            <span class="btm-nav-label text-xs mt-1">APL</span>
        </a>
        @endif
    </div>
</div>
@endsection
