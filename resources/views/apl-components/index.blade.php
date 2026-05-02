@extends('layouts.authenticated')

@section('main')
<div class="space-y-4">
    <div class="flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-800">APL Components</h1>
        @if($permissions['canAccessAplComponents'] ?? false)
        <a href="{{ route('apl-components.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus mr-1"></i> New
        </a>
        @endif
    </div>

    <div class="space-y-3">
        @forelse($components as $component)
        <a href="{{ route('apl-components.show', $component->id) }}" class="block bg-white rounded-2xl shadow-md p-4 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div class="flex items-center flex-1 min-w-0">
                    <div class="w-12 h-12 bg-secondary/20 rounded-xl flex items-center justify-center mr-3 flex-shrink-0">
                        <i class="fas fa-folder text-secondary text-lg"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="font-semibold text-gray-800 truncate">{{ $component->name }}</h3>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $component->items_count ?? 0 }} items</p>
                    </div>
                </div>
                <i class="fas fa-chevron-right text-gray-400 flex-shrink-0 ml-2"></i>
            </div>
        </a>
        @empty
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-folder-open text-gray-400 text-2xl"></i>
            </div>
            <p class="text-gray-500">Belum ada komponen APL</p>
            @if($permissions['canAccessAplComponents'] ?? false)
            <a href="{{ route('apl-components.create') }}" class="btn btn-primary btn-sm mt-3">Buat Baru</a>
            @endif
        </div>
        @endforelse
    </div>
</div>
@endsection
