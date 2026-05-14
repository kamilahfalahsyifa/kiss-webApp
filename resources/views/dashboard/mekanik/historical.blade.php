@extends('layouts.dashboard')

@section('page_title', 'Historical Replacements')
@section('page_subtitle', 'Your replacement history records')

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-4 sm:p-5 border-b border-gray-200 bg-gray-50/50">
        <form method="GET" action="{{ route('mekanik.historical') }}" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-gray-400">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by Code Number, HM Unit, or Component..."
                           class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-gray-300 bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none transition-all shadow-sm">
                </div>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn bg-maroon text-white hover:bg-maroon-dark px-5 py-2.5 rounded-xl text-sm font-medium shadow-sm transition-all">
                    Filter
                </button>
                <a href="{{ route('mekanik.historical') }}" class="btn bg-white border border-gray-300 text-gray-600 hover:bg-gray-50 hover:text-gray-800 px-4 py-2.5 rounded-xl transition-all shadow-sm flex items-center justify-center">
                    <i class="fas fa-sync-alt"></i>
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto p-4 sm:p-5 -mx-4 sm:mx-0">
        <table class="table w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Code Number</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">HM Unit</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">WO</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Reservasi</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Date</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Activity</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Category</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Component</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">PIC</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Image</th>
                </tr>
            </thead>
            <tbody>
                @forelse($histories as $history)
                <tr class="border-b border-gray-100 hover:bg-pink-bg/50 transition">
                    <td class="px-4 py-4 font-medium text-gray-800">{{ $history->code_number ?: '-' }}</td>
                    <td class="px-4 py-4 text-gray-600">{{ $history->hm_km }}</td>
                    <td class="px-4 py-4 text-gray-600">{{ $history->wo ?: '-' }}</td>
                    <td class="px-4 py-4 text-gray-600">{{ $history->reservasi ?: '-' }}</td>
                    <td class="px-4 py-4 text-gray-600">{{ $history->replacement_date->format('d M Y') }}</td>
                    <td class="px-4 py-4 text-gray-600 text-sm max-w-xs truncate">{{ $history->notes ? Str::limit($history->notes, 30) : '-' }}</td>
                    <td class="px-4 py-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium">
                            {{ $history->category ?: '-' }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-gray-600 text-sm">{{ $history->component_name ?: '-' }}</td>
                    <td class="px-4 py-4 text-gray-600 text-sm">{{ $history->pic ?: '-' }}</td>
                    <td class="px-4 py-4">
                        @if($history->image)
                        <button type="button" onclick="showImage('{{ asset('storage/' . $history->image) }}')"
                                class="text-maroon hover:underline text-sm flex items-center gap-1">
                            <img src="{{ asset('storage/' . $history->image) }}"
                                 alt="Image" class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                        </button>
                        @else
                        <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-4 py-12 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                        <p class="text-lg font-medium">No records found</p>
                        <p class="text-sm">No approved replacement history</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($histories->hasPages())
    <div class="p-5 border-t border-gray-200 bg-white">
        {{ $histories->withQueryString()->links() }}
    </div>
    @endif
</div>

<div id="imageModal" class="hidden fixed inset-0 bg-gray-900/90 z-50 flex items-center justify-center p-4 backdrop-blur-sm transition-opacity">
    <button onclick="closeImage()" class="absolute top-5 right-5 text-gray-300 hover:text-white text-3xl transition-colors">
        <i class="fas fa-times"></i>
    </button>
    <img id="modalImage" src="" alt="Full Image" class="max-w-full max-h-[85vh] rounded-xl shadow-2xl object-contain border border-gray-700">
</div>

<script>
function showImage(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImage() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImage();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImage();
    }
});
</script>
@endsection