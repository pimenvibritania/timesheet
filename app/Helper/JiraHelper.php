<?php

namespace App\Helper;

use Illuminate\Support\Facades\Http;

class JiraHelper
{

    const DOODEV_BOARD = 14;

    public function __construct(
        private string $url,
        private string $email,
        private string $token
    )
    {
    }

    public function getSprints(string $projectKey)
    {
        return Http::withBasicAuth($this->email, $this->token)->get(
            $this->url . "/integration/teamcalendars/sprint/list", [
                "jql" => "project={$projectKey}"
            ]
        )->json();
    }

    public function getAgileSprints(int $boardID) {
        return Http::withBasicAuth($this->email, $this->token)->get(
            $this->url . "/board/{$boardID}/sprint")->json();
    }

    public function getDetailSprint(int $jiraSprintId)
    {
        return Http::withBasicAuth($this->email, $this->token)->get(
            $this->url . "/sprint/{$jiraSprintId}")->json();
    }
}
