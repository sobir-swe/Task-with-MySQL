@extends('layouts.main')

@section('title', 'Manage Permissions')

@section('content')
	<div class="container mt-4">
		@if(session('success'))
			<div class="alert alert-success alert-dismissible fade show">
				{{ session('success') }}
				<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
			</div>
		@endif

		<div class="card">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h5 class="mb-0">List of all permissions</h5>
				<a href="{{ route('permissions.create') }}" class="btn btn-primary">
					<i class="bi bi-plus-lg"></i> Add New Permission
				</a>
			</div>
			<div class="card-body">
		    <table class="table table-bordered">
		        <thead>
		        <tr>
		            <th>ID</th>
		            <th>Name</th>
		            <th>Guard Name</th>
		            <th>Actions</th>
		        </tr>
		        </thead>
		        <tbody>
		        @foreach($permissions as $permission)
		            <tr>
		                <td>{{ $loop->iteration }}</td>
		                <td>{{ $permission->name }}</td>
		                <td>{{ $permission->guard_name }}</td>
		                <td>
			                <div class="d-flex">
				                <a href="{{ route('permissions.edit', $permission->id) }}" class="btn btn-primary btn-sm me-2">
					                <i class="bi bi-pencil"></i>
				                </a>
				                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $permission->id }}">
					                <i class="bi bi-trash"></i>
				                </button>
			                </div>

			                <div class="modal fade" id="deleteModal{{ $permission->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $permission->id }}" aria-hidden="true">
				                <div class="modal-dialog">
					                <div class="modal-content">
						                <div class="modal-header">
							                <h5 class="modal-title" id="deleteModalLabel{{ $permission->id }}">Delete File</h5>
							                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						                </div>
						                <div class="modal-body">
							                Are you sure you want to delete this permission?
						                </div>
						                <div class="modal-footer">
							                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="d-inline">
								                @csrf
								                @method('DELETE')
								                <button type="submit" class="btn btn-danger">Yes, delete it</button>
							                </form>
							                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, keep it</button>
						                </div>
					                </div>
				                </div>
			                </div>
		                </td>
		            </tr>
		        @endforeach
		        </tbody>
	        </table>
	    </div>
    </div>
@endsection
