<?php

include_once __DIR__ . '/config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);

$projectId = 'Sandbox';
$fieldName = 'Milestone';

$result = $youtrack->getProjectCustomField($projectId, $fieldName);

echo $projectId . '/' . $fieldName . ':' . PHP_EOL;
foreach ($result as $k => $v) {
    echo '    ' . $k . ': "' . $v . '"' . PHP_EOL;
}
echo PHP_EOL;
