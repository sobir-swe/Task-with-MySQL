@extends('layouts.main')

@section('title', isset($role) ? 'Edit Role' : 'Create Role')

@section('content')
    <div class="container">
        <h1 class="mt-4">{{ isset($role) ? 'Edit Role' : 'Create Role' }}</h1>
        <form action="{{ isset($role) ? route('roles.update', $role->id) : route('roles.store') }}" method="POST">
            @csrf
            @if(isset($role))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Role Name</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ old('name', isset($role) ? $role->name : '') }}"
                       placeholder="Enter role name" required>
            </div>

            <button type="submit" class="btn btn-primary">{{ isset($role) ? 'Update' : 'Submit' }}</button>
        </form>
    </div>
@endsection
