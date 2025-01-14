<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use function Symfony\Component\String\s;

class TaskController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $tasks = Task::query()->where('AccountId', auth()->id())->paginate(10);
        return view('tasks.show', ['tasks' => $tasks]);
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        return view('tasks.add');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'Description' => 'required|string|max:255',
            'Isdone' => 'nullable|boolean',
            'Deadline' => 'nullable|date_format:Y-m-d H:i',
        ]);

        Task::query()->create([
            'Name' => $request->name,
            'Description' => $request->description,
            'IsDone' => $request->is_done ?? false,
            'Deadline' => $request->deadline,
            'UserId' => auth()->id(),
        ]);

        return redirect()->route('tasks.index');
    }

    public function show($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $task = Task::query()->findOrFail($id);
        return view('tasks.show_single', compact('task'));
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $task = Task::query()->findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'Description' => 'required|string|max:255',
            'IsDone' => 'nullable|boolean',
            'Deadline' => 'nullable|date_format:Y-m-d H:i',
        ]);

        $task = Task::query()->findOrFail($id);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->is_done = $request->is_done ?? false;
        $task->deadline = $request->deadline;

        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy($id): \Illuminate\Http\RedirectResponse
    {
        $task = Task::query()->findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
}
