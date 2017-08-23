<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);

$youtrack->updateIssue(
    'Sandbox-4546',
    'Create a basic issue update',
    str_repeat('Description update... on: ' . date('d.m.y H:i:s'), 1024)
);
