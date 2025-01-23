@extends('layouts.main')

@php
    $isUpdate = !empty($permission);
@endphp

@section('title', $isUpdate ? 'Edit Permission' : 'Create Permission')

@section('content')
    <div class="container">
        <h1 class="mt-4">{{ $isUpdate ? 'Edit Permission' : 'Create Permission' }}</h1>
        <form action="{{ $isUpdate ? route('permissions.update', $permission->id) : route('permissions.store') }}" method="POST">
            @csrf
            @if($isUpdate)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="name" class="form-label">Permission Name</label>
                <input type="text" class="form-control" id="name" name="name"
                       value="{{ old('name', $isUpdate ? $permission->name : '') }}"
                       placeholder="Enter permission name" required>
            </div>

            <button type="submit" class="btn btn-primary">{{ $isUpdate ? 'Update' : 'Submit' }}</button>
        </form>

    </div>
@endsection
