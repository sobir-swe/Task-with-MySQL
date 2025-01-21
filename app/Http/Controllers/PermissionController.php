<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function list(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('role-permission.permissions.list');
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('role-permission.permissions.create');
    }

    public function store(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);

        Permission::create([
            'name' => $request['name'],
        ]);

        return redirect('permissions')->with('status', 'Permission added successfully!');
    }

    public function edit(string $id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $permission = Permission::query()->findOrFail($id);
        return view('role-permission.permissions.create', compact('permission'));
    }

    public function update(Request $request, string $id): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $id,
        ]);

        Permission::query()->where('id', $id)->update([
            'name' => $request['name'],
        ]);

        return redirect('permissions')->with('status', 'Permission updated successfully!');
    }

    public function destroy(string $id): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $role = Permission::query()->findOrFail($id);
        $role->delete();

        return redirect('permissions')->with('status', 'Permission not found!');
    }
}
