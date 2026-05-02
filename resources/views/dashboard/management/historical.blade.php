@extends('layouts.dashboard')

@section('page_title', 'Historical')
@section('page_subtitle', 'All replacement history records')

@section('content')
<div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
    <h3 class="text-lg font-bold text-gray-800 mb-6">All Replacement History</h3>

    <div class="overflow-x-auto">
        <table class="table w-full">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                    <th class="text-gray-600 font-semibold px-4 py-3">Code Number</th>
                    <th class="text-gray-600 font-semibold px-4 py-3">HM Unit</th>
                    <th class="text-gray-600 font-semibold px-4 py-3">Date</th>
                    <th class="text-gray-600 font-semibold px-4 py-3">Activity</th>
                    <th class="text-gray-600 font-semibold px-4 py-3">Category</th>
                    <th class="text-gray-600 font-semibold px-4 py-3">Component</th>
                    <th class="text-gray-600 font-semibold px-4 py-3">PIC</th>
                    <th class="text-gray-600 font-semibold px-4 py-3">Image</th>
                </tr>
            </thead>
            <tbody>
                @forelse($histories as $history)
                <tr class="border-b border-gray-100 hover:bg-pink-bg">
                    <td class="px-4 py-3 font-medium">{{ $history->code_number ?: '-' }}</td>
                    <td class="px-4 py-3">{{ $history->hm_km }}</td>
                    <td class="px-4 py-3">{{ $history->replacement_date->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-sm">{{ $history->notes ? Str::limit($history->notes, 50) : '-' }}</td>
                    <td class="px-4 py-3">{{ $history->category ?: '-' }}</td>
                    <td class="px-4 py-3">{{ $history->component_name ?: '-' }}</td>
                    <td class="px-4 py-3">{{ $history->pic ?: '-' }}</td>
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
                    <td colspan="8" class="py-12 text-center text-gray-500">
                        <i class="fas fa-history text-4xl mb-4"></i>
                        <p>No records found</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $histories->links() }}
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4">
    <button onclick="closeImage()" class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300">
        <i class="fas fa-times"></i>
    </button>
    <img id="modalImage" src="" alt="Image" class="max-w-full max-h-[90vh] rounded-lg shadow-lg">
</div>

<script>
function showImage(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').classList.remove('hidden');
}
function closeImage() {
    document.getElementById('imageModal').classList.add('hidden');
}
</script>
@endsection