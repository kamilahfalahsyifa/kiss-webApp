@extends('layouts.dashboard')

@section('page_title', 'Input Activity')
@section('page_subtitle', 'Create new replacement activity')

@section('content')
<div class="bg-white rounded-2xl shadow-md p-4 sm:p-6 border border-gray-100">
    <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-4 sm:mb-6">New Replacement Activity</h3>

    @if($errors->any())
    <div class="mb-4 sm:mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
        <ul class="list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('mekanik.activities.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Code Number <span class="text-red-500">*</span></label>
                <input type="text" name="code_number" value="{{ old('code_number') }}" required placeholder="e.g. PC-001"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition @error('code_number') border-red-500 @enderror">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">HM Unit <span class="text-red-500">*</span></label>
                <input type="text" name="hm_km" value="{{ old('hm_km') }}" required placeholder="e.g. 12500"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition @error('hm_km') border-red-500 @enderror">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date <span class="text-red-500">*</span></label>
                <input type="date" name="replacement_date" value="{{ old('replacement_date', date('Y-m-d')) }}" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition @error('replacement_date') border-red-500 @enderror">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category <span class="text-red-500">*</span></label>
                <input type="text" name="category" value="{{ old('category') }}" required placeholder="e.g. Engine, Hydraulic, Brake"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition @error('category') border-red-500 @enderror">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Component <span class="text-red-500">*</span></label>
                <input type="text" name="component_name" value="{{ old('component_name') }}" required placeholder="e.g. Hoist Cylinder, Engine Oil"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition @error('component_name') border-red-500 @enderror">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">PIC <span class="text-red-500">*</span></label>
                <input type="text" name="pic" value="{{ old('pic') }}" required placeholder="e.g. John, Jane, Bob (pisahkan dengan koma untuk multiple)"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition @error('pic') border-red-500 @enderror">
            </div>

            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Activity / Notes</label>
                <textarea name="notes" rows="3" placeholder="Describe the activity..."
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Image</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition @error('image') border-red-500 @enderror text-sm">
                <p class="text-xs text-gray-500 mt-1">Max size: 2MB. Formats: JPG, PNG, GIF</p>
            </div>
        </div>

        <div class="mt-6 flex flex-col sm:flex-row gap-3">
            <button type="submit" class="btn bg-maroon text-white hover:bg-maroon-dark px-6 sm:px-8 w-full sm:w-auto">
                <i class="fas fa-save mr-2"></i> Save Activity
            </button>
            <a href="{{ route('mekanik.activities.index') }}" class="btn btn-ghost w-full sm:w-auto justify-center">Cancel</a>
        </div>
    </form>
</div>
@endsection
