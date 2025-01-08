@extends('base.header')

@section('title', 'Show Page')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">List of all files</h5>
                <p>List of all downloaded files</p>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm mb-3">
                    <i class="bx bx-home"></i> Dashboard
                </a>

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
                        @if($file->user_id == auth()->id())
                        <tr>
                            <td>{{ $file->id }}</td>
                            <td>{{ $file->name }}</td>
                            <td>{{ $file->description }}</td>
                            <td>{{ $file->path }}</td>
                            <td>{{ $file->extension }}</td>
                            <td>{{ $file->size }}</td>
                            <td class="actions">
                                <a href="{{ route('files.edit', $file->id) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>

                                <form action="{{ route('files.destroy', $file->id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this file?');">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
