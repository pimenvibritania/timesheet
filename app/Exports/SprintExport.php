<?php

namespace App\Exports;

use App\Models\Sprint;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SprintExport implements FromView
{

    public function __construct(
        private int $sprintId
    )
    {

    }

    public function view(): View
    {
        return view('exports.sprints', [
            'sprints' => Sprint::with('report.member')->where('id', $this->sprintId)->first()
        ]);
    }
}
