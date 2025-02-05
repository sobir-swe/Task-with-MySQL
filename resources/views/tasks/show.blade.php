@extends('layouts.main')

@section('title', 'Task Details')

@section('content')
	<div class="container mt-4">
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">{{ $task->Name }}</h5>
				<p><strong>Company Name:</strong> {{ $task->account->company->Name }}</p>
				<p><strong>Account Name:</strong> {{ $task->account->user->FirstName }}</p>
				<p><strong>Is Done:</strong> {{ $task->IsDone ? 'Yes' : 'No' }}</p>
				<p><strong>Deadline:</strong> {{ $task->Deadline ? \Carbon\Carbon::parse($task->Deadline)->format('Y-m-d') : 'No Deadline' }}</p>

				<form action="{{ route('tasks.assign', $task->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="mb-3">
						<label for="files" class="form-label">Select Files</label>
						<input type="file" name="files[]" class="form-control" multiple>
					</div>

					<div class="mb-3">
						<label for="accounts" class="form-label">Assign to Users</label>
						<div class="form-check">
							@foreach($accounts as $account)
								<div class="col-md-2 mb-2">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="accounts[]" value="{{ $account->Id }}"
										       id="account-{{ $account->Id }}"
										       @if(in_array($account->Id, $task->sentAccounts->pluck('Id')->toArray())) checked @endif>
										<label class="form-check-label" for="account-{{ $account->Id }}">
											{{ $account->user->FirstName }} {{ $account->user->LastName }}
										</label>
									</div>
								</div>
							@endforeach
						</div>
					</div>

					<button type="submit" class="btn btn-primary">Assign Task</button>
				</form>

				<a href="{{ route('tasks.list') }}" class="btn btn-secondary btn-sm mt-3">Back to List</a>
			</div>
		</div>
	</div>
@endsection
