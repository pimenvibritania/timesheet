<?php

namespace App\Http\Controllers;

use App\Exports\SprintExport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class SprintController extends VoyagerBaseController
{
    public function export($id): BinaryFileResponse
    {
        return Excel::download(new SprintExport($id), "sprint_${id}.xlsx");
    }
}
