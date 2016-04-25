<?php
$root = true;
include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);

$boards = array();
try {
    $boards = $youtrack->getAgileBoards();
} catch (\YouTrack\NotAuthorizedException $e) {
    $message = 'Got NotAuthorizedException!';
    if ($error = $e->getYouTrackError()) {
        $message = $error->__get("error");
    }
    echo sprintf($message) . PHP_EOL;
}

if ($boards) {
    printf('Results:' . PHP_EOL . PHP_EOL);
    foreach ($boards as $board) {
        echo sprintf('%s, ID: %s', $board->getName(), $board->getId()) . PHP_EOL;

        $sprints = $board->getSprints();
        $sprintNames = [];
        foreach ($sprints as $sprint) {
            $sprintNames[] = $sprint->getId();
        }
        echo count($sprints) . ' Sprint(s): ' . implode(', ', $sprintNames) . PHP_EOL . PHP_EOL;
    }
}
