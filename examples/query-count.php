<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);


$queries = [
    '#Resolved',
    '#Fixed'
];

$result = $youtrack->executeCountQueries($queries);

/*
array (
    0 => 7286,
    '#Resolved' => 7286,
    1 => 5625,
    '#Fixed' => 5625,
)
*/

if ($result) {
    printf('Results:' . PHP_EOL);
    foreach ($result as $k => $v) {
        if (!is_int($k)) {
            printf('"%s": %s' . PHP_EOL, $k, $v);
        }
    }
}

