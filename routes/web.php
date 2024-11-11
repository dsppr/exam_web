<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ReportController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Rute dashboard yang mengambil data dari ProjectController@index
Route::get('/dashboard', [ProjectController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Rute untuk Manajemen Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk Proyek
    Route::resource('projects', ProjectController::class)->except(['index', 'edit']);
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');

    // Rute untuk Tugas di dalam Proyek
    Route::prefix('projects/{projectId}')->group(function () {
        Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });

    // Rute untuk Milestone di dalam Proyek
    Route::prefix('projects/{projectId}')->group(function () {
        Route::get('milestones', [MilestoneController::class, 'index'])->name('milestones.index');
        Route::post('milestones', [MilestoneController::class, 'store'])->name('milestones.store');
        Route::patch('milestones/{milestone}', [MilestoneController::class, 'update'])->name('milestones.update');
        Route::delete('milestones/{milestone}', [MilestoneController::class, 'destroy'])->name('milestones.destroy');
    });

    // Rute untuk Notifikasi
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

    // Rute untuk Undangan
    Route::post('projects/{projectId}/invite', [InvitationController::class, 'store'])->name('invitations.store');
    Route::post('invitations/{invitationId}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('invitations/{invitationId}/reject', [InvitationController::class, 'reject'])->name('invitations.reject');

    // Rute untuk Laporan (Ekspor PDF dan Excel)
    Route::get('projects/{projectId}/report/pdf', [ReportController::class, 'generatePDF'])->name('report.pdf');
    Route::get('projects/{projectId}/report/excel', [ReportController::class, 'generateExcel'])->name('report.excel');
    Route::get('projects/{projectId}/report/charts', [ReportController::class, 'showCharts'])->name('report.charts');
});

// Rute untuk autentikasi, termasuk logout dengan metode POST menggunakan "as" button
require __DIR__ . '/auth.php';
