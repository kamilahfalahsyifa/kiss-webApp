<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ReplacementHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = $user->role === 'mekanik'
            ? ReplacementHistory::where('user_id', Auth::id())
            : ReplacementHistory::query();

        $search = $request->get('search');
        $query->when($search, fn($q) => $q->where(fn($q) => $q
            ->where('code_number', 'like', "%{$search}%")
            ->orWhere('component_name', 'like', "%{$search}%")
            ->orWhere('hm_km', 'like', "%{$search}%")
        ));

        $status = $request->get('status');
        $query->when($status, fn($q) => $q->where('status', $status));

        $statuses = ['pending', 'approved', 'rejected'];
        $activities = $query->latest()->paginate(10)->withQueryString();

        return view('activities.index', compact('activities', 'statuses'));
    }

    public function create()
    {
        return view('activities.create');
    }

    public function store(Request $request)
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

        return redirect()
            ->route('mekanik.activities.index')
            ->with('success', 'Activity recorded successfully');
    }

    public function edit(ReplacementHistory $activity)
    {
        if ($activity->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('activities.edit', compact('activity'));
    }

    public function update(Request $request, ReplacementHistory $activity)
    {
        if ($activity->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

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

        $activity->update($validated);

        return redirect()
            ->route('mekanik.activities.index')
            ->with('success', 'Activity updated successfully');
    }

    public function destroy(ReplacementHistory $activity)
    {
        if ($activity->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $activity->delete();

        return redirect()
            ->route('mekanik.activities.index')
            ->with('success', 'Activity deleted successfully');
    }

    // ================== GL APPROVAL ==================

    public function approve(ReplacementHistory $activity)
    {
        $user = Auth::user();
        if ($user->role !== 'gl') {
            abort(403, 'Unauthorized');
        }

        $activity->status = 'approved';
        $activity->approved_by = $user->id;
        $activity->approved_at = now();
        $activity->save();

        return redirect()
            ->route('management.activities.index')
            ->with('success', 'Activity approved successfully');
    }

    public function reject(ReplacementHistory $activity)
    {
        $user = Auth::user();
        if ($user->role !== 'gl') {
            abort(403, 'Unauthorized');
        }

        $activity->status = 'rejected';
        $activity->approved_by = $user->id;
        $activity->approved_at = now();
        $activity->save();

        return redirect()
            ->route('management.activities.index')
            ->with('success', 'Activity rejected');
    }
}
