<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);


$issueId = 'Sandbox-7967';
$command = 'Assignee Unassigned';

try {
    $result = $youtrack->executeCommand($issueId, $command);
    if ($result) {
        echo "Command '$command' executed on issue '$issueId'." . PHP_EOL;
    } else {
        echo 'The command was not executed' . PHP_EOL;
    }
} catch (\YouTrack\NotAuthorizedException $e) {
    echo $e->getMessage() . PHP_EOL;
}

