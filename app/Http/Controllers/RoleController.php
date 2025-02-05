<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Traits\AccountTrait;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;


class RoleController extends Controller
{
	use AccountTrait;

    public function list(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
	    if (!$this->getAccount()->hasPermissionTo('list_roles')) {
		    return view('errors.403', ['message' => 'You do not have permission to list roles! You can ask for permission to get it.']);
		}

        $roles = Role::all();
        return view('roles.list', compact('roles'));

    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
	    $accountId = $this->getAccountId();
	    $account = Account::query()->find($accountId);

	    if (!$account->hasPermissionTo('create_role')) {
		    return view('errors.403', ['message' => 'You do not have permission to create roles! You can ask for permission to get it.']);
		}

        $permissions = Permission::all();
        $accounts = Account::with('user', 'company')->get();

        return view('roles.create', compact('permissions', 'accounts'));
    }



    public function store(Request $request): \Illuminate\Http\RedirectResponse
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

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
	    $accountId = $this->getAccountId();
	    $account = Account::query()->find($accountId);

	    if (!$account->hasPermissionTo('update_role')) {
		    return view('errors.403', ['message' => 'You do not have permission to update roles! You can ask for permission to get it.']);
	    }

        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $accounts = Account::with('user', 'company', 'roles')->get();

        $rolePermissions = $role->permissions()->pluck('id')->toArray();

        $roleAccounts = Account::whereHas('roles', function($query) use ($role) {
            $query->where('id', $role->id);
        })->pluck('id')->toArray();

        return view('roles.edit', compact(
            'role',
            'permissions',
            'accounts',
            'rolePermissions',
            'roleAccounts'
        ));
    }

	public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255|unique:roles,name,' . $id,
			'permissions' => 'nullable|array',
			'permissions.*' => 'exists:permissions,id',
			'accounts' => 'nullable|array',
			'accounts.*' => 'exists:accounts,id',
		]);

		$role = Role::findOrFail($id);

		if ($request->has('permissions')) {
			$permissions = Permission::whereIn('id', $request->permissions)->pluck('id')->toArray();
			$role->permissions()->sync($permissions);
		}

		if ($request->has('accounts')) {
			foreach ($request->accounts as $accountId) {
				$account = Account::findOrFail($accountId);
				$account->roles()->syncWithoutDetaching([$role->id]);
			}
		}

		return redirect()->route('roles.list')->with('success', __('messages.role_updated'));
	}

	public function destroy($id): \Illuminate\Http\RedirectResponse
	{
		$accountId = $this->getAccountId();
		$account = Account::query()->find($accountId);

		if (!$account->hasPermissionTo('delete_role')) {
			return redirect()->route('roles.list')
				->with('error', 'You do not have permission to delete roles! You can ask for permission to get it.');
		}

		$role = Role::findOrFail($id);
		$role->delete();

		return redirect()->route('roles.list')->with('success', __('messages.role_deleted'));
	}
}
