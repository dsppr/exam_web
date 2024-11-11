<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\InvitationNotification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class InvitationController extends Controller
{
    use AuthorizesRequests;

    // Metode untuk mengirim undangan ke user
    public function store(Request $request, $projectId)
    {
        // Validasi input ID user yang akan diundang
        $request->validate(['user_id' => 'required|exists:users,id']);

        // Cari proyek berdasarkan ID proyek yang diberikan
        $project = Project::findOrFail($projectId);

        // Otorisasi: pastikan hanya Project Manager yang bisa mengundang
        $this->authorize('update', $project);

        // Cek apakah user yang diundang sudah menjadi anggota proyek
        if ($project->users()->where('user_id', $request->user_id)->exists()) {
            return redirect()->back()->withErrors('User is already a member of this project.');
        }

        // Dapatkan pengguna yang sedang login sebagai pengirim undangan
        $sender = Auth::user();
        if (!$sender) {
            return redirect()->back()->withErrors('You must be logged in to send an invitation.');
        }

        // Buat undangan baru dengan status 'pending'
        $invitation = Invitation::create([
            'project_id' => $project->id,
            'user_id' => $request->user_id,
            'status' => 'pending',
        ]);

        // Kirim notifikasi undangan ke user yang diundang
        $userToInvite = User::find($request->user_id);
        $userToInvite->notify(new InvitationNotification($project, $sender));

        return redirect()->back()->with('success', 'Invitation sent successfully.');
    }

    // Metode untuk menerima undangan
    public function accept($invitationId)
    {
        $invitation = Invitation::findOrFail($invitationId);
        $this->authorize('update', $invitation->project);

        $invitation->update(['status' => 'accepted']);

        return redirect()->back()->with('success', 'Invitation accepted.');
    }

    // Metode untuk menolak undangan
    public function reject($invitationId)
    {
        $invitation = Invitation::findOrFail($invitationId);
        $this->authorize('update', $invitation->project);

        $invitation->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Invitation rejected.');
    }
}
