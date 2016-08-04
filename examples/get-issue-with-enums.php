<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);

$issueId = 'Sandbox-3958';

// make sure, this exists!
$issue = $youtrack->getIssue($issueId);

if ($issue) {
    $module = $issue->getModule();
    echo 'Modules:' . PHP_EOL;
    foreach ($module as $m) {
        echo ' - ' . $m . PHP_EOL;
    }
} else {
    echo sprintf('Issue "%s" does not exist!%s', $issueId, PHP_EOL);
}
