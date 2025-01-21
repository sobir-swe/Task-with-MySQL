@extends('layouts.main')

@section('title', isset($permission) ? 'Edit Permission' : 'Create Permission')

@section('content')
    <div class="container">
        <h1 class="mt-4">{{ isset($permission) ? 'Edit Permission' : 'Create Permission' }}</h1>
        <form action="{{ isset($permission) ? route('permissions.update', $permission->id) : route('permissions.store') }}" method="POST">
            @csrf
            @if(isset($permission))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Permission Name</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ old('name', isset($permission) ? $permission->name : '') }}"
                       placeholder="Enter permission name" required>
            </div>

            <div class="mb-3">
                <label for="guard_name" class="form-label">Guard Name</label>
                <input type="text" class="form-control" id="guard_name" name="guard_name"
                       value="{{ old('guard_name', isset($permission) ? $permission->guard_name : '') }}"
                       placeholder="Enter guard name" required>
            </div>

            <button type="submit" class="btn btn-primary">{{ isset($permission) ? 'Update' : 'Submit' }}</button>
        </form>
    </div>
@endsection
