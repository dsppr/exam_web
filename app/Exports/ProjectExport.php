<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProjectExport implements FromCollection
{
    protected $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    public function collection()
    {
        return collect([
            ['ID', 'Name', 'Description', 'Deadline'],
            [$this->project->id, $this->project->name, $this->project->description, $this->project->deadline]
        ]);
    }
}
