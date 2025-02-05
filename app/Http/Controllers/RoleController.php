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

	$roles = Role::with('permissions')->get();
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
		$accounts = Account::with(['user', 'company'])->get();  // Eager loading qo'shildi

		return view('roles.create', compact('permissions', 'accounts'));
	}

	public function store(Request $request): \Illuminate\Http\RedirectResponse
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255|unique:roles,name',
			'permissions' => 'nullable|array',
			'permissions.*' => 'exists:permissions,id',
		]);

		$role = Role::create(['name' => $validated['name']]);  // Validated data ishlatildi

		if ($request->has('permissions') && is_array($request->permissions)) {
			$permissions = Permission::whereIn('id', $request->permissions)
				->pluck('id')
				->toArray();

			if (!empty($permissions)) {
				$role->syncPermissions($permissions);
			}
		}

		return redirect()->route('roles.list')->with('success', __('messages.role_created'));
	}

	public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
	{
		$accountId = $this->getAccountId();
		$account = Account::query()->find($accountId);

		if (!$account->hasPermissionTo('update_role')) {
			return view('errors.403', ['message' => 'You do not have permission to update roles! You can ask for permission to get it.']);
		}

		$role = Role::with('permissions')->findOrFail($id);  // Eager loading qo'shildi
		$permissions = Permission::all();
		$accounts = Account::with(['user', 'company', 'roles'])->get();  // Eager loading qo'shildi

		$rolePermissions = $role->permissions->pluck('id')->toArray();  // Relation orqali olish

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
		$role->update(['name' => $validated['name']]);  // Name update qo'shildi

		if ($request->has('permissions')) {
			$permissions = Permission::whereIn('id', $validated['permissions'] ?? [])  // Validated data ishlatildi
			->pluck('id')
				->toArray();
			$role->permissions()->sync($permissions);
		}

		if ($request->has('accounts')) {
			$accounts = Account::whereIn('id', $validated['accounts'] ?? [])->get();  // Bulk operation
			foreach ($accounts as $account) {
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
				->with('error', __('messages.no_permission_delete_role'));
		}

		try {
			$role = Role::findOrFail($id);
			$role->delete();
			return redirect()->route('roles.list')->with('success', __('messages.role_deleted'));
		} catch (\Exception $e) {
			return redirect()->route('roles.list')->with('error', __('messages.role_delete_failed'));
		}
	}
}
