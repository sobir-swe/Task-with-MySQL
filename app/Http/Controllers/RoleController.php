<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function list(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('role-permission.roles.list');
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('role-permission.roles.create');
    }

    public function store(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        Role::create([
            'name' => $request['name'],
        ]);

        return redirect('roles')->with('status', 'Role added successfully!');
    }

    public function edit(string $id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $role = Role::query()->findOrFail($id);
        return view('role-permission.roles.create', compact('role'));
    }

    public function update(Request $request, string $id): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
        ]);

        $role = Role::query()->findOrFail($id);
        $role->update([
            'name' => $request['name'],
        ]);

        return redirect('roles')->with('status', 'Role updated successfully!');
    }

    public function destroy(string $id): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $role = Role::query()->findOrFail($id);
        $role->delete();

        return redirect('roles')->with('status', 'Role deleted successfully!');
    }
}
