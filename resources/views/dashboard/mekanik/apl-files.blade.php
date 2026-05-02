@extends('layouts.dashboard')

@section('page_title', 'APL Komponen Midlife')
@section('page_subtitle', 'Master file list')

@section('content')
<div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-800">APL Files</h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($aplFiles as $file)
        <div class="bg-pink-bg rounded-xl p-6 border border-gray-200 hover:border-maroon transition group">
            <a href="{{ route('mekanik.apl-files.show', $file->id) }}" class="flex items-center gap-4">
                <div class="w-14 h-14 bg-maroon rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-excel text-white text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-gray-800 group-hover:text-maroon">{{ $file->name }}</h4>
                    <p class="text-sm text-gray-500">{{ $file->sheets->count() }} sheets</p>
                </div>
                <i class="fas fa-chevron-right text-gray-400"></i>
            </a>
        </div>
        @empty
        <div class="col-span-3 text-center py-12 text-gray-500">
            <i class="fas fa-folder-open text-4xl mb-4"></i>
            <p>No APL files found.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
