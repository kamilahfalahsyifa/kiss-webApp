<?php

namespace App\Http\Controllers;

use App\Models\AplComponent;
use App\Models\ComponentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AplComponentController extends Controller
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
        return view('apl-components.index', [
            'components' => AplComponent::with('user')->withCount('items')->latest()->get(),
            'permissions' => $this->getPermissions(),
        ]);
    }

    public function create()
    {
        return view('apl-components.create', [
            'permissions' => $this->getPermissions(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        AplComponent::create([
            ...$validated,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('apl-components.index');
    }

    public function show(AplComponent $aplComponent)
    {
        return view('apl-components.show', [
            'component' => $aplComponent->load('items'),
            'permissions' => $this->getPermissions(),
        ]);
    }

    public function edit(AplComponent $aplComponent)
    {
        return view('apl-components.edit', [
            'component' => $aplComponent->load('items'),
            'permissions' => $this->getPermissions(),
        ]);
    }

    public function update(Request $request, AplComponent $aplComponent)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $aplComponent->update($validated);

        return redirect()->route('apl-components.index');
    }

    public function destroy(AplComponent $aplComponent)
    {
        $aplComponent->delete();

        return redirect()->route('apl-components.index');
    }

    public function addItem(Request $request, AplComponent $aplComponent)
    {
        $validated = $request->validate([
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

        $aplComponent->items()->create($validated);

        return redirect()->route('apl-components.edit', $aplComponent);
    }

    public function updateItem(Request $request, AplComponent $aplComponent, ComponentItem $item)
    {
        $validated = $request->validate([
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

        $item->update($validated);

        return redirect()->route('apl-components.edit', $aplComponent);
    }

    public function destroyItem(AplComponent $aplComponent, ComponentItem $item)
    {
        $item->delete();

        return redirect()->route('apl-components.edit', $aplComponent);
    }
}
