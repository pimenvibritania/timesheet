<?php

namespace App\Http\Controllers;

use App\Exports\SprintExport;
use App\Models\Sprint;
use DateInterval;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class SprintController extends VoyagerBaseController
{
    /**
     * @throws Exception
     */
    public function export($id): BinaryFileResponse
    {
        $sprint = Sprint::find($id);
        $time = (new \DateTime($sprint->started))->add(new DateInterval("P" . $sprint->duration . "W"))->format("Y-m-d");
        return Excel::download(new SprintExport($sprint->id), "sprint_${time}_.xlsx");
    }
}
