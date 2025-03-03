@extends('layouts.main')

@section('title', 'Add Task')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-lg-8">
            <h1 class="text-center mb-4">Add New Task</h1>
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <label for="task_name" class="col-sm-3 col-form-label">Task Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="task_name" id="task_name" value="{{ old('task_name') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="assigned_to" class="col-sm-3 col-form-label">Assigned To</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="assigned_to" id="assigned_to" placeholder="Enter user's name (e.g., Sobirjon Qurbonov)" value="{{ old('assigned_to') }}" required>
                        <small class="text-muted">Type the full name of the user. The system will find the user ID automatically.</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="deadline" class="col-sm-3 col-form-label">Deadline</label>
                    <div class="col-sm-9">
                        <input type="datetime-local" class="form-control" name="deadline" id="deadline" value="{{ old('deadline') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">
                            Submit Task
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">Confirm Task Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to submit this task?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

@endsection
