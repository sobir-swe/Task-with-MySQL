@extends('base.header')
@section('title', 'Add Page')
@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-lg-8">
            <h1 class="text-center mb-4">Show Form</h1>
            <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="description" class="col-sm-3 col-form-label">Description</label>
                    <div class="col-sm-9">
                        <textarea  type="text" class="form-control" name="description" id="description"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="file" class="col-sm-3 col-form-label">File Upload</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="file" name="file" id="file">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-9 offset-sm-3">
                        <button type="submit" class="btn btn-primary">Submit Form</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
