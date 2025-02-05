<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Traits\AccountTrait;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
	use AccountTrait;

    public function list(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
	    $accountId = $this->getAccountId();
	    $account = Account::query()->find($accountId);

	    if (!$account->hasPermissionTo('list_permissions')) {
		    return view('errors.403', ['message' => 'You do not have permission to list permissions! You can ask for permission to get it.']);
	    }

        $permissions = Permission::all();
        return view('permissions.list', compact('permissions'));
    }
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
	    $accountId = $this->getAccountId();
	    $account = Account::query()->find($accountId);

	    if (!$account->hasPermissionTo('create_permission')) {
		    return view('errors.403', ['message' => 'You do not have permission to create permissions! You can ask for permission to get it.']);
	    }
        return view('permissions.create');
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
	    $accountId = $this->getAccountId();
	    $account = Account::query()->find($accountId);

	    if (!$account->hasPermissionTo('update_permission')) {
		    return view('errors.403', ['message' => 'You do not have permission to edit permissions! You can ask for permission to get it.']);
	    }

        $permission = Permission::findOrFail($id);
        return view('permissions.create', compact('permission'));
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
	    $accountId = $this->getAccountId();
	    $account = Account::query()->find($accountId);

	    if (!$account->hasPermissionTo('delete_permission')) {
		    return redirect()->route('permissions.list')
			    ->with('error', 'You do not have permission to delete permissions! You can ask for permission to get it.');
	    }

        $permission = Permission::query()->findOrFail($id);
        $permission->delete();
        return redirect()->route('permissions.list')->with('success', 'Permission deleted successfully');
    }
}
