@extends('layouts.dashboard')

@section('page_title', 'Create APL File')
@section('page_subtitle', 'Create new APL file')

@section('content')
<div class="bg-white rounded-2xl shadow-md p-4 sm:p-6 border border-gray-100">
    <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-4 sm:mb-6">Create New APL File</h3>

    @if($errors->any())
    <div class="mb-4 sm:mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('management.apl-files.store') }}">
        @csrf

        <div class="mb-4 sm:mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">File Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. APL Engine Components 2026"
                class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition">
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <button type="submit" class="btn bg-maroon text-white hover:bg-maroon-dark px-6 sm:px-8 w-full sm:w-auto">
                <i class="fas fa-save mr-2"></i> Save
            </button>
            <a href="{{ route('management.apl-files') }}" class="btn btn-ghost w-full sm:w-auto justify-center">Cancel</a>
        </div>
    </form>
</div>
@endsection
