<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function list()
    {
        $roles = Role::all();
        return view('role-permission.roles.list', compact('roles'));
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $permissions = Permission::all();

        return view('role-permission.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $request->name]);
        $permissions = Permission::whereIn('id', $request->permissions)->pluck('id')->toArray();

        $role->syncPermissions($permissions);
        return redirect()->route('roles.list')->with('success', 'Role created successfully!');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        $accounts = Account::with('user', 'company', 'roles')->get();

        $rolePermissions = $role->permissions()->pluck('id')->toArray();
        $roleUsers = $role->accounts()->pluck('id')->toArray();

        return view('role-permission.roles.edit', compact(
            'role',
            'permissions',
            'accounts',
            'rolePermissions',
            'roleUsers'
        ));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
            'accounts' => 'nullable|array',
            'accounts.*' => 'exists:accounts,id',
        ]);

        $role->update(['name' => $validated['name']]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        if ($request->has('accounts')) {
            foreach ($request->accounts as $accountId) {
                $account = Account::find($accountId);
                if ($account && $account->user) {
                    $account->user->syncRoles($role->name);
                }
            }
        }

        return redirect()->route('roles.list')->with('success', __('messages.role_updated'));
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.list')->with('success', __('messages.role_deleted'));
    }


}
