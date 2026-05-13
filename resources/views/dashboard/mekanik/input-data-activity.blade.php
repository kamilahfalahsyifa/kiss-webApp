@extends('layouts.dashboard')

@section('page_title', 'Input Data Activity')
@section('page_subtitle', 'Additional data input form')

@section('content')
<div class="bg-white rounded-2xl shadow-md p-4 sm:p-6 border border-gray-100">
    <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-4 sm:mb-6">Input Data Activity</h3>

    @if(session('success'))
    <div class="mb-4 sm:mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm sm:text-base">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('mekanik.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Unit</label>
                <select name="unit_id" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition">
                    <option value="">Select Unit</option>
                    @foreach($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->unit_name }} - {{ $unit->qr_code }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Component</label>
                <select name="component_id" required class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition">
                    <option value="">Select Component</option>
                    @foreach($components as $component)
                    <option value="{{ $component->id }}">{{ $component->component_name }} - {{ $component->part_number }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Replacement Date</label>
                <input type="date" name="replacement_date" value="{{ date('Y-m-d') }}" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">HM/KM</label>
                <input type="text" name="hm_km" required placeholder="e.g. 12500"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Image</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                <textarea name="notes" rows="4" placeholder="Additional notes..."
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition"></textarea>
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <button type="submit" class="btn bg-maroon text-white hover:bg-maroon-dark px-8">
                <i class="fas fa-save mr-2"></i> Save Data
            </button>
            <a href="{{ route('mekanik.dashboard') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection