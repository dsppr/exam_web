<?php

namespace Database\Seeders;

use App\Models\User;
use \App\Models\Task;
use \App\Models\Milestone;
use \App\Models\Invitation;
use \App\Models\Project;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Membuat beberapa pengguna
        User::factory(10)->create()->each(function ($user) {
            // Setiap pengguna menjadi Project Manager dari satu proyek
            $project = Project::factory()->create(['created_by' => $user->id]);

            // Menambahkan beberapa tugas dan milestones ke proyek ini
            Task::factory(5)->create(['project_id' => $project->id, 'assigned_to' => $user->id]);
            Milestone::factory(3)->create(['project_id' => $project->id]);

            // Mengundang pengguna lain ke proyek
            User::all()->except($user->id)->each(function ($otherUser) use ($project) {
                Invitation::factory()->create(['project_id' => $project->id, 'user_id' => $otherUser->id]);
            });
        });
    }
}
