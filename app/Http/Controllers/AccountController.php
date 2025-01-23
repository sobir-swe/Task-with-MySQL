<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function list(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $accounts = Account::all();
        return view('users.list', ['accounts' => $accounts]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'FirstName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'email' => 'required|email|unique:accounts,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string|max:255',
        ]);

        $data['password'] = Hash::make($data['password']);

        $account = Account::create($data);

        $account->syncRoles($data['role']);

        return redirect('/accounts')->with('success', 'Account created successfully.');
    }

    public function show(string $id)
    {
        $account = Account::findOrFail($id);
        return view('users.show', ['account' => $account]);
    }

    public function edit(string $id)
    {
        $account = Account::findOrFail($id);
        return view('users.edit', ['account' => $account]);
    }

    public function update(Request $request, string $id)
    {
        $account = Account::findOrFail($id);

        $data = $request->validate([
            'FirstName' => 'required|string|max:255',
            'LastName' => 'required|string|max:255',
            'email' => "required|email|unique:accounts,email,{$id}",
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|max:255',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $account->update($data);

        $account->syncRoles($data['role']);

        return redirect('/accounts')->with('success', 'Account updated successfully.');
    }

    public function destroy(string $id)
    {
        $account = Account::find($id);

        $account->delete();

        return redirect('/accounts')->with('success', 'Account deleted successfully.');
    }
}
