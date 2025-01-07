<div class="card">
    <div class="card-body">
        <h5 class="card-title">List of all files</h5>
        <p>List of all downloaded files</p>
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
                    <td>{{ $file->name }}</td>
                    <td>{{ $file->description }}</td>
                    <td>{{ $file->path }}</td>
                    <td>{{ $file->extension }}</td>
                    <td>{{ $file->size }}</td>
                    <td class="actions">
                        <a href="{{ route('files.edit', $file->id) }}">Edit</a>
                        <form action="{{ route('files.destroy', $file->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
