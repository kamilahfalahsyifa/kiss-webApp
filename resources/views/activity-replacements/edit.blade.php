@extends('layouts.authenticated')

@section('main')
<div class="space-y-4">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">Edit Activity</h1>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-error mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('activity-replacements.update', $activity->id) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-control">
                        <label class="label"><span class="label-text">Date</span></label>
                        <input type="date" name="date" value="{{ old('date', $activity->date) }}" required
                            class="input input-bordered @error('date') input-error @enderror" />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Part Number</span></label>
                        <input type="text" name="part_number" value="{{ old('part_number', $activity->part_number) }}" required
                            class="input input-bordered @error('part_number') input-error @enderror" />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Stock Code</span></label>
                        <input type="text" name="stock_code" value="{{ old('stock_code', $activity->stock_code) }}" required
                            class="input input-bordered @error('stock_code') input-error @enderror" />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Description</span></label>
                        <input type="text" name="description" value="{{ old('description', $activity->description) }}" required
                            class="input input-bordered @error('description') input-error @enderror" />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Qty</span></label>
                        <input type="number" name="qty" value="{{ old('qty', $activity->qty) }}" min="1" required
                            class="input input-bordered @error('qty') input-error @enderror" />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Stock</span></label>
                        <input type="text" name="stock" value="{{ old('stock', $activity->stock) }}" required
                            class="input input-bordered @error('stock') input-error @enderror" />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Price</span></label>
                        <input type="number" name="price" value="{{ old('price', $activity->price) }}" min="0" step="0.01" required
                            class="input input-bordered @error('price') input-error @enderror" />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Amount</span></label>
                        <input type="number" name="amount" value="{{ old('amount', $activity->amount) }}" min="0" step="0.01" required
                            class="input input-bordered @error('amount') input-error @enderror" />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">WR</span></label>
                        <input type="text" name="wr" value="{{ old('wr', $activity->wr) }}" required
                            class="input input-bordered @error('wr') input-error @enderror" />
                    </div>

                    <div class="form-control">
                        <label class="label"><span class="label-text">Remarks Install</span></label>
                        <select name="remarks_install" required class="select select-bordered @error('remarks_install') select-error @enderror">
                            <option value="V" {{ $activity->remarks_install == 'V' ? 'selected' : '' }}>Yes (V)</option>
                            <option value="X" {{ $activity->remarks_install == 'X' ? 'selected' : '' }}>No (X)</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <a href="{{ route('activity-replacements.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
