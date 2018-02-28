<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);


$params = [
    'priority' => 'Higher',
    'type' => 'Auto-reported CLI exception',
    'description' => 'The full text issue description',
];

try {
    $issue = $youtrack->createIssue('Sandbox', 'Create a basic issue for example', $params);

    if ($issue) {
        printf('Issue %s created' . PHP_EOL, $issue->getId());
    }
} catch (\YouTrack\NotAuthorizedException $e) {
    echo 'Caught a not authorized exception: ' . $e->getMessage() . PHP_EOL;
    var_dump($e->getYouTrackError());
} catch (\YouTrack\IncorrectLoginException $e) {
    echo 'Caught a incorrect login exception: ' . $e->getMessage() . PHP_EOL;
    var_dump($e->getYouTrackError());
} catch (\YouTrack\NotFoundException $e) {
    echo 'Caught a not found exception: ' . $e->getMessage() . PHP_EOL;
    var_dump($e->getYouTrackError());
} catch (\YouTrack\Exception $e) {
    echo 'Caught a generic YouTrack exception: ' . $e->getMessage() . PHP_EOL;
    var_dump($e->getYouTrackError());
}
