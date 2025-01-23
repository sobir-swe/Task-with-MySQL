@extends('layouts.main')

@section('title', 'Create Role')

@section('content')
    <div class="container">
        <h1 class="mt-4">Create Role</h1>

        {{-- Validation Errors --}}
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

            {{-- Role Name --}}
            <div class="mb-3">
                <label for="name" class="form-label">Role Name</label>
                <input type="text" class="form-control" id="name" name="name"
                       placeholder="Enter role name" required style="width: 300px;">
            </div>



            {{-- Permissions --}}
            <div class="mb-4">
                <h3>Assign Permissions</h3>
                @foreach($permissions as $permission)
                    <div class="form-check">
                        <input class="form-check-input custom-checkbox" type="checkbox"
                               name="permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}">
                        <label class="form-check-label" for="permission-{{ $permission->id }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                @endforeach
            </div>

            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    {{-- Custom CSS --}}
    <style>
        .custom-checkbox {
            transform: scale(1.5);
            margin-right: 10px;
        }
    </style>
@endsection
