<?php

include_once 'config.php';

try {
    $youtrack = new YouTrack\Connection(
        YOUTRACK_URL,
        YOUTRACK_USERNAME,
        YOUTRACK_PASSWORD
    );
    echo 'Login correct.' . PHP_EOL;
} catch (\YouTrack\IncorrectLoginException $e) {
    echo 'Incorrect login or password.' . PHP_EOL;
}
