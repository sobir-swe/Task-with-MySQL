<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Task;
use App\Traits\AccountTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
	use AccountTrait;

	public function list()
	{
		$tasks = Task::query()
			->where('AccountId', $this->getAccountId())
			->paginate(10);

		foreach($tasks as $task) {
			$task->ThoseSent = $task->sentAccounts()
				->pluck('AccountId')
				->implode(', ');
		}

		return view('tasks.list', ['tasks' => $tasks]);
	}

	public function create()
	{
		return view('tasks.add');
	}

	public function store(Request $request)
	{
		$request->validate([
			'Name' => 'required|string|max:255',
			'Description' => 'required|string|max:255',
			'IsDone' => 'nullable|boolean',
			'Deadline' => 'nullable|date_format:Y-m-d H:i',
			'files' => 'nullable|array',
			'files.*' => 'file|mimes:jpeg,png,pdf,docx,txt|max:10240',
		]);

		$task = Task::create([
			'Name' => $request->Name,
			'Description' => $request->Description,
			'IsDone' => $request->IsDone ?? false,
			'Deadline' => $request->Deadline,
			'AccountId' => $this->getAccountId(),
			'UserId' => auth()->id(),
			'CompanyId' => auth()->user()->company_id,
		]);

		if ($request->hasFile('files')) {
			foreach ($request->file('files') as $file) {
				$path = $file->store('tasks', 'public');
				$fileModel = $task->files()->create([
					'path' => $path,
					'name' => $file->getClientOriginalName(),
				]);
			}
		}

		return redirect()->route('tasks.show', $task->id);
	}

	public function show($id)
	{
		$task = Task::findOrFail($id);
		$accounts = Account::where('id', '!=', $this->getAccountId())->get();
		return view('tasks.show', compact('task', 'accounts'));
	}

	public function assign(Request $request, $id): \Illuminate\Http\RedirectResponse
	{
		$request->validate([
			'accounts' => 'required|array',
			'accounts.*' => 'exists:accounts,Id',
			'files' => 'nullable|array',
			'files.*' => 'file|mimes:jpeg,png,pdf,docx,txt|max:10240',
		]);

		$task = Task::findOrFail($id);

		$task->sentAccounts()->sync($request->accounts);

		if ($request->hasFile('files')) {
			foreach ($request->file('files') as $file) {
				$path = $file->store('tasks', 'public');
				$task->files()->create([
					'path' => $path,
					'name' => $file->getClientOriginalName(),
				]);
			}
		}

		return redirect()->route('tasks.list')
			->with('success', 'Task assigned successfully');
	}


	public function edit($id)
	{
		$task = Task::query()->findOrFail($id);
		return view('tasks.edit', compact('task'));
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'Name' => 'required|string|max:255',
			'Description' => 'required|string|max:255',
			'IsDone' => 'nullable|boolean',
			'Deadline' => 'nullable|date_format:Y-m-d H:i',
		]);

		$task = Task::query()->findOrFail($id);
		$task->name = $request->Name;
		$task->description = $request->Description;
		$task->is_done = $request->IsDone ?? false;
		$task->deadline = $request->Deadline;

		$task->save();

		return redirect()->route('tasks.list')->with('success', 'Task updated successfully.');
	}

	public function destroy($taskId)
	{
		$task = Task::findOrFail($taskId);
		$task->delete();

		return redirect()->route('tasks.list')->with('success', 'Task deleted successfully!');
	}
}
