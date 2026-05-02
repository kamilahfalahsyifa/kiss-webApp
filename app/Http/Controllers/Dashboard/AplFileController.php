<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AplFile;
use App\Models\AplSheet;
use App\Models\AplItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AplFileController extends Controller
{
    public function index()
    {
        $aplFiles = AplFile::with('sheets')->latest()->get();

        if (Auth::user()->role === 'mekanik') {
            return view('dashboard.mekanik.apl-files', compact('aplFiles'));
        }

        return view('dashboard.management.apl-files.index', compact('aplFiles'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'planner') {
            abort(403, 'Unauthorized');
        }

        return view('dashboard.management.apl-files.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'planner') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        AplFile::create($validated);

        return redirect()->route('management.apl-files')->with('success', 'APL File created successfully');
    }

    public function show(AplFile $aplFile)
    {
        $aplFile->load('sheets.items');

        if (Auth::user()->role === 'mekanik') {
            return view('dashboard.mekanik.apl-show', compact('aplFile'));
        }

        return view('dashboard.management.apl-files.show', compact('aplFile'));
    }

    public function edit(AplFile $aplFile)
    {
        if (Auth::user()->role !== 'planner') {
            abort(403, 'Unauthorized');
        }

        return view('dashboard.management.apl-files.edit', compact('aplFile'));
    }

    public function update(Request $request, AplFile $aplFile)
    {
        if (Auth::user()->role !== 'planner') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $aplFile->update($validated);

        return redirect()->route('management.apl-files')->with('success', 'APL File updated successfully');
    }

    public function destroy(AplFile $aplFile)
    {
        if (Auth::user()->role !== 'planner') {
            abort(403, 'Unauthorized');
        }

        $aplFile->delete();

        return redirect()->route('management.apl-files')->with('success', 'APL File deleted successfully');
    }
}
