<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function list()
    {
        $permissions = Permission::all();
        return view('role-permission.permissions.list', compact('permissions'));
    }
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('role-permission.permissions.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create($validated);

        return redirect()->route('permissions.list')
        ->with('success', 'Permission created successfully');
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $permission = Permission::findOrFail($id);
        return view('role-permission.permissions.create', compact('permission'));
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $permission = Permission::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
            'guard_name' => 'web'
        ]);

        $permission->update($validated);

        return redirect()->route('permissions.list')
        ->with('success', 'Permission updated successfully');
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $permission = Permission::query()->findOrFail($id);
        $permission->delete();
        return redirect()->route('permissions.list')->with('success', 'Permission deleted successfully');
    }
}
