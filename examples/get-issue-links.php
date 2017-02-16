<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);

$issues = [];
if (!empty($argv[1])) {
    $issues = explode(',', $argv[1]);
} else {
    $issues[] = 'Sandbox-64';
}

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
