<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Traits\AccountTrait;
class AccountController extends Controller
{
    public function list(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $accounts = Account::paginate(10);
        return view('users.list', ['accounts' => $accounts]);
    }

    // Show the form to create a new account
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $roles = Role::all();

        return view('users.create', compact('roles'));
    }


    public function store(Request $request)
    {
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

        $roles = Role::whereIn('id', $data['roles'])->get();
        $account->syncRoles($roles);

        return redirect('/accounts')->with('success', 'Account created successfully.');
    }


    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $account = Account::with('user')->find($id);

        if (!$account) {
            abort(404, 'Account not found.');
        }

        return view('users.edit', compact('account'));
    }


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

        $company = Company::find($account->CompanyId);
        $company->update([
            'Name' => $data['CompanyName'],
        ]);

        $account->update([
            'JobTitle' => $data['JobTitle'],
        ]);

        $account->roles()->sync($data['roles']);

        return redirect('/accounts')->with('success', 'Account updated successfully.');
    }

    public function destroy(string $id)
    {
        $account = Account::with(['user', 'company'])->find($id);

        if (!$account) {
            return redirect('/accounts')->with('error', 'Account not found.');
        }

        DB::transaction(function () use ($account) {
            $account->roles()->detach();

            if ($account->user) {
                $account->user->delete();
            }

            if ($account->company) {
                $account->company->delete();
            }

            $account->delete();
        });

        return redirect('/accounts')->with('success', 'Account deleted successfully.');
    }
}
