<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);

$comments = $youtrack->getComments('Sandbox-171');

foreach ($comments as $comment) {
    echo $comment->getId() . PHP_EOL;
}

$updated = $youtrack->updateComment('Sandbox-171', '64-6383', 'Hello there, updated');
if ($updated) {
    echo 'Comment updated';
} else {
    echo 'Could not update comment';
}
echo PHP_EOL;
