<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);


// make sure, this exists!
#$issueId = 'Sandbox-6';

$issues = [
    'Sandbox-24',
    'Sandbox-25'
];


foreach ($issues as $issueId) {

    $issue = $youtrack->getIssue($issueId);

    $attachments = $issue->getAttachments();
    foreach ($attachments as $attachment) {

        echo $attachment->getName() . PHP_EOL;
        // here you can play with your file
        $content = $attachment->fetchContent();
        file_put_contents('./files/' . $attachment->getName(), $content);
    }
}
