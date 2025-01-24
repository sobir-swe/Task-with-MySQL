@extends('layouts.main')

@section('title', 'Edit Task')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card col-lg-8">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Edit this Task</h5>
                <form class="row g-3" id="task-form" action="{{ route('tasks.update', $task->id) }}" method="POST">
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
                        <!-- Modal trigger button -->
                        <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#confirmationModal">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Vertically Centered</h5>
            <p>Add <code>.modal-dialog-centered</code> to <code>.modal-dialog</code> to vertically center the modal.</p>

            <!-- Vertically centered Modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#verticalycentered">
                Vertically centered
            </button>
            <div class="modal fade" id="verticalycentered" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Vertically Centered</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Non omnis incidunt qui sed occaecati magni asperiores est mollitia. Soluta at et reprehenderit. Placeat autem numquam et fuga numquam. Tempora in facere consequatur sit dolor ipsum. Consequatur nemo amet incidunt est facilis. Dolorem neque recusandae quo sit molestias sint dignissimos.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div><!-- End Vertically centered Modal-->

        </div>
    </div>
@endsection
