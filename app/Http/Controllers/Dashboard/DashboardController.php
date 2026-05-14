<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Exports\ReplacementHistoryExport;
use App\Models\ReplacementHistory;
use App\Models\Unit;
use App\Models\Component;
use App\Models\AplItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    // ================== MEKANIK ==================

    public function mekanikIndex()
    {
        $user = Auth::user();

        $totalReplacement = ReplacementHistory::where('user_id', $user->id)
            ->where('status', 'approved')
            ->count();

        $totalReplacementToday = ReplacementHistory::where('user_id', $user->id)
            ->where('status', 'approved')
            ->whereDate('approved_at', today())
            ->count();

        $totalUnitHandled = ReplacementHistory::where('user_id', $user->id)
            ->whereNotNull('code_number')
            ->get()
            ->map(fn($r) => explode('-', $r->code_number)[0])
            ->filter()
            ->unique()
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
            'wo' => 'nullable|string|max:100',
            'reservasi' => 'nullable|string|max:100',
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

    public function mekanikHistorical(Request $request)
    {
        $query = ReplacementHistory::with(['user'])
            ->where('status', 'approved');

        $search = $request->get('search');
        $query->when($search, fn($q) => $q->where(fn($q) => $q
            ->where('code_number', 'like', "%{$search}%")
            ->orWhere('component_name', 'like', "%{$search}%")
            ->orWhere('hm_km', 'like', "%{$search}%")
            ->orWhere('wo', 'like', "%{$search}%")
            ->orWhere('reservasi', 'like', "%{$search}%")
            ->orWhere('notes', 'like', "%{$search}%")
        ));

        $histories = $query->latest()->paginate(10)->withQueryString();

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
        $totalReplacement = ReplacementHistory::where('status', 'approved')->count();

        $totalReplacementToday = ReplacementHistory::where('status', 'approved')
            ->whereDate('approved_at', today())
            ->count();

        $totalUnitHandled = ReplacementHistory::whereNotNull('code_number')
            ->where('status', 'approved')
            ->get()
            ->map(fn($r) => explode('-', $r->code_number)[0])
            ->filter()
            ->unique()
            ->count();

        $recentHistories = ReplacementHistory::with(['user', 'unit', 'component'])
            ->latest()
            ->limit(10)
            ->get();

        return view('dashboard.management.dashboard', compact(
            'totalReplacement',
            'totalUnitHandled',
            'totalReplacementToday',
            'recentHistories'
        ));
    }

    public function managementHistorical(Request $request)
    {
        $query = ReplacementHistory::with(['user'])
            ->where('status', 'approved');

        $search = $request->get('search');
        $query->when($search, fn($q) => $q->where(fn($q) => $q
            ->where('code_number', 'like', "%{$search}%")
            ->orWhere('component_name', 'like', "%{$search}%")
            ->orWhere('hm_km', 'like', "%{$search}%")
            ->orWhere('wo', 'like', "%{$search}%")
            ->orWhere('reservasi', 'like', "%{$search}%")
            ->orWhere('notes', 'like', "%{$search}%")
        ));

        $histories = $query->latest()->paginate(15)->withQueryString();

        return view('dashboard.management.historical', compact('histories'));
    }

    public function managementHistoricalExport(Request $request)
    {
        if (Auth::user()->role !== 'planner') {
            abort(403, 'Unauthorized');
        }

        $search = $request->get('search');

        return Excel::download(
            new ReplacementHistoryExport($search),
            'historical-replacement-' . now()->format('Y-m-d') . '.xlsx'
        );
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