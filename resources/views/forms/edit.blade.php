@extends('base.header')
@section('title', 'Edit File')
@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card col-lg-8">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Edit this file</h5>
                <form class="row g-3" action="{{ route('files.update', $file->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="col-md-12">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $file->name) }}" placeholder="Name" required>
                    </div>

                    <div class="col-12">
                        <div class="form-floating">
                            <textarea class="form-control" id="description" name="description" placeholder="Description" style="height: 100px;" required>{{ old('description', $file->description) }}</textarea>
                            <label for="description">Description</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="file" class="col-sm-3 col-form-label">File Upload</label>
                        <div class="col-12">
                            <input class="form-control" type="file" name="file" id="file">
                        </div>
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
