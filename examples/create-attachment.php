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
/*
array(2) {
  'content' =>
  string(194) "{"id":"62-2910","url":"http://nepda.myjetbrains.com/youtrack/_persistent/mylog2.txt?file=62-2910&v=0&c=false","name":"mylog2.txt","authorLogin":"php","group":"All Users","created":1417519013543}"
  'response' =>
  array(26) {
    'url' =>
    string(82) "https://nepda.myjetbrains.com/youtrack/rest/issue/Sandbox-57/attachment?name=mylog"
    'content_type' =>
    string(31) "application/json; charset=utf-8"
    'http_code' =>
    int(201)
    'header_size' =>
    int(427)
    'request_size' =>
    int(551)
    'filetime' =>
    int(-1)
    'ssl_verify_result' =>
    int(0)
    'redirect_count' =>
    int(0)
    'total_time' =>
    double(0.495021)
    'namelookup_time' =>
    double(5.1E-5)
    'connect_time' =>
    double(0.049198)
    'pretransfer_time' =>
    double(0.24344)
    'size_upload' =>
    double(288)
    'size_download' =>
    double(194)
    'speed_download' =>
    double(391)
    'speed_upload' =>
    double(581)
    'download_content_length' =>
    double(-1)
    'upload_content_length' =>
    double(288)
    'starttransfer_time' =>
    double(0.29847)
    'redirect_time' =>
    double(0)
    'redirect_url' =>
    string(0) ""
    'primary_ip' =>
    string(13) "54.217.208.28"
    'certinfo' =>
    array(0) {
    }
    'primary_port' =>
    int(443)
    'local_ip' =>
    string(12) "192.168.0.13"
    'local_port' =>
    int(54233)
  }
}
 */
