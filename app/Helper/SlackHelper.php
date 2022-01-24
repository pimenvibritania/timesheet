<?php

namespace App\Helper;

use Illuminate\Support\Facades\Http;

class SlackHelper
{
    public function __construct(
        private string $hook,
        private string $url,
        private string $token
    )
    {
    }

    public function sendMessageWithHook(array $content)
    {
        return Http::withBody($this->getBlocksContent($content), '')
            ->post($this->hook)
            ->json();
    }

    /**
     * @param array $contents
     * @param string|null $threadId
     * @return array|mixed
     */
    public function sendMessage(array $contents, ?string $threadId = null): mixed
    {
        $blocks = $threadId ?
            $this->getBlocksReply($contents) : $this->getBlocksThread($contents) ;

        return Http::withToken($this->token)
            ->withHeaders([
                "Content-Type" => "application/json",
            ])
            ->post($this->url . "/chat.postMessage" , [
                "channel"       => $contents['channelName'],
                "blocks"        => $blocks,
                "thread_ts"     => $threadId,
            ])->json();
    }

    private function getBlocksThread($content): bool|string
    {
        return json_encode([
                [
                    "type" => "header",
                    "text" => [
                        "type" => "plain_text",
                        "text" => "Daily scrum report :date:",
                        "emoji" => true
                    ]
                ],
                [
                    "type" => "context",
                    "elements" => [
                        [
                            "type" => "plain_text",
                            "text" => date('F jS, Y H:i'),
                            "emoji" => true
                        ]
                    ]
                ],
                [
                    "type" => "divider"
                ],
                [
                        "type" => "section",
                        "fields" => [
                            [
                                "type" => "mrkdwn",
                                "text" => "*Sprint* \t\t `{$content['sprintName']}`"
                            ],
                            [
                                "type" => "mrkdwn",
                                "text" => "*Project*\t\t`{$content['projectName']}`"
                            ],
                            [
                                "type" => "mrkdwn",
                                "text" => "*Start*\t\t\t`{$content['sprintStart']}`"
                            ],
                            [
                                "type" => "mrkdwn",
                                "text" => "*End* \t\t\t `{$content['sprintEnd']}`"
                            ],
                            [
                                "type" => "mrkdwn",
                                "text" => "*Status* \t\t `{$content['sprintStatus']}`"
                            ],
                        ]
                    ],
                [
                        "type" => "divider"
            ],
                [
                    "type" => "section",
                    "text" => [
                        "type" => "mrkdwn",
                        "text" => "Go to Jira Board"
                    ],
                    "accessory" => [
                        "type" => "button",
                        "text" => [
                            "type" => "plain_text",
                            "text" => "Jira Board",
                            "emoji" => true
                        ],
                        "value" => "jira_board",
                        "url" => "https://doogether.atlassian.net/jira/software/projects/DOODEV/boards/14",
                        "action_id" => "button-action"
                    ]
                ]
            ]
        );
    }

    private function getBlocksReply($content): bool|string
    {
        return json_encode([
                [
                    "type" => "header",
                    "text" => [
                        "type" => "plain_text",
                        "text" => "Daily scrum report :date:",
                        "emoji" => true
                    ]
                ],
                [
                    "type" => "context",
                    "elements" => [
                        [
                            "type" => "plain_text",
                            "text" => date('F jS, Y H:i'),
                            "emoji" => true
                        ]
                    ]
                ],
                [
                    "type" => "divider"
                ],
                [
                    "type" => "section",
                    "fields" => [
                        [
                            "type" => "mrkdwn",
                            "text" => "*Sprint* \t\t `DOO Sprint 7`"
                        ],
                        [
                            "type" => "mrkdwn",
                            "text" => "*Project*\t\t`DOODEV`"
                        ],
                        [
                            "type" => "mrkdwn",
                            "text" => "*Start*\t\t\t`27 Januari 2022`"
                        ],
                        [
                            "type" => "mrkdwn",
                            "text" => "*End* \t\t\t `06 February 2022`"
                        ],
                        [
                            "type" => "mrkdwn",
                            "text" => "*Status* \t\t `On Going`"
                        ],
                    ]
                ],
                [
                    "type" => "divider"
                ],
                [
                    "type" => "section",
                    "text" => [
                        "type" => "mrkdwn",
                        "text" => "Go to Jira Board"
                    ],
                    "accessory" => [
                        "type" => "button",
                        "text" => [
                            "type" => "plain_text",
                            "text" => "Jira Board",
                            "emoji" => true
                        ],
                        "value" => "jira_board",
                        "url" => "https://doogether.atlassian.net/jira/software/projects/DOODEV/boards/14",
                        "action_id" => "button-action"
                    ]
                ]
            ]
        );
    }
}
