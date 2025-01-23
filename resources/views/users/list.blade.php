@extends('layouts.main')

@section('title', 'All Users')

@section('content')
    <div class="container">
        <h1 class="mt-4">Users</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($accounts as $account)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $account->user->FirstName }}</td>
                    <td>{{ $account->user->LastName }}</td>
                    <td>{{ $account->user->email }}</td>
                    <td>{{ $account->role ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('roles.edit', $account->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('roles.destroy', $account->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
