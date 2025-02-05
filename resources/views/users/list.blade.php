@extends('layouts.main')

@section('title', 'User List')

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
				<a href="{{ route('accounts.create') }}" class="btn btn-primary">
					<i class="bi bi-plus-lg"></i> Add New Account
				</a>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<thead class="table-light">
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
						@forelse($accounts as $account)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $account->user->FirstName }}</td>
								<td>{{ $account->user->LastName }}</td>
								<td>{{ $account->user->email }}</td>
								<td>{{ $account->roles->pluck('name')->implode(', ') }}</td>
								<td>
									<div class="d-flex">
										<a href="{{ route('accounts.edit', $account->Id) }}" class="btn btn-primary btn-sm me-2">
											<i class="bi bi-pencil"></i>
										</a>
										<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $account->Id }}">
											<i class="bi bi-trash"></i>
										</button>
									</div>

									<div class="modal fade" id="deleteModal{{ $account->Id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $account->Id }}" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="deleteModalLabel{{ $account->Id }}">Delete Account</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body">
													Are you sure you want to delete this account?
												</div>
												<div class="modal-footer">
													<form action="{{ route('accounts.destroy', $account->Id) }}" method="POST" class="d-inline">
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
						@empty
							<tr>
								<td colspan="6" class="text-center py-4">No accounts found</td>
							</tr>
						@endforelse
						</tbody>
					</table>
				</div>

				<div class="mt-3 d-flex justify-content-center">
					{{ $accounts->links('pagination::bootstrap-5') }}
				</div>
			</div>
		</div>
	</div>
@endsection

@push('styles')
	<style>
		.btn-group {
			gap: 2px;
		}
		.table td {
			vertical-align: middle;
		}
	</style>
@endpush
