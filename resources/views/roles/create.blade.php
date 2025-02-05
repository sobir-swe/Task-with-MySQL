@extends('layouts.main')

@section('title', 'Create Role')

@section('content')
    <div class="container">
        <h1 class="mt-4">Create Role</h1>

        {{-- Validatsiya xatolarini ko'rsatish --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            {{-- Role nomi --}}
            <div class="mb-3">
                <label for="name" class="form-label">Role Name</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ old('name') }}" placeholder="Enter role name" required>
            </div>

            {{-- Permissions va Users listi yonma-yon --}}
            <div class="row mb-4">
                {{-- Permissions listi --}}
                <div class="col-md-6">
                    <h3>Assign Permissions</h3>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Select</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Guard Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($permissions as $permission)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input custom-checkbox" type="checkbox"
                                               name="permissions[]"
                                               value="{{ $permission->id }}">
                                    </div>
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->guard_name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Users listi --}}
                <div class="col-md-6">
                    <h3>Assign Users</h3>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Select</th>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Company Name</th>
                            <th>Job Title</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($accounts as $account)
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input custom-checkbox" type="checkbox"
                                               name="accounts[]"
                                               value="{{ $account->Id }}">
                                    </div>
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $account->user->FirstName }}</td>
                                <td>{{ $account->user->LastName }}</td>
                                <td>{{ $account->user->email }}</td>
                                <td>{{ $account->company->Name ?? 'N/A' }}</td>
                                <td>{{ $account->JobTitle }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>

    {{-- Custom CSS --}}
    <style>
        .custom-checkbox {
            transform: scale(1.5); /
        }
    </style>
@endsection
