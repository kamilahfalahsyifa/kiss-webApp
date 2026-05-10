<?php

namespace App\Http\Controllers;

use App\Models\AplItem;
use App\Models\AplSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AplItemController extends Controller
{
    public function store(Request $request, AplSheet $aplSheet)
    {
        if (Auth::user()->role !== 'planner') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'part_number' => 'required|string|max:255',
            'stock_code' => 'required|string|max:255',
            'description' => 'nullable|string',
            'qty' => 'required|integer|min:0',
            'stock' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'wr' => 'nullable|string|max:255',
            'remarks_install' => 'nullable|string|max:255',
        ]);

        $validated['apl_sheet_id'] = $aplSheet->id;
        $validated['amount'] = $validated['qty'] * $validated['price'];
        AplItem::create($validated);

        return redirect()->back()->with('success', 'Item created successfully');
    }

    public function update(Request $request, AplItem $aplItem)
    {
        if (Auth::user()->role !== 'planner') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'part_number' => 'required|string|max:255',
            'stock_code' => 'required|string|max:255',
            'description' => 'nullable|string',
            'qty' => 'required|integer|min:0',
            'stock' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'wr' => 'nullable|string|max:255',
            'remarks_install' => 'nullable|string|max:255',
        ]);

        $validated['amount'] = $validated['qty'] * $validated['price'];
        $aplItem->update($validated);

        return redirect()->back()->with('success', 'Item updated successfully');
    }

    public function destroy(AplItem $aplItem)
    {
        if (Auth::user()->role !== 'planner') {
            abort(403, 'Unauthorized');
        }

        $aplItem->delete();

        return redirect()->back()->with('success', 'Item deleted successfully');
    }
}