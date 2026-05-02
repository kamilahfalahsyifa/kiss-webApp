@extends('layouts.authenticated')

@section('main')
<div class="space-y-4">
    <h1 class="text-xl font-bold text-gray-800">History Replacement</h1>

    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table table-zebra table-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-3 text-xs font-semibold text-gray-600">Date</th>
                        <th class="px-3 py-3 text-xs font-semibold text-gray-600">Part Number</th>
                        <th class="px-3 py-3 text-xs font-semibold text-gray-600">Description</th>
                        <th class="px-3 py-3 text-xs font-semibold text-gray-600 text-center">Qty</th>
                        <th class="px-3 py-3 text-xs font-semibold text-gray-600 text-center">Install</th>
                        <th class="px-3 py-3 text-xs font-semibold text-gray-600">User</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-3 text-sm">{{ \Carbon\Carbon::parse($activity->date)->format('d/m/y') }}</td>
                        <td class="px-3 py-3 text-sm font-medium">{{ $activity->part_number }}</td>
                        <td class="px-3 py-3 text-sm max-w-[120px] truncate">{{ $activity->description }}</td>
                        <td class="px-3 py-3 text-sm text-center">{{ $activity->qty }}</td>
                        <td class="px-3 py-3 text-center">
                            <span class="badge badge-sm {{ $activity->remarks_install == 'V' ? 'badge-success' : 'badge-error' }}">
                                {{ $activity->remarks_install }}
                            </span>
                        </td>
                        <td class="px-3 py-3 text-sm text-gray-500">{{ $activity->user->name ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-3 py-8 text-center text-gray-500">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
