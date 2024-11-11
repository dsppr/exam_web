<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Exports\ProjectExport;
use App\Services\ReportService;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }


    public function generatePDF($projectId)
    {
        $project = Project::findOrFail($projectId);

        $pdf = Pdf::loadView('reports.project', compact('project'));

        return $pdf->download("project_{$project->id}_report.pdf");
    }

    public function generateExcel($projectId)
    {
        $project = Project::findOrFail($projectId);

        return Excel::download(new ProjectExport($project), "project_{$project->id}_report.xlsx");
    }

    public function showCharts($projectId)
    {
        $project = Project::with('tasks', 'milestones')->findOrFail($projectId);

        // Mendapatkan data untuk Gantt chart dan Kanban board
        $ganttData = $this->reportService->getGanttChartData($project);
        $kanbanData = $this->reportService->getKanbanBoardData($project);

        return Inertia::render('Reports/Charts', [
            'project' => $project,
            'ganttData' => $ganttData,
            'kanbanData' => $kanbanData,
        ]);
    }
}
