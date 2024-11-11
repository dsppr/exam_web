<?php

namespace App\Services;

use App\Models\Project;
use Carbon\Carbon;

class ReportService
{
    /**
     * Mengambil data untuk Gantt chart.
     *
     * @param Project $project
     * @return array
     */
    public function getGanttChartData(Project $project): array
    {
        $ganttData = [];

        // Ambil semua tugas dalam proyek
        foreach ($project->tasks as $task) {
            $ganttData[] = [
                'id' => $task->id,
                'title' => $task->title,
                'start_date' => $task->due_date->subDays(5)->format('Y-m-d'), // contoh: 5 hari sebelum due date sebagai tanggal mulai
                'due_date' => $task->due_date->format('Y-m-d'),
                'status' => $task->status,
                'assigned_to' => $task->assignedUser ? $task->assignedUser->name : null,
            ];
        }

        // Tambahkan milestone dalam proyek ke data Gantt
        foreach ($project->milestones as $milestone) {
            $ganttData[] = [
                'id' => "milestone-{$milestone->id}",
                'title' => $milestone->title,
                'start_date' => $milestone->deadline->format('Y-m-d'),
                'due_date' => $milestone->deadline->format('Y-m-d'),
                'progress' => $milestone->progress,
                'is_milestone' => true,
            ];
        }

        return $ganttData;
    }

    /**
     * Mengambil data untuk Kanban board.
     *
     * @param Project $project
     * @return array
     */
    public function getKanbanBoardData(Project $project): array
    {
        $kanbanData = [
            'to_do' => [],
            'in_progress' => [],
            'completed' => [],
        ];

        // Pisahkan tugas berdasarkan status
        foreach ($project->tasks as $task) {
            $taskData = [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'due_date' => $task->due_date->format('Y-m-d'),
                'assigned_to' => $task->assignedUser ? $task->assignedUser->name : null,
            ];

            switch ($task->status) {
                case 'pending':
                    $kanbanData['to_do'][] = $taskData;
                    break;
                case 'in_progress':
                    $kanbanData['in_progress'][] = $taskData;
                    break;
                case 'completed':
                    $kanbanData['completed'][] = $taskData;
                    break;
            }
        }

        return $kanbanData;
    }
}
