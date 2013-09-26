<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);


// make sure, this exists!
$issueId = 'Sandbox-6';


$issue = $youtrack->getIssue($issueId);

$attachments = $issue->getAttachments();
foreach ($attachments as $attachment) {

    echo $attachment->getName() . '<br>';
    // here you can play with your file
    // $content = $attachment->fetchContent();
    // file_put_contents('./files/' . $attachment->getName(), $content);
}