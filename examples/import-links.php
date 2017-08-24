<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);

$links = [
    [
        'typeName' => 'depend',
        'source' => 'CMN-1928',
        'target' => 'CMN-1917',
    ],
    [
        'typeName' => 'rescind',
        'source' => 'CMN-1987',
        'target' => 'CMN-1928',
    ],
];

$youtrack->importLinks($links);
