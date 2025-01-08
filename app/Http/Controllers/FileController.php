<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $files = File::all();
        return view('forms.show', ['files' => $files]);
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('forms.add');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:10240',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $file = $request->file('file');
        $fileData = $this->saveFileStorage($file, $request);

        File::query()->create([
            'name' => $request->name,
            'description' => $request->description,
            'path' => $fileData['path'],
            'extension' => $fileData['extension'],
            'size' => $fileData['size'],
            'user_id' => auth()->id(),
        ]);

        return redirect('dashboard');
    }

    public function show($id): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $file = File::query()->findOrFail($id);
        return response()->file(storage_path("app/public/{$file->path}"));
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $file = File::query()->findOrFail($id);
        $fileNames = File::all();

        return view('forms.edit', compact('file', 'fileNames'));
    }


    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048'
        ]);

        $file = File::query()->findOrFail($id);
        $file->name = $request->name;
        $file->description = $request->description;

        if ($request->hasFile('file')) {
            Storage::delete($file->path);

            $path = $request->file('file')->store('uploads');
            $file->path = $path;
            $file->extension = $request->file('file')->getClientOriginalExtension();
            $file->size = $request->file('file')->getSize();
        }

        $file->save();

        return redirect()->route('dashboard')->with('success', 'File updated successfully.');
    }


    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $file = File::query()->findOrFail($id);
        Storage::delete($file->path);
        $file->delete();

        return redirect()->route('files.index');
    }

    public function saveFileStorage($file): array
    {
        $path = $file->store('files', 'public');

        return [
            'path' => $path,
            'extension' => $file->extension(),
            'size' => $file->getSize(),
        ];
    }
}
