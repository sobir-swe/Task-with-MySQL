@extends('layouts.main')

@section('title', isset($file) ? 'Edit File' : 'Add Page')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card col-lg-8">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">{{ isset($file) ? 'Edit this file' : 'Add New File' }}</h5>
                <form class="row g-3" action="{{ isset($file) ? route('files.update', $file->id) : route('files.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($file))
                        @method('PUT')
                    @endif

                    <div class="col-md-12">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ old('name', isset($file) ? $file->name : '') }}" placeholder="Name" required>
                    </div>

                    <div class="col-12">
                        <div class="form-floating">
                            <textarea class="form-control" id="description" name="description" placeholder="Description"
                                      style="height: 100px;" required>{{ old('description', isset($file) ? $file->description : '') }}</textarea>
                            <label for="description">Description</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="file" class="form-label">File Upload</label>
                        <input class="form-control" type="file" name="file" id="file">
                    </div>

                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-primary me-2">{{ isset($file) ? 'Update' : 'Submit' }}</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
