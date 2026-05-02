@extends('layouts.authenticated')

@section('main')
<div class="space-y-4">
    <h1 class="text-xl font-bold text-gray-800">Input Activity</h1>

    @if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('activity-replacements.store') }}" class="bg-white rounded-2xl shadow-md p-5">
        @csrf

        <div class="space-y-4">
            <div class="form-control">
                <label class="label py-1"><span class="label-text text-sm font-medium">Date</span></label>
                <input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required
                    class="input input-bordered bg-gray-50 @error('date') input-error @enderror" />
            </div>

            <div class="form-control">
                <label class="label py-1"><span class="label-text text-sm font-medium">Part Number</span></label>
                <input type="text" name="part_number" value="{{ old('part_number') }}" required placeholder="Enter part number"
                    class="input input-bordered bg-gray-50 @error('part_number') input-error @enderror" />
            </div>

            <div class="form-control">
                <label class="label py-1"><span class="label-text text-sm font-medium">Stock Code</span></label>
                <input type="text" name="stock_code" value="{{ old('stock_code') }}" required placeholder="Enter stock code"
                    class="input input-bordered bg-gray-50 @error('stock_code') input-error @enderror" />
            </div>

            <div class="form-control">
                <label class="label py-1"><span class="label-text text-sm font-medium">Description</span></label>
                <input type="text" name="description" value="{{ old('description') }}" required placeholder="Enter description"
                    class="input input-bordered bg-gray-50 @error('description') input-error @enderror" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label py-1"><span class="label-text text-sm font-medium">Qty</span></label>
                    <input type="number" name="qty" value="{{ old('qty', 1) }}" min="1" required
                        class="input input-bordered bg-gray-50 @error('qty') input-error @enderror" />
                </div>

                <div class="form-control">
                    <label class="label py-1"><span class="label-text text-sm font-medium">Stock</span></label>
                    <input type="text" name="stock" value="{{ old('stock') }}" required placeholder="Stock"
                        class="input input-bordered bg-gray-50 @error('stock') input-error @enderror" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label py-1"><span class="label-text text-sm font-medium">Price</span></label>
                    <input type="number" name="price" value="{{ old('price', 0) }}" min="0" step="0.01" required
                        class="input input-bordered bg-gray-50 @error('price') input-error @enderror" />
                </div>

                <div class="form-control">
                    <label class="label py-1"><span class="label-text text-sm font-medium">Amount</span></label>
                    <input type="number" name="amount" value="{{ old('amount', 0) }}" min="0" step="0.01" required
                        class="input input-bordered bg-gray-50 @error('amount') input-error @enderror" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label py-1"><span class="label-text text-sm font-medium">WR</span></label>
                    <input type="text" name="wr" value="{{ old('wr') }}" required placeholder="WR"
                        class="input input-bordered bg-gray-50 @error('wr') input-error @enderror" />
                </div>

                <div class="form-control">
                    <label class="label py-1"><span class="label-text text-sm font-medium">Install</span></label>
                    <select name="remarks_install" required class="select select-bordered bg-gray-50 @error('remarks_install') select-error @enderror">
                        <option value="">Pilih</option>
                        <option value="V" {{ old('remarks_install') == 'V' ? 'selected' : '' }}>Yes (V)</option>
                        <option value="X" {{ old('remarks_install') == 'X' ? 'selected' : '' }}>No (X)</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <a href="{{ route('activity-replacements.index') }}" class="btn btn-ghost flex-1">Cancel</a>
            <button type="submit" class="btn btn-primary flex-1">Save</button>
        </div>
    </form>
</div>
@endsection
