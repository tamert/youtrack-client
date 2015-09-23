<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);

// make sure, this exists!

$issues = $youtrack->getIssuesByFilter('#Unresolved for:me');

foreach ($issues as $issue) {
    echo $issue->getId() . PHP_EOL;
}
