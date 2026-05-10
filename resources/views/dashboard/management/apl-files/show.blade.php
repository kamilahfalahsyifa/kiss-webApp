@extends('layouts.dashboard')

@php
$activeSheet = request()->get('sheet');
$isPlanner = Auth::user()->role === 'planner';
@endphp

@section('page_title', $aplFile->name)
@section('page_subtitle', 'Spreadsheet view')

@section('content')
<!-- Horizontal Scrollable Sheet Tabs -->
<div class="bg-white/80 backdrop-blur rounded-2xl shadow-sm p-4 border border-gray-100 mb-6">
    <div class="flex items-center justify-between">
        
        <div class="flex items-center gap-2 overflow-x-auto whitespace-nowrap flex-1">
            <span class="text-sm font-semibold text-gray-400 mr-3">Sheets</span>

            @foreach($aplFile->sheets as $sheet)
            <a href="{{ route('management.apl-files.show', $aplFile->id) }}?sheet={{ $sheet->id }}"
               class="group px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200
               {{ $activeSheet == $sheet->id || ($activeSheet == null && $loop->first)
                   ? 'bg-maroon text-white shadow-md'
                   : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">

                {{ $sheet->name }}

                @if($isPlanner)
                <form action="{{ route('management.sheets.destroy', $sheet->id) }}" method="POST" class="inline ml-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="opacity-0 group-hover:opacity-100 transition text-xs ml-1 hover:text-red-400"
                        onclick="return confirm('Delete this sheet?')">
                        ✕
                    </button>
                </form>
                @endif
            </a>
            @endforeach
        </div>

        @if($isPlanner)
        <button onclick="document.getElementById('addSheetModal').classList.remove('hidden')"
            class="btn btn-sm bg-maroon text-white rounded-xl shadow hover:scale-105 transition">
            + Sheet
        </button>
        @endif
    </div>
</div>

<!-- Add Sheet Modal -->
@if($isPlanner)
<div id="addSheetModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <h3 class="text-lg font-bold mb-4">Add New Sheet</h3>
        <form action="{{ route('management.apl-files.sheets.store', $aplFile->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Sheet Name</label>
                <input type="text" name="name" required placeholder="e.g. Sheet 1"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none">
            </div>
            <div class="flex gap-3">
                <button type="submit" class="btn bg-maroon text-white">Save</button>
                <button type="button" onclick="document.getElementById('addSheetModal').classList.add('hidden')" class="btn btn-ghost">Cancel</button>
            </div>
        </form>
    </div>
</div>
@endif

<!-- Table Content -->
@php
$currentSheet = $activeSheet ? $aplFile->sheets->find($activeSheet) : $aplFile->sheets->first();
@endphp

<div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-gray-800">
            {{ $currentSheet->name ?? 'No Sheet' }}
            <span class="text-sm font-normal text-gray-500 ml-2">
                @if($currentSheet && $currentSheet->items)
                    ({{ $currentSheet->items->count() }} items)
                @else
                    (0 items)
                @endif
            </span>
        </h3>
        @if($isPlanner && $currentSheet)
        <button type="button" onclick="document.getElementById('addItemModal').classList.remove('hidden')" class="btn btn-sm bg-maroon text-white rounded-xl shadow hover:scale-105 transition">
            <i class="fas fa-plus mr-1"></i> Add Item
        </button>
        @endif
    </div>

    <!-- Add Item Modal -->
    @if($isPlanner && $currentSheet)
    <div id="addItemModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <h3 class="text-lg font-bold mb-4">Add New Item</h3>
            <form action="{{ route('management.sheets.items.store', $currentSheet->id) }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Part Number *</label>
                        <input type="text" name="part_number" required class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock Code *</label>
                        <input type="text" name="stock_code" required class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <input type="text" name="description" class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Qty *</label>
                        <input type="number" name="qty" required min="0" class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                        <input type="text" name="stock" class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                        <input type="number" name="price" required min="0" step="0.01" class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">WR</label>
                        <input type="text" name="wr" class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Install</label>
                        <select name="remarks_install" class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none">
                            <option value="">-</option>
                            <option value="YES">YES</option>
                            <option value="NO">NO</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button type="submit" class="btn bg-maroon text-white">Save</button>
                    <button type="button" onclick="document.getElementById('addItemModal').classList.add('hidden')" class="btn btn-ghost">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <div class="overflow-x-auto">
        <table class="table w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Part Number</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Stock Code</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Description</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-right">Qty</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Stock</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-right">Price</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-right">Amount</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">WR</th>
                    <th class="text-gray-600 font-semibold px-4 py-4 text-left">Install</th>
                    @if($isPlanner)<th class="text-gray-600 font-semibold px-4 py-4 text-center">Actions</th>@endif
                </tr>
            </thead>
            <tbody>
                @forelse($currentSheet && $currentSheet->items ? $currentSheet->items : [] as $item)
                <tr class="border-b border-gray-100 hover:bg-pink-bg/50 transition">
                    <td class="px-4 py-4 font-medium text-gray-800">{{ $item->part_number }}</td>
                    <td class="px-4 py-4 text-gray-600">{{ $item->stock_code }}</td>
                    <td class="px-4 py-4 text-gray-600 text-sm">{{ $item->description ?? '-' }}</td>
                    <td class="px-4 py-4 text-gray-600 text-right">{{ $item->qty }}</td>
                    <td class="px-4 py-4 text-gray-600">{{ $item->stock }}</td>
                    <td class="px-4 py-4 text-gray-600 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="px-4 py-4 text-gray-800 text-right font-semibold text-maroon">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                    <td class="px-4 py-4 text-gray-600">{{ $item->wr ?? '-' }}</td>
                    <td class="px-4 py-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-medium {{ $item->remarks_install === 'YES' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $item->remarks_install ?? '-' }}
                        </span>
                    </td>
                    @if($isPlanner)
                    <td class="px-4 py-4">
                        <div class="flex items-center justify-center gap-2">
                        <button onclick="editItem({{ $item->id }}, '{{ $item->part_number }}', '{{ $item->stock_code }}', '{{ $item->description ?? '' }}', {{ $item->qty }}, '{{ $item->stock ?? '' }}', {{ $item->price }}, '{{ $item->wr ?? '' }}', '{{ $item->remarks_install ?? '' }}')" class="btn btn-sm bg-yellow-100 text-yellow-700 hover:bg-yellow-200 border-none px-3 py-1.5 rounded-lg">
                            <i class="fas fa-edit text-xs"></i>
                        </button>
                        <form action="{{ route('management.items.destroy', $item->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm bg-red-100 text-red-700 hover:bg-red-200 border-none px-3 py-1.5 rounded-lg" onclick="return confirm('Delete this item?')">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ $isPlanner ? '10' : '9' }}" class="px-4 py-12 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                        <p class="text-lg font-medium">No items in this sheet</p>
                        <p class="text-sm">Add items to get started</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Item Modal -->
@if($isPlanner)
<div id="editItemModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-bold mb-4">Edit Item</h3>
        <form id="editItemForm" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Part Number *</label>
                    <input type="text" name="part_number" id="edit_part_number" required class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stock Code *</label>
                    <input type="text" name="stock_code" id="edit_stock_code" required class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <input type="text" name="description" id="edit_description" class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Qty *</label>
                    <input type="number" name="qty" id="edit_qty" required min="0" class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                    <input type="text" name="stock" id="edit_stock" class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price *</label>
                    <input type="number" name="price" id="edit_price" required min="0" step="0.01" class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">WR</label>
                    <input type="text" name="wr" id="edit_wr" class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Install</label>
                    <select name="remarks_install" id="edit_remarks_install" class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:bg-white focus:border-maroon focus:ring-2 focus:ring-maroon/20 outline-none">
                        <option value="">-</option>
                        <option value="YES">YES</option>
                        <option value="NO">NO</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="btn bg-maroon text-white">Update</button>
                <button type="button" onclick="document.getElementById('editItemModal').classList.add('hidden')" class="btn btn-ghost">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function editItem(id, partNumber, stockCode, description, qty, stock, price, wr, remarksInstall) {
    document.getElementById('editItemForm').action = '/management/items/' + id;
    document.getElementById('edit_part_number').value = partNumber;
    document.getElementById('edit_stock_code').value = stockCode;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_qty').value = qty;
    document.getElementById('edit_stock').value = stock;
    document.getElementById('edit_price').value = price;
    document.getElementById('edit_wr').value = wr;
    document.getElementById('edit_remarks_install').value = remarksInstall;
    document.getElementById('editItemModal').classList.remove('hidden');
}
</script>
@endif

@if(session('success'))
<div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-4 rounded-xl shadow-lg z-50">
    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
</div>
@endif
@endsection