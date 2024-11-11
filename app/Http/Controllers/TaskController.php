<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index($projectId)
    {
        $project = Project::findOrFail($projectId);
        $tasks = $project->tasks;

        return Inertia::render('Tasks/Index', compact('project', 'tasks'));
    }

    public function store(Request $request, $projectId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id'
        ]);

        $project = Project::findOrFail($projectId);

        $this->authorize('update', $project);

        $project->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => 'pending',
            'assigned_to' => $request->assigned_to,
        ]);

        return redirect()->back()->with('success', 'Task created successfully.');
    }

    public function update(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);

        $this->authorize('update', $task->project);

        $task->update($request->only(['title', 'description', 'due_date', 'status', 'assigned_to']));

        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    public function destroy($taskId)
    {
        $task = Task::findOrFail($taskId);

        $this->authorize('delete', $task->project);

        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully.');
    }
}
