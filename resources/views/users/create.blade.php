@extends('layouts.main')

@section('title', 'Create User')

@section('content')
    <div class="container">
        <h1 class="mt-4">Create User</h1>

        <form action="{{ route('accounts.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="FirstName" class="form-label">First Name</label>
                <input type="text" name="FirstName" id="FirstName" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="LastName" class="form-label">Last Name</label>
                <input type="text" name="LastName" id="LastName" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="CompanyName" class="form-label">Company Name</label>
                <input type="text" name="CompanyName" id="CompanyName" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="JobTitle" class="form-label">Job Title</label>
                <input type="text" name="JobTitle" id="JobTitle" class="form-control" required>
            </div>

            <div class="mb-4">
                <h3>Roles</h3>
                <div class="row">
                    @foreach($roles as $role)
                        <div class="col-md-2 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}"
                                       id="role-{{ $role->id }}"
                                       @if(in_array($role->id, $selectedRoles)) checked @endif>
                                <label class="form-check-label" for="role-{{ $role->id }}">
                                    {{ $role->name }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Create User</button>
        </form>
    </div>
@endsection
