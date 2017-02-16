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

    echo '=Link summary for ' . $issue->getId() . '=' . PHP_EOL . PHP_EOL;

    $links = $issue->getLinks();
    $linkByType = [];
    foreach ($links as $link) {

        if ($link->getTarget() == $issue->getId()) {
            $linkByType[$link->getTypeInward()][] = $link->getSource();
        } else {
            $linkByType[$link->getTypeOutward()][] = $link->getTarget();
        }
    }

    foreach ($linkByType as $type => $linkIssueIds) {

        echo PHP_EOL . '==' . ucfirst(trim($type)) . '==' . PHP_EOL;
        foreach ($linkIssueIds as $linkIssueId) {
            $linkIssue = $youtrack->getIssue($linkIssueId);
            if ($linkIssue->getResolved()) {
                $sign = '☑';
            } else {
                $sign = '☐';
            }
            echo '*' . $sign . ' ' . $linkIssue->getId() . ' ' .
                $linkIssue->getSummary() . ' (' . $linkIssue->getState() . ')' . PHP_EOL;
        }
    }
}
