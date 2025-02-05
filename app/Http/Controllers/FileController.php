<?php

namespace App\Http\Controllers;

use App\Events\FileUploaded;
use App\Models\File;
use App\Service\SessionAccount;
use App\Traits\AccountTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    use AccountTrait;

    public function list(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
	    $accountId = $this->getAccount()->UserId;
		$files = File::where('UserId', $accountId)->paginate(10);
		return view('files.list', ['files' => $files]);

    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('files.add');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:10240',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $file = $request->file('file');
        $fileData = $this->saveFileStorage($file);

        File::query()->create([
            'Name' => $request->name,
            'Description' => $request->description,
            'Path' => $fileData['Path'],
            'Extension' => $fileData['Extension'],
            'Size' => $fileData['Size'],
            'UserId' => auth()->id(),
        ]);

//        dd($fileData);
//        event(new FileUploaded($fileData['Name']));

//        SessionAccount::SendLog($fileData['Name']);

        return redirect()->route('files.list');
    }


//    public function show($id): \Symfony\Component\HttpFoundation\BinaryFileResponse
//    {
//        $file = File::query()->findOrFail($id);
//        return response()->file(storage_path("app/public/{$file->path}"));
//    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $file = File::query()->findOrFail($id);
        $fileNames = File::all();

        return view('files.edit', compact('file', 'fileNames'));
    }


    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'Description' => 'required|string|max:255',
            'File' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx|max:2048'
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

        return redirect()->route('files.list');
    }

    public function saveFileStorage($file): array
    {
        $path = $file->store('files', 'public');

        return [
            'Name' => $file->getClientOriginalName(),
            'Path' => $path,
            'Extension' => $file->extension(),
            'Size' => $file->getSize(),
        ];
    }

    public function uploadFile(Request $request)
    {
        $fileName = $request->file('file')->store('uploads');
        $user = auth()->user();

        event(new FileUploaded($fileName, $user));

        return back()->with('success', 'File uploaded successfully!');
    }
}
