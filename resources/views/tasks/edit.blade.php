@extends('layouts.main')
@section('title', 'Edit Task')
@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card col-lg-8">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Edit this Task</h5>
                <form class="row g-3" action="{{ route('tasks.update', $task->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="col-md-12">
                        <label for="name">Task Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $task->name) }}" placeholder="Task Name" required>
                    </div>

                    <div class="col-md-12">
                        <label for="deadline">Deadline</label>
                        <input type="datetime-local" class="form-control" id="deadline" name="deadline" value="{{ old('deadline', $task->deadline ? $task->deadline->format('Y-m-d\TH:i') : '') }}" required>
                    </div>

                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-primary me-2">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
