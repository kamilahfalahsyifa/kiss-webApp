<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ReplacementHistory;
use App\Models\Unit;
use App\Models\Component;
use App\Models\AplItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // ================== MEKANIK ==================

    public function mekanikIndex()
    {
        $user = Auth::user();

        $totalUnitHandled = Unit::count();
        $totalReplacement = ReplacementHistory::where('user_id', $user->id)->count();
        $totalReplacementToday = ReplacementHistory::where('user_id', $user->id)
            ->whereDate('replacement_date', today())
            ->count();

        $recentActivities = ReplacementHistory::with(['unit', 'component'])
            ->where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.mekanik.dashboard', compact(
            'totalUnitHandled',
            'totalReplacement',
            'totalReplacementToday',
            'recentActivities'
        ));
    }

    public function mekanikInput()
    {
        $units = Unit::where('status', 'active')->get();
        $components = Component::all();
        return view('dashboard.mekanik.input-activity', compact('units', 'components'));
    }

    public function mekanikInputData()
    {
        $units = Unit::where('status', 'active')->get();
        $components = Component::all();
        return view('dashboard.mekanik.input-data-activity', compact('units', 'components'));
    }

    public function storeActivity(Request $request)
    {
        $validated = $request->validate([
            'code_number' => 'required|string|max:50',
            'hm_km' => 'required|string|max:50',
            'replacement_date' => 'required|date',
            'category' => 'required|string|max:50',
            'component_name' => 'required|string|max:100',
            'pic' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('replacement-images', 'public');
        }

        $validated['user_id'] = Auth::id();

        ReplacementHistory::create($validated);

        return redirect()->back()->with('success', 'Activity recorded successfully');
    }

    public function mekanikHistorical()
    {
        $histories = ReplacementHistory::with(['user'])
            ->where('status', 'approved')
            ->latest()
            ->paginate(10);

        return view('dashboard.mekanik.historical', compact('histories'));
    }

    public function mekanikAplFiles()
    {
        $aplFiles = \App\Models\AplFile::with('sheets')->latest()->get();
        return view('dashboard.mekanik.apl-files', compact('aplFiles'));
    }

    public function mekanikAplShow(\App\Models\AplFile $aplFile)
    {
        $aplFile->load('sheets.items');
        return view('dashboard.mekanik.apl-show', compact('aplFile'));
    }

    public function storeAplItem(Request $request)
    {
        if (Auth::user()->role !== 'mekanik') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'sheet_name' => 'required|string',
            'apl_file_id' => 'required|exists:apl_files,id',
            'part_number' => 'required|string',
            'stock_code' => 'required|string',
            'description' => 'nullable|string',
            'qty' => 'required|integer|min:0',
            'stock' => 'required|string',
            'price' => 'required|numeric|min:0',
            'wr' => 'nullable|string',
            'remarks_install' => 'nullable|in:YES,NO',
        ]);

        $validated['amount'] = $validated['qty'] * $validated['price'];

        $sheet = \App\Models\AplSheet::where('apl_file_id', $validated['apl_file_id'])
            ->where('name', $validated['sheet_name'])
            ->first();

        if (!$sheet) {
            $sheet = \App\Models\AplSheet::create([
                'apl_file_id' => $validated['apl_file_id'],
                'name' => $validated['sheet_name'],
            ]);
        }

        $validated['apl_sheet_id'] = $sheet->id;
        unset($validated['sheet_name']);

        \App\Models\AplItem::create($validated);

        return redirect()->back()->with('success', 'Item added successfully');
    }

    public function updateAplItem(Request $request, AplItem $aplItem)
    {
        if (Auth::user()->role !== 'mekanik') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'part_number' => 'required|string',
            'stock_code' => 'required|string',
            'description' => 'nullable|string',
            'qty' => 'required|integer|min:0',
            'stock' => 'required|string',
            'price' => 'required|numeric|min:0',
            'wr' => 'nullable|string',
            'remarks_install' => 'nullable|in:YES,NO',
        ]);

        $validated['amount'] = $validated['qty'] * $validated['price'];
        $aplItem->update($validated);

        return redirect()->back()->with('success', 'Item updated successfully');
    }

    public function deleteAplItem(AplItem $aplItem)
    {
        if (Auth::user()->role !== 'mekanik') {
            abort(403, 'Unauthorized');
        }

        $aplItem->delete();

        return redirect()->back()->with('success', 'Item deleted successfully');
    }

    public function mekanikProfile()
    {
        return view('dashboard.mekanik.profile');
    }

    // ================== MANAGEMENT (GL/TERE/PLANNER) ==================

    public function managementIndex()
    {
        $totalReplacement = ReplacementHistory::count();
        $totalUnit = Unit::count();
        $totalComponent = Component::count();

        $recentHistories = ReplacementHistory::with(['user', 'unit', 'component'])
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.management.dashboard', compact(
            'totalReplacement',
            'totalUnit',
            'totalComponent',
            'recentHistories'
        ));
    }

    public function managementHistorical()
    {
        $histories = ReplacementHistory::with(['user'])
            ->where('status', 'approved')
            ->latest()
            ->paginate(15);

        return view('dashboard.management.historical', compact('histories'));
    }

    public function managementAplFiles()
    {
        $aplFiles = \App\Models\AplFile::with('sheets')->latest()->get();
        return view('dashboard.management.apl-files.index', compact('aplFiles'));
    }

    public function showAplFile(\App\Models\AplFile $aplFile)
    {
        $aplFile->load('sheets.items');
        return view('dashboard.management.apl-files.show', compact('aplFile'));
    }

    public function managementProfile()
    {
        return view('dashboard.management.profile');
    }
}