@extends('layouts.main')

@section('title', 'Show Page')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">List of all tasks</h5>
                <p>List of all tasks with their details</p>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Task Name</th>
                            <th>Company ID</th>
                            <th>Account Id</th>
                            <th>Is Done</th>
                            <th>Deadline</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->Name }}</td>
                                <td>{{ $task->CompanyId}}</td>
                                <td>{{ $task->AccountId}}</td>
                                <td>{{ $task->IsDone ? 'Yes' : 'No' }}</td>
                                <td>{{ $task->Deadline ? \Carbon\Carbon::parse($task->Deadline)->format('Y-m-d') : 'No Deadline' }}</td>
                                <td>{{ $task->created_at->format('Y-m-d H:i') }}</td>
                                <td>{{ $task->updated_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?');">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
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
