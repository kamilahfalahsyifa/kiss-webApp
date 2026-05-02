@extends('layouts.authenticated')

@php
$roleLabels = [
    'mekanik' => 'Mekanik',
    'gl' => 'GL',
    'tere' => 'Tere',
    'planner' => 'Planner',
];
@endphp

@section('main')
<div class="space-y-5">
    {{-- Greeting Card --}}
    <div class="bg-gradient-to-r from-primary to-blue-600 rounded-2xl p-6 text-white shadow-lg">
        <p class="text-sm opacity-80">Selamat Datang,</p>
        <h1 class="text-2xl font-bold mt-1">{{ Auth::user()->name }}</h1>
        <p class="text-sm opacity-80 mt-1">{{ $roleLabels[Auth::user()->role] ?? Auth::user()->role }}</p>
    </div>

    {{-- Quick Actions --}}
    @if($permissions['canAccessInputActivity'] ?? false)
    <div class="card bg-white shadow-md rounded-2xl overflow-hidden">
        <div class="card-body p-5">
            <h3 class="font-semibold text-gray-700 mb-4">Menu Utama</h3>
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('activity-replacements.create') }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition">
                    <div class="w-14 h-14 bg-primary rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-plus text-white text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">Input Activity</span>
                </a>
                <a href="{{ route('activity-replacements.index') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-xl hover:bg-green-100 transition">
                    <div class="w-14 h-14 bg-success rounded-full flex items-center justify-center mb-2">
                        <i class="fas fa-history text-white text-xl"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">History</span>
                </a>
            </div>
        </div>
    </div>
    @endif

    @if($permissions['canAccessHistory'] ?? true)
    <div class="card bg-white shadow-md rounded-2xl overflow-hidden">
        <div class="card-body p-5">
            <h3 class="font-semibold text-gray-700 mb-4">History Replacement</h3>
            <a href="{{ route('activity-replacements.index') }}" class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-info/20 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-list text-info text-xl"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-700">Lihat Semua History</p>
                        <p class="text-xs text-gray-500">Riwayat pergantian komponen</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-gray-400"></i>
            </a>
        </div>
    </div>
    @endif

    @if($permissions['canAccessAplComponents'] ?? false)
    <div class="card bg-white shadow-md rounded-2xl overflow-hidden">
        <div class="card-body p-5">
            <h3 class="font-semibold text-gray-700 mb-4">APL Components</h3>
            <a href="{{ route('apl-components.index') }}" class="flex items-center justify-between p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-secondary/20 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-folder text-secondary text-xl"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-700">Kelola File APL</p>
                        <p class="text-xs text-gray-500">Komponen ML</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-gray-400"></i>
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
