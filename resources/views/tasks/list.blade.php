@extends('layouts.main')

@section('title', 'Tasks List')

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
					<table class="table table-bordered table-hover">
						<thead class="table-light">
						<tr>
							<th>ID</th>
							<th>Task Name</th>
							<th>Company ID</th>
							<th>Account Id</th>
							<th>Status</th>
							<th>Shared With</th>
							<th>Deadline</th>
							<th>Created At</th>
							<th>Updated At</th>
							<th width="150">Actions</th>
						</tr>
						</thead>
						<tbody>
						@forelse($tasks as $task)
							<tr>
								<td>{{ $task->id }}</td>
								<td>
									<a href="#" data-bs-toggle="modal" data-bs-target="#taskModal{{ $task->id }}" class="text-decoration-none">
										{{ $task->Name }}
									</a>
								</td>
								<td>{{ $task->CompanyId }}</td>
								<td>{{ $task->AccountId }}</td>
								<td>
                                    <span class="badge bg-{{ $task->IsDone ? 'success' : 'warning' }}">
                                        {{ $task->IsDone ? 'Completed' : 'Pending' }}
                                    </span>
								</td>
								<td>
									@if($task->ThoseSent)
										<span class="badge bg-info">{{ $task->ThoseSent }}</span>
									@else
										<span class="text-muted">Not shared</span>
									@endif
								</td>
								<td>
									@if($task->Deadline)
										<span class="@if(\Carbon\Carbon::parse($task->Deadline)->isPast()) text-danger @endif">
                                            {{ \Carbon\Carbon::parse($task->Deadline)->format('Y-m-d') }}
                                        </span>
									@else
										<span class="text-muted">No Deadline</span>
									@endif
								</td>
								<td>{{ $task->created_at->format('Y-m-d H:i') }}</td>
								<td>{{ $task->updated_at->format('Y-m-d H:i') }}</td>
								<td>
									<div class="d-flex">
										<a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-sm me-2">
											<i class="bi bi-eye"></i>
										</a>

										<a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm me-2">
											<i class="bi bi-pencil"></i>
										</a>
										<button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $task->id }}">
											<i class="bi bi-trash"></i>
										</button>
									</div>

									<div class="modal fade" id="deleteModal{{ $task->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $task->id }}" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="deleteModalLabel{{ $task->id }}">Delete Account</h5>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
												</div>
												<div class="modal-body">
													Are you sure you want to delete this task?
												</div>
												<div class="modal-footer">
													<form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
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

							<!-- Task Detail Modal -->
							<div class="modal fade" id="taskModal{{ $task->id }}" tabindex="-1">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">Task Details</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
										</div>
										<div class="modal-body">
											<div class="row">
												<div class="col-md-6">
													<h6>Basic Information</h6>
													<dl class="row">
														<dt class="col-sm-4">Name</dt>
														<dd class="col-sm-8">{{ $task->Name }}</dd>

														<dt class="col-sm-4">Description</dt>
														<dd class="col-sm-8">{{ $task->Description }}</dd>

														<dt class="col-sm-4">Status</dt>
														<dd class="col-sm-8">
                                                            <span class="badge bg-{{ $task->IsDone ? 'success' : 'warning' }}">
                                                                {{ $task->IsDone ? 'Completed' : 'Pending' }}
                                                            </span>
														</dd>
													</dl>
												</div>
												<div class="col-md-6">
													<h6>Files</h6>
													@if($task->files->count() > 0)
														<ul class="list-group">
															@foreach($task->files as $file)
																<li class="list-group-item d-flex justify-content-between align-items-center">
																	{{ $file->name }}
																	<a href="{{ asset('storage/' . $file->path) }}"
																	   class="btn btn-sm btn-primary">
																		<i class="bi bi-download"></i>
																	</a>
																</li>
															@endforeach
														</ul>
													@else
														<p class="text-muted">No files attached</p>
													@endif
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<a href="{{ route('tasks.show', $task->id) }}" class="btn btn-primary">
												Share Task
											</a>
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
										</div>
									</div>
								</div>
							</div>
						@empty
							<tr>
								<td colspan="10" class="text-center py-4">No tasks found</td>
							</tr>
						@endforelse
						</tbody>
					</table>
				</div>

				<div class="mt-3 d-flex justify-content-center">
					{{ $tasks->links('pagination::bootstrap-5') }}
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
