@extends('layouts.authenticated')

@section('main')
<div class="space-y-4">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold">{{ $component->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('apl-components.index') }}" class="btn btn-ghost">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
            @if($permissions['canAccessAplComponents'] ?? false)
            <a href="{{ route('apl-components.edit', $component->id) }}" class="btn btn-warning">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            @endif
        </div>
    </div>

    @if($component->description)
    <p class="text-base-content/70">{{ $component->description }}</p>
    @endif

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h3 class="font-semibold mb-4">Component Items</h3>
            <div class="overflow-x-auto">
                <table class="table table-zebra">
                    <thead>
                        <tr>
                            <th>Part Number</th>
                            <th>Stock Code</th>
                            <th>Description</th>
                            <th>Qty</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Amount</th>
                            <th>WR</th>
                            <th>Install</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($component->items as $item)
                        <tr>
                            <td>{{ $item->part_number }}</td>
                            <td>{{ $item->stock_code }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>{{ number_format($item->price, 2) }}</td>
                            <td>{{ number_format($item->amount, 2) }}</td>
                            <td>{{ $item->wr }}</td>
                            <td>
                                <span class="badge {{ $item->remarks_install == 'V' ? 'badge-success' : 'badge-error' }}">
                                    {{ $item->remarks_install == 'V' ? 'Yes' : 'No' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-gray-500 py-4">No items found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
