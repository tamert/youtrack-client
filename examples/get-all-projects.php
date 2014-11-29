<?php

$root = true; // to see results from getAssigneesUsers, you need to have the right permissions
include_once 'config.php';

$youtrack = new YouTrack\Connection(
    YOUTRACK_URL,
    YOUTRACK_USERNAME,
    YOUTRACK_PASSWORD
);

$projects = $youtrack->getAccessibleProjects(true);

printf('You have %d projects:' . PHP_EOL, count($projects));
foreach ($projects as $project) {
    printf(' - %s' . PHP_EOL, $project->getShortName());

    $systems = $project->getSubsystems();
    printf(' > %d subsystems' . PHP_EOL, count($systems));
    foreach ($systems as $sys) {
        printf(' -- %s' . PHP_EOL, $sys->__get('name'));
    }

    $users = $project->getAssigneesUsers();
    printf(' > %d users' . PHP_EOL, count($users));
    foreach ($users as $user) {
        printf(' -- %s' . PHP_EOL, $user->__get('login'));
    }
    echo PHP_EOL;
}
