<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);

// make sure, this exists!

$issues = [
    'Sandbox-36'
];


foreach ($issues as $issueId) {

    $issue = $youtrack->getIssue($issueId);

    $links = $issue->getLinks();
    foreach ($links as $link) {

        echo print_r([
            'target' => $link->getTarget(),
            'source' => $link->getSource(),
            'typeInward' => $link->getTypeInward(),
            'typeOutward' => $link->getTypeOutward(),
            'typeName' => $link->getTypeName(),
        ], true);

        echo $link->getSource() . ' ' . $link->getTypeOutward() . ' ' . $link->getTarget() . PHP_EOL;
    }
}
