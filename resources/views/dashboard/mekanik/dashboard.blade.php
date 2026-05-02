@extends('layouts.dashboard')

@section('page_title', 'Dashboard')
@section('page_subtitle', 'Mekanik Panel')

@php
$roleLabels = ['mekanik' => 'Mekanik', 'gl' => 'GL', 'tere' => 'Tere', 'planner' => 'Planner'];
@endphp

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <x-stat-card label="Total Unit Handled" :value="$totalUnitHandled" icon="fas fa-truck" iconColor="text-maroon" />
    <x-stat-card label="Total Replacement" :value="$totalReplacement" icon="fas fa-clock" iconColor="text-warning" />
    <x-stat-card label="Replacement Today" :value="$totalReplacementToday" icon="fas fa-check" iconColor="text-success" />
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Activity</h3>
    <div class="overflow-x-auto">
        <table class="table w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-gray-600 font-semibold">Code Number</th>
                    <th class="text-gray-600 font-semibold">HM Unit</th>
                    <th class="text-gray-600 font-semibold">Date</th>
                    <th class="text-gray-600 font-semibold">Activity</th>
                    <th class="text-gray-600 font-semibold">Category</th>
                    <th class="text-gray-600 font-semibold">Component</th>
                    <th class="text-gray-600 font-semibold">PIC</th>
                    <th class="text-gray-600 font-semibold">Image</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentActivities as $activity)
                <tr class="border-b border-gray-100 hover:bg-pink-bg">
                    <td class="px-4 py-3 font-medium">{{ $activity->code_number ?: '-' }}</td>
                    <td class="px-4 py-3">{{ $activity->hm_km }}</td>
                    <td class="px-4 py-3">{{ $activity->replacement_date->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-sm">{{ $activity->notes ? Str::limit($activity->notes, 40) : '-' }}</td>
                    <td class="px-4 py-3">{{ $activity->category ?: '-' }}</td>
                    <td class="px-4 py-3">{{ $activity->component_name ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $activity->pic ?? '-' }}</td>
                    <td class="px-4 py-4">
                        @if($activity->image)
                        <button type="button" onclick="showImage('{{ asset('storage/' . $activity->image) }}')"
                                class="text-maroon hover:underline text-sm flex items-center gap-1">
                            <img src="{{ asset('storage/' . $activity->image) }}"
                                 alt="Image" class="w-12 h-12 object-cover rounded-lg border border-gray-200">
                        </button>
                        @else
                        <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-6 text-center text-gray-500">No recent activity</td>
                </tr>
                @endforelse
            </tbody>
        </table>
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