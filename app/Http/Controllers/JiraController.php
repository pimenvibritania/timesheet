<?php

namespace App\Http\Controllers;

use App\Helper\JiraHelper;
use App\Models\Sprint;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JiraController extends Controller
{
    public function allSprints(JiraHelper $jiraHelper){
        return $jiraHelper->getAgileSprints(JiraHelper::DOODEV_BOARD);
    }

    public function getSprint(JiraHelper $jiraHelper, int $jiraSprintId){
        return $jiraHelper->getDetailSprint($jiraSprintId);
    }

    /**
     * @throws Exception
     */
    public function createSprint(Request $request): JsonResponse
    {
        return response()->json(
            Sprint::create([
                "jira_sprint_id" => $request->jira_sprint_id,
                "jira_sprint_link" => $request->jira_sprint_link,
                "name" => $request->name,
                "started" => (new \DateTime($request->started))->format('Y-m-d'),
                "ended" => (new \DateTime($request->ended))->format('Y-m-d'),
                "duration" => $request->duration,
                "status" => $request->status,
            ])
        );
    }
}
