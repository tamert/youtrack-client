<?php

include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);


$issueId = 'Sandbox-57';

$attachment = new YouTrack\Attachment();

$attachment->setUrl(dirname(__FILE__) . '/attachment.txt');
$attachment->setName('mylog');

$result = $youtrack->createAttachmentFromAttachment($issueId, $attachment);
