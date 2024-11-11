<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $user = Auth::user();

        $managedProjects = $user->managedProjects; // Proyek yang dikelola pengguna
        $followedProjects = $user->assignedProjects; // Proyek yang diikuti pengguna

        return Inertia::render('Dashboard', [
            'managedProjects' => $managedProjects,
            'followedProjects' => $followedProjects,
            'user' => Auth::user(), // Mengirimkan data user ke tampilan
        ]);
    }



    public function create()
    {
        return Inertia::render('CreateProject');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
        ]);

        // Buat proyek baru dan tetapkan user sebagai Project Manager
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'created_by' => Auth::id(),
        ]);

        // Tambahkan pengguna ke tabel project_user sebagai Project Manager
        $project->teamMembers()->attach(Auth::id(), ['role' => 'Project Manager']);

        return redirect()->route('dashboard')->with('success', 'Project created successfully');
    }


    // Menampilkan halaman detail proyek
    public function show($projectId)
    {
        $project = Project::with(['tasks', 'teamMembers', 'milestones'])->findOrFail($projectId);
        return Inertia::render('Project/Show', compact('project'));
    }

    // Memperbarui data proyek
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $this->authorize('update', $project); // Pastikan pengguna diizinkan mengedit proyek

        $project->update($request->only(['name', 'description', 'deadline']));

        return redirect()->back()->with('success', 'Project updated successfully.');
    }

    // Menghapus proyek
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $this->authorize('delete', $project); // Hanya pengguna yang diizinkan yang dapat menghapus proyek

        $project->delete();

        return redirect()->route('dashboard')->with('success', 'Project deleted successfully.');
    }

    // Mengundang anggota tim
    public function inviteMember(Request $request, $projectId)
    {
        $request->validate(['user_id' => 'required|exists:users,id']);

        $project = Project::findOrFail($projectId);
        $this->authorize('update', $project); // Hanya Project Manager yang bisa mengundang

        // Tambahkan pengguna ke proyek dengan status "pending"
        $project->invitations()->create([
            'user_id' => $request->user_id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Invitation sent successfully.');
    }
}
