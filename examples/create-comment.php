<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);

$created = $youtrack->createComment('Sandbox-171', 'Hello there');

if ($created) {
    echo 'Comment added';
} else {
    echo 'Could not create comment';
}
echo PHP_EOL;
