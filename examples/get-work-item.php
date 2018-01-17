<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);

$issueId = 'Sandbox-64';
if (!empty($argv[1])) {
    $issueId = $argv[1];
}

// make sure, this exists!
$workItems = $youtrack->getWorkitems($issueId);

if ($workItems) {
    foreach ($workItems as $item) {
        echo $item->getDescription() . ' - ' . $item->getDuration() . PHP_EOL;
    }
} else {
    echo sprintf('Issue "%s" does not exist!%s', $issueId, PHP_EOL);
}
