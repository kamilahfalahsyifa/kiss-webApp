<?php

namespace App\Http\Controllers;

use App\Models\AplFile;
use App\Models\AplSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AplSheetController extends Controller
{
    public function store(Request $request, AplFile $aplFile)
    {
        if (Auth::user()->role !== 'planner') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validated['apl_file_id'] = $aplFile->id;
        AplSheet::create($validated);

        return redirect()->back()->with('success', 'Sheet created successfully');
    }

    public function update(Request $request, AplSheet $aplSheet)
    {
        if (Auth::user()->role !== 'planner') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $aplSheet->update($validated);

        return redirect()->back()->with('success', 'Sheet updated successfully');
    }

    public function destroy(AplSheet $aplSheet)
    {
        if (Auth::user()->role !== 'planner') {
            abort(403, 'Unauthorized');
        }

        $aplSheet->delete();

        return redirect()->back()->with('success', 'Sheet deleted successfully');
    }
}