<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);

// make sure, this issue exists!

$issues = [
    'Sandbox-281'
];

// see the description here: https://confluence.jetbrains.com/display/YTD65/Get+Issue+History
// how the result should look like.

foreach ($issues as $issueId) {

    $history = $youtrack->getIssueHistory($issueId);
    var_dump($history);
}
