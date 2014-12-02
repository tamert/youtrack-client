<?php
$root = true;
include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);

$user = 'root';

$roles = [];
try {
    $roles = $youtrack->getUserRoles($user);
} catch (\YouTrack\NotAuthorizedException $e) {
    $message = 'Got NotAuthorizedException!';
    if ($error = $e->getYouTrackError()) {
        $message = $error->__get("error");
    }
    echo sprintf($message) . PHP_EOL;
}

if ($roles) {
    printf('Results:'. PHP_EOL);
    foreach ($roles as $role) {
        $refs = $role->getProjectRefs();
        $projectRefs = '';
        if (!empty($refs)) {
            $projectRefs = [];
            foreach ($refs as $ref) {
                $projectRefs[] = $ref->getId();
            }
            $projectRefs = ' (' . implode(', ', $projectRefs) . ')';
        }
        echo sprintf(' - %s%s', $role->getName(), $projectRefs) . PHP_EOL;
    }
}
