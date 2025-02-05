@extends('layouts.main')

@section('title', 'Show Page')

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
				<h5 class="mb-0">List of all tasks</h5>
				<a href="{{ route('tasks.create') }}" class="btn btn-primary">
					<i class="bi bi-plus-lg"></i> Add New Task
				</a>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
						<tr>
							<th>ID</th>
							<th>File Name</th>
							<th>Description</th>
							<th>Path</th>
							<th>Extension</th>
							<th>Size</th>
							<th>Actions</th>
						</tr>
						</thead>
						<tbody>
						@foreach($files as $file)
						<tr>
							<td>{{ $file->id }}</td>
							<td>{{ $file->Name }}</td>
							<td>{{ $file->Description }}</td>
							<td>{{ $file->Path }}</td>
							<td>{{ $file->Extension }}</td>
							<td>{{ $file->Size }}</td>
							<td>
								<div class="d-flex">
									<a href="{{ route('files.edit', $file->id) }}" class="btn btn-primary btn-sm me-2">
										<i class="bi bi-pencil"></i>
									</a>
									<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $file->id }}">
										<i class="bi bi-trash"></i>
									</button>
								</div>

								<div class="modal fade" id="deleteModal{{ $file->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $file->id }}" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="deleteModalLabel{{ $file->id }}">Delete File</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body">
												Are you sure you want to delete this file?
											</div>
											<div class="modal-footer">
												<form action="{{ route('files.destroy', $file->id) }}" method="POST" class="d-inline">
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
			<div class="mt-3 d-flex justify-content-center">
				{{ $files->links('pagination::bootstrap-5') }}
			</div>
		</div>
	</div>
@endsection

@push('styles')
	<style>
		.btn-sm {
			padding: 0.25rem 0.5rem;
			font-size: 0.875rem;
			line-height: 1.25;
		}
	</style>
@endpush
