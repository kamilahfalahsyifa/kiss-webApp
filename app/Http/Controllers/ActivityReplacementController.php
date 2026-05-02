<?php

namespace App\Http\Controllers;

use App\Models\ActivityReplacement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityReplacementController extends Controller
{
    private function getPermissions() {
        $user = Auth::user();
        $role = $user?->role ?? 'mekanik';
        return [
            'canAccessHistory' => true,
            'canAccessInputActivity' => $role === 'mekanik',
            'canAccessAplComponents' => $role !== 'mekanik',
        ];
    }

    public function index()
    {
        return view('activity-replacements.index', [
            'activities' => \App\Models\ActivityReplacement::with('user')->latest()->get(),
            'permissions' => $this->getPermissions(),
        ]);
    }

    public function create()
    {
        return view('activity-replacements.create', [
            'permissions' => $this->getPermissions(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'part_number' => 'required|string|max:255',
            'stock_code' => 'required|string|max:255',
            'description' => 'required|string',
            'qty' => 'required|integer|min:1',
            'stock' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'wr' => 'required|string|max:255',
            'remarks_install' => 'required|in:V,X',
        ]);

        \App\Models\ActivityReplacement::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('activity-replacements.index');
    }

    public function edit(\App\Models\ActivityReplacement $activityReplacement)
    {
        return view('activity-replacements.edit', [
            'activity' => $activityReplacement,
            'permissions' => $this->getPermissions(),
        ]);
    }

    public function update(Request $request, \App\Models\ActivityReplacement $activityReplacement)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'part_number' => 'required|string|max:255',
            'stock_code' => 'required|string|max:255',
            'description' => 'required|string',
            'qty' => 'required|integer|min:1',
            'stock' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'wr' => 'required|string|max:255',
            'remarks_install' => 'required|in:V,X',
        ]);

        $activityReplacement->update($validated);

        return redirect()->route('activity-replacements.index');
    }

    public function destroy(\App\Models\ActivityReplacement $activityReplacement)
    {
        $activityReplacement->delete();

        return redirect()->route('activity-replacements.index');
    }
}
