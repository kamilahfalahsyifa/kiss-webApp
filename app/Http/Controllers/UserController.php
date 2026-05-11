<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'tere') {
            abort(403, 'Unauthorized');
        }

        $users = User::latest()->paginate(10);
        return view('dashboard.management.users.index', compact('users'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'tere') {
            abort(403, 'Unauthorized');
        }

        return view('dashboard.management.users.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'tere') {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:mekanik,planner,gl,tere',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('management.users.index')->with('success', 'User created successfully');
    }

    public function edit(User $user)
    {
        if (Auth::user()->role !== 'tere') {
            abort(403, 'Unauthorized');
        }

        return view('dashboard.management.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (Auth::user()->role !== 'tere') {
            abort(403, 'Unauthorized');
        }

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:mekanik,planner,gl,tere',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'string|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('management.users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if (Auth::user()->role !== 'tere') {
            abort(403, 'Unauthorized');
        }

        if ($user->id === Auth::id()) {
            return redirect()->route('management.users.index')->with('error', 'You cannot delete yourself');
        }

        $user->delete();

        return redirect()->route('management.users.index')->with('success', 'User deleted successfully');
    }
}