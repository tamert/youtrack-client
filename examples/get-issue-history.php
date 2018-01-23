<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);

// make sure, this issue exists!

$issues = [
    'Sandbox-281',
];

// see the description here: https://www.jetbrains.com/help/youtrack/incloud/Get-Issue-History.html
// how the result should look like.

foreach ($issues as $issueId) {

    $history = $youtrack->getIssueHistory($issueId);
    echo count($history) . ' History entries found for issue ' . $issueId . PHP_EOL;
}
