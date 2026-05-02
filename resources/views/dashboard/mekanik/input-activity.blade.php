@extends('layouts.dashboard')

@section('page_title', 'Input Activity')
@section('page_subtitle', 'Record new replacement activity')

@section('content')
<div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
    <h3 class="text-lg font-bold text-gray-800 mb-6">New Replacement Activity</h3>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('mekanik.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Code Number</label>
                <input type="text" name="code_number" required placeholder="e.g. PC-001"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">HM Unit</label>
                <input type="text" name="hm_km" required placeholder="e.g. 12500"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                <input type="date" name="replacement_date" value="{{ date('Y-m-d') }}" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <input type="text" name="category" required placeholder="e.g. Engine, Hydraulic, Brake"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Component</label>
                <input type="text" name="component_name" required placeholder="e.g. Hoist Cylinder, Engine Oil"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">PIC</label>
                <input type="text" name="pic" required placeholder="e.g. John, Jane, Bob (pisahkan dengan koma untuk multiple)"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Activity</label>
                <textarea name="notes" rows="3" placeholder="Describe the activity..."
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition"></textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Image</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition">
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <button type="submit" class="btn bg-maroon text-white hover:bg-maroon-dark px-8">
                <i class="fas fa-save mr-2"></i> Save Activity
            </button>
            <a href="{{ route('mekanik.dashboard') }}" class="btn btn-ghost">Cancel</a>
        </div>
    </form>
</div>
@endsection