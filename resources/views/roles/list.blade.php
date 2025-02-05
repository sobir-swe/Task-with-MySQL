@extends('layouts.main')

@section('title', 'Manage Roles')

@section('content')
    <<div class="container mt-4">
	    @if(session('success'))
		    <div class="alert alert-success alert-dismissible fade show">
			    {{ session('success') }}
			    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
		    </div>
	    @endif

	    <div class="card">
		    <div class="card-header d-flex justify-content-between align-items-center">
			    <h5 class="mb-0">List of all roles</h5>
			    <a href="{{ route('roles.create') }}" class="btn btn-primary">
				    <i class="bi bi-plus-lg"></i> Add New Role
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
	            @foreach($roles as $role)
	                <tr>
	                    <td>{{ $loop->iteration }}</td>
	                    <td>{{ $role->name }}</td>
	                    <td>{{ $role->guard_name }}</td>
		                <td>
			                <div class="d-flex">
				                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm me-2">
					                <i class="bi bi-pencil"></i>
				                </a>
				                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $role->id }}">
					                <i class="bi bi-trash"></i>
				                </button>
			                </div>

			                <div class="modal fade" id="deleteModal{{ $role->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $role->id }}" aria-hidden="true">
				                <div class="modal-dialog">
					                <div class="modal-content">
						                <div class="modal-header">
							                <h5 class="modal-title" id="deleteModalLabel{{ $role->id }}">Delete Role</h5>
							                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						                </div>
						                <div class="modal-body">
							                Are you sure you want to delete this role?
						                </div>
						                <div class="modal-footer">
							                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
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
    </div>
@endsection
