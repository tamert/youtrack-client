<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);


$params = array(
    'priority' => 'Higher',
    'type' => 'Auto-reported CLI exception',
    'description' => "The full text issue description",
);

$issue = $youtrack->createIssue('Sandbox', 'Create a basic issue for example', $params);

var_dump($issue);
