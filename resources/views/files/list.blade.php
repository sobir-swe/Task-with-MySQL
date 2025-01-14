@extends('layouts.main')

@section('title', 'Show Page')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">List of all files</h5>
                <p>List of all downloaded files</p>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>File Name</th>
                            <th>Description</th>
                            <th>Path</th>
                            <th>Extension</th>
                            <th>Size</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($files as $file)
                            <tr>
                                <td>{{ $file->id }}</td>
                                <td>{{ $file->Name }}</td>
                                <td>{{ $file->Description }}</td>
                                <td>{{ $file->Path }}</td>
                                <td>{{ $file->Extension }}</td>
                                <td>{{ $file->Size }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('files.edit', $file->id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('files.destroy', $file->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this file?');">
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
                    {{ $files->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
