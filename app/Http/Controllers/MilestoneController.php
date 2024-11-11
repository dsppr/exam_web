<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MilestoneController extends Controller
{
    use AuthorizesRequests;

    public function index($projectId)
    {
        $project = Project::findOrFail($projectId);
        $milestones = $project->milestones;

        return Inertia::render('Milestones/Index', compact('project', 'milestones'));
    }

    public function store(Request $request, $projectId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'deadline' => 'required|date',
            'progress' => 'integer|min:0|max:100',
        ]);

        $project = Project::findOrFail($projectId);

        $this->authorize('update', $project);

        $project->milestones()->create($request->only(['title', 'deadline', 'progress']));

        return redirect()->back()->with('success', 'Milestone created successfully.');
    }

    public function update(Request $request, $milestoneId)
    {
        $milestone = Milestone::findOrFail($milestoneId);

        $this->authorize('update', $milestone->project);

        $milestone->update($request->only(['title', 'deadline', 'progress']));

        return redirect()->back()->with('success', 'Milestone updated successfully.');
    }

    public function destroy($milestoneId)
    {
        $milestone = Milestone::findOrFail($milestoneId);

        $this->authorize('delete', $milestone->project);

        $milestone->delete();

        return redirect()->back()->with('success', 'Milestone deleted successfully.');
    }
}
