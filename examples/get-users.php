<?php
$root = true;
include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);

$users = [];
try {
    $users = $youtrack->getUsers();
} catch (\YouTrack\NotAuthorizedException $e) {
    $message = 'Got NotAuthorizedException!';
    if ($error = $e->getYouTrackError()) {
        $message = $error->__get('error');
    }
    echo sprintf($message) . PHP_EOL;
}

if ($users) {
    printf('Results:' . PHP_EOL);
    foreach ($users as $user) {
        echo sprintf(' - %s', $user->getLogin()) . PHP_EOL;
    }
}
