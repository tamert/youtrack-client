<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// in my .auth.php file:
//
// define('YOUTRACK_URL', 'https://...');
// define('YOUTRACK_USERNAME', '');
// define('YOUTRACK_PASSWORD', '');

if (file_exists('.auth.php')) {
    include_once '.auth.php';
}


define('YOUTRACK_AUTOLOADING', false);

include_once './../vendor/autoload.php';



if (YOUTRACK_AUTOLOADING) {
// We need autoloading for this library. If you have already PSR-0 autoloading in you project
// please remove the following lines
spl_autoload_register(function ($className)
    {
        if (class_exists($className)) {
            return true;
        }
        $className = ltrim($className, '\\');
        $fileName  = '';
        $namespace = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        require $fileName;
    });
// autloading finished
}