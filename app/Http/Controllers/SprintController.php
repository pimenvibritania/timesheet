<?php

namespace App\Http\Controllers;

use App\Exports\SprintExport;
use App\Helper\JiraHelper;
use App\Helper\SlackHelper;
use App\Models\Member;
use App\Models\Sprint;
use DateInterval;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;

class SprintController extends VoyagerBaseController
{
    private array $contents = [
        'memberName' => '',
        'memberRole' => '',
        'channelName' => '',
        'sprintName' => '',
        'projectName' => '',
        'sprintStart' => '',
        'sprintEnd' => '',
        'sprintStatus' => ''
    ];
    /**
     * @throws Exception
     */
    public function export($id): BinaryFileResponse
    {
        $sprint = Sprint::find($id);
        $time = (new \DateTime($sprint->started))->add(new DateInterval("P" . $sprint->duration . "W"))->format("Y-m-d");
        return Excel::download(new SprintExport($sprint->id), "sprint_${time}_.xlsx");
    }

    public function fetchSprints(JiraHelper $jiraHelper, string $projectKey)
    {
        return $jiraHelper->getSprints($projectKey);
    }

    public function createThread(SlackHelper $slackHelper){
        $member = Member::find(1);

        $this->contents['memberName'] = $member->first_name . " " . $member->last_name;
        $this->contents['memberRole'] = $member->role;
        $this->contents['channelName'] = env('SLACK_CHANNEL_NAME');

        return $slackHelper->sendMessage(
            $this->contents,
        );
    }
}
