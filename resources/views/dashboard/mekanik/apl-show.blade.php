@extends('layouts.dashboard')

@php
$activeSheet = request()->get('sheet');
@endphp

@section('page_title', $aplFile->name)
@section('page_subtitle', 'Spreadsheet view')

@section('content')
<!-- Horizontal Scrollable Sheet Tabs -->
@if($aplFile->sheets->count() > 0)
<div class="bg-white rounded-2xl shadow-md p-3 sm:p-4 border border-gray-100 mb-4 sm:mb-6">
    <div class="flex items-center gap-2 overflow-x-auto whitespace-nowrap pb-1 sm:pb-2">
        <span class="text-xs sm:text-sm font-semibold text-gray-500 mr-2 sm:mr-4 flex-shrink-0">Sheets:</span>
        @foreach($aplFile->sheets as $sheet)
        <a href="{{ route('mekanik.apl-files.show', $aplFile->id) }}?sheet={{ $sheet->id }}"
           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $activeSheet == $sheet->id || ($activeSheet == null && $loop->first) ? 'bg-maroon text-white' : 'bg-gray-100 text-gray-600 hover:bg-pink-bg' }}">
            {{ $sheet->name }}
        </a>
        @endforeach
    </div>
</div>
@endif

@php
$currentSheet = null;
if ($activeSheet) {
    $currentSheet = $aplFile->sheets->find($activeSheet);
}
if (!$currentSheet) {
    $currentSheet = $aplFile->sheets->first();
}
@endphp

<div class="bg-white rounded-2xl shadow-md p-4 sm:p-6 border border-gray-100">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4 sm:mb-6">
        <h3 class="text-base sm:text-lg font-bold text-gray-800">
            {{ $currentSheet->name ?? 'No Sheet' }}
            <span class="text-sm font-normal text-gray-500 ml-2">
                @if($currentSheet)
                ({{ $currentSheet->items->count() }} items)
                @else
                (0 items)
                @endif
            </span>
        </h3>
    </div>

    <div class="overflow-x-auto -mx-4 sm:mx-0 px-4 sm:px-0">
        <table class="table w-full">
            <thead>
                <tr class="border-b border-gray-200 bg-gray-50">
                    <th class="text-gray-600 font-semibold px-4 py-3">Part Number</th>
                    <th class="text-gray-600 font-semibold px-4 py-3">Stock Code</th>
                    <th class="text-gray-600 font-semibold px-4 py-3">Description</th>
                    <th class="text-gray-600 font-semibold px-4 py-3 text-right">Qty</th>
                    <th class="text-gray-600 font-semibold px-4 py-3">Stock</th>
                    <th class="text-gray-600 font-semibold px-4 py-3 text-right">Price</th>
                    <th class="text-gray-600 font-semibold px-4 py-3 text-right">Amount</th>
                    <th class="text-gray-600 font-semibold px-4 py-3">WR</th>
                    <th class="text-gray-600 font-semibold px-4 py-3">Install</th>
                </tr>
            </thead>
            <tbody>
                @if($currentSheet && $currentSheet->items->count() > 0)
                @foreach($currentSheet->items as $item)
                <tr class="border-b border-gray-100 hover:bg-pink-bg">
                    <td class="px-4 py-3 font-medium">{{ $item->part_number }}</td>
                    <td class="px-4 py-3">{{ $item->stock_code }}</td>
                    <td class="px-4 py-3 text-sm">{{ $item->description ?? '-' }}</td>
                    <td class="px-4 py-3 text-right">{{ $item->qty }}</td>
                    <td class="px-4 py-3">{{ $item->stock }}</td>
                    <td class="px-4 py-3 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-3 text-right font-semibold text-maroon">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                    <td class="px-4 py-3">{{ $item->wr ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium {{ $item->remarks_install === 'YES' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            
                            {{ $item->remarks_install ?? '-' }}
                        </span>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="9" class="py-12 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-4"></i>
                        <p>No items in this sheet.</p>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
