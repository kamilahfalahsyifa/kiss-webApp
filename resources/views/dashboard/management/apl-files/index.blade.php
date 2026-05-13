@extends('layouts.dashboard')

@section('page_title', 'APL Komponen Midlife')
@section('page_subtitle', 'Master file list')

@section('content')
<div class="bg-white rounded-2xl shadow-md p-4 sm:p-6 border border-gray-100">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <h3 class="text-base sm:text-lg font-bold text-gray-800">APL Files</h3>
        @if(Auth::user()->role === 'planner')
        <a href="{{ route('management.apl-files.create') }}" class="btn bg-maroon text-white hover:bg-maroon-dark px-4 py-2 rounded-xl text-sm font-medium w-full sm:w-auto text-center">
            <i class="fas fa-plus mr-2"></i> Create New
        </a>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse($aplFiles as $file)
        <div class="bg-pink-bg rounded-xl p-6 border border-gray-200 hover:border-maroon transition group">
            <a href="{{ route('management.apl-files.show', $file->id) }}" class="flex items-center gap-4">
                <div class="w-14 h-14 bg-maroon rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-excel text-white text-2xl"></i>
                </div>
                <div class="flex-1">
                    <h4 class="font-bold text-gray-800 group-hover:text-maroon">{{ $file->name }}</h4>
                    <p class="text-sm text-gray-500">{{ $file->sheets->count() }} sheets</p>
                </div>
                <i class="fas fa-chevron-right text-gray-400"></i>
            </a>
            @if(Auth::user()->role === 'planner')
            <div class="flex gap-2 mt-4 pt-4 border-t border-gray-200"> 
                <a href="{{ route('management.apl-files.edit', $file->id) }}" class="btn btn-sm bg-yellow-100 text-yellow-700 hover:bg-yellow-200 border-none flex-1">
                    <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <form action="{{ route('management.apl-files.destroy', $file->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete this file?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm bg-red-100 text-red-700 hover:bg-red-200 border-none w-full">
                        <i class="fas fa-trash mr-1"></i> Delete
                    </button>
                </form>
            </div>
            @endif
        </div>
        @empty
        <div class="col-span-3 text-center py-12 text-gray-500">
            <i class="fas fa-folder-open text-4xl mb-4"></i>
            <p>No APL files found. @if(Auth::user()->role === 'planner') Create one to get started. @endif</p>
        </div>
        @endforelse
    </div>
</div>
@endsection