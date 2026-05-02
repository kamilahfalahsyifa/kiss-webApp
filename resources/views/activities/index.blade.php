@extends('layouts.dashboard')

@section('page_title', 'Input Activity')
@section('page_subtitle', 'Manage replacement activities')

@section('content')
@if(session('success'))
<div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 flex items-center gap-3 shadow-sm">
    <i class="fas fa-check-circle text-green-600"></i>
    <span class="text-sm font-medium">{{ session('success') }}</span>
</div>
@endif

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Activity Records</h2>
        <p class="text-gray-500 text-sm mt-1">Manage your replacement activity data</p>
    </div>
    <a href="{{ route('mekanik.activities.create') }}"
       class="btn bg-maroon text-white hover:bg-maroon-dark px-5 py-2.5 rounded-xl flex items-center gap-2 text-sm font-medium shadow-sm transition-all">
        <i class="fas fa-plus"></i>
        Input Data
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-5 border-b border-gray-200 bg-gray-50/50">
        <form method="GET" action="{{ route('mekanik.activities.index') }}" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by Code Number, Activity, or Component..."
                           class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-gray-300 bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition-all shadow-sm">
                </div>
            </div>
            <div class="w-full md:w-52">
                <select name="category" class="w-full px-4 py-2.5 text-sm rounded-xl border border-gray-300 bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition-all shadow-sm">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn bg-maroon text-white hover:bg-maroon-dark px-5 py-2.5 rounded-xl text-sm font-medium shadow-sm transition-all">
                    Filter
                </button>
                <a href="{{ route('mekanik.activities.index') }}" class="btn bg-white border border-gray-300 text-gray-600 hover:bg-gray-50 hover:text-gray-800 px-4 py-2.5 rounded-xl transition-all shadow-sm flex items-center justify-center">
                    <i class="fas fa-sync-alt"></i>
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto p-5">
        <table class="table w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Code Number</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">HM Unit</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Date</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Activity</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Category</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Component</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">PIC</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Status</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Image</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $item)
                <tr class="border-b border-gray-100 hover:bg-pink-bg/50 transition">
                    <td class="px-4 py-4 font-medium text-gray-800">{{ $item->code_number ?: '-' }}</td>
                    <td class="px-4 py-4 text-gray-600">{{ $item->hm_km }}</td>
                    <td class="px-4 py-4 text-gray-600">{{ $item->replacement_date->format('d M Y') }}</td>
                    <td class="px-4 py-4 text-gray-600 text-sm max-w-xs truncate">{{ $item->notes ? Str::limit($item->notes, 30) : '-' }}</td>
                    <td class="px-4 py-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                            {{ $item->category ?: '-' }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-gray-600 text-sm">{{ $item->component_name ?: '-' }}</td>
                    <td class="px-4 py-4 text-gray-600 text-sm">{{ $item->pic ?: '-' }}</td>
                    <td class="px-4 py-4">
                        @if($item->status === 'pending')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Pending</span>
                        @elseif($item->status === 'approved')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Approved</span>
                        @elseif($item->status === 'rejected')
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">Rejected</span>
                        @else
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">{{ $item->status ?: 'Pending' }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-4">
                        @if($item->image)
                        <button type="button" onclick="showImage('{{ asset('storage/' . $item->image) }}')"
                                class="text-maroon hover:underline text-sm flex items-center gap-1">
                            <img src="{{ asset('storage/' . $item->image) }}"
                                 alt="Image" class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                        </button>
                        @else
                        <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center justify-center gap-2">
                            @if(Auth::user()->role === 'gl' && $item->status === 'pending')
                                <form action="{{ route('management.activities.approve', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm bg-green-100 text-green-700 hover:bg-green-200 border-none px-3 py-1.5 rounded-lg tooltip" title="Approve">
                                        <i class="fas fa-check text-xs"></i>
                                    </button>
                                </form>
                                <form action="{{ route('management.activities.reject', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm bg-red-100 text-red-700 hover:bg-red-200 border-none px-3 py-1.5 rounded-lg tooltip" title="Reject">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('mekanik.activities.edit', $item->id) }}"
                               class="btn btn-sm bg-yellow-100 text-yellow-700 hover:bg-yellow-200 border-none px-3 py-1.5 rounded-lg tooltip" title="Edit">
                                <i class="fas fa-edit text-xs"></i>
                            </a>
                            <button type="button"
                                    onclick="confirmDelete({{ $item->id }}, '{{ $item->code_number ?: 'Activity' }}')"
                                    class="btn btn-sm bg-red-100 text-red-700 hover:bg-red-200 border-none px-3 py-1.5 rounded-lg tooltip" title="Delete">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-4 py-12 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                        <p class="text-lg font-medium">No records found</p>
                        <p class="text-sm">Start by adding a new activity</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($activities->hasPages())
    <div class="p-5 border-t border-gray-200 bg-white">
        {{ $activities->withQueryString()->links() }}
    </div>
    @endif
</div>

<div id="imageModal" class="hidden fixed inset-0 bg-gray-900/90 z-50 flex items-center justify-center p-4 backdrop-blur-sm transition-opacity">
    <button onclick="closeImage()" class="absolute top-5 right-5 text-gray-300 hover:text-white text-3xl transition-colors">
        <i class="fas fa-times"></i>
    </button>
    <img id="modalImage" src="" alt="Full Image" class="max-w-full max-h-[85vh] rounded-xl shadow-2xl object-contain border border-gray-700">
</div>

<div id="deleteModal" class="hidden fixed inset-0 bg-gray-900/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 transform transition-all">
        <div class="text-center">
            <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-red-100">
                <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Delete Activity</h3>
            <p class="text-gray-500 text-sm mb-6 leading-relaxed">Are you sure you want to delete <span id="deleteItemName" class="font-bold text-gray-800"></span>? This action cannot be undone.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="btn btn-ghost flex-1 border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl py-2.5 text-sm font-medium transition-colors">Cancel</button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn bg-red-600 hover:bg-red-700 text-white w-full rounded-xl py-2.5 text-sm font-medium transition-colors shadow-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Image Modal
function showImage(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

function closeImage() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Delete Confirmation Modal
function confirmDelete(id, name) {
    document.getElementById('deleteItemName').textContent = name;
    document.getElementById('deleteForm').action = '/mekanik/activities/' + id;
    document.getElementById('deleteModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal on backdrop click
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImage();
    }
});

// Close modals on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        if (!document.getElementById('imageModal').classList.contains('hidden')) {
            closeImage();
        }
        if (!document.getElementById('deleteModal').classList.contains('hidden')) {
            closeDeleteModal();
        }
    }
});
</script>
@endsection