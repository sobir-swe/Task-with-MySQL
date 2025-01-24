<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class AccountController extends Controller
{
    // List all accounts
    public function list(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $accounts = Account::paginate(10); // Paginate for better performance
        return view('users.list', ['accounts' => $accounts]);
    }

    // Show the form to create a new account
    public function create($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $account = Account::find($id);

        if (!$account) {
            return redirect('/accounts')->with('error', 'Account not found.');
        }

        $roles = Role::all();
        $selectedRoles = $account->roles->pluck('id')->toArray();

        return view('users.create', compact('roles', 'account', 'selectedRoles'));
    }

    // Store a new account
    public function store(Request $request)
    {
        // Inputni tekshirish
        $data = $request->validate([
            'FirstName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'CompanyName' => 'required|string|max:255',
            'JobTitle' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $data['password'] = Hash::make($data['password']);

        $user = User::create([
            'FirstName' => $data['FirstName'],
            'LastName' => $data['LastName'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $company = Company::create([
            'Name' => $data['CompanyName'],
        ]);

        $account = Account::create([
            'UserId' => $user->id,
            'CompanyId' => $company->id,
            'JobTitle' => $data['JobTitle'],
        ]);

        $account->assignRole($data['roles']);

        return redirect('/accounts')->with('success', 'Account created successfully.');
    }

    // Show the form to edit an account
    public function edit(string $id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $account = Account::with(['user', 'company'])->findOrFail($id);
        $roles = Role::all();
        $selectedRoles = $account->roles->pluck('id')->toArray();

        return view('users.edit', compact('roles', 'account', 'selectedRoles'));
    }

    // Update an account
    public function update(Request $request, string $id): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $account = Account::find($id);

        if (!$account) {
            return redirect('/accounts')->with('error', 'Account not found.');
        }

        $data = $request->validate([
            'FirstName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $account->UserId,
            'CompanyName' => 'required|string|max:255',
            'JobTitle' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        // Update user
        $user = User::find($account->UserId);
        $userData = [
            'FirstName' => $data['FirstName'],
            'LastName' => $data['LastName'],
            'email' => $data['email'],
        ];

        if ($data['password']) {
            $userData['password'] = Hash::make($data['password']);
        }

        $user->update($userData);

        // Update company
        $company = Company::find($account->CompanyId);
        $company->update([
            'Name' => $data['CompanyName'],
        ]);

        // Update account
        $account->update([
            'JobTitle' => $data['JobTitle'],
        ]);

        // Assign roles
        $account->roles()->sync($data['roles']);

        return redirect('/accounts')->with('success', 'Account updated successfully.');
    }

    // Delete an account
    public function destroy(string $id): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $account = Account::find($id);

        if (!$account) {
            return redirect('/accounts')->with('error', 'Account not found.');
        }

        DB::transaction(function () use ($account) {
            $account->roles()->detach();
            $account->delete();
            $account->user->delete();
            $account->company->delete();
        });

        return redirect('/accounts')->with('success', 'Account deleted successfully.');
    }
}
