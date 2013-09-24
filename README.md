YouTrack Client PHP Library
===========================

[![Build Status](https://travis-ci.org/nepda/YouTrack-Client-PHP-Library.png?branch=master)](https://travis-ci.org/nepda/YouTrack-Client-PHP-Library)


The bugtracker [YouTrack](http://www.jetbrains.com/youtrack/) provides a [REST-API](http://confluence.jetbrains.net/display/YTD3/YouTrack+REST+API+Reference). Because a lot of web applications are written in [PHP](http://php.net) I decided to write a client library for it. To make it easier for developers to write connectors to YouTrack.

Basically this is a port of the offical python api from Jetbrains.
The initial development was sponsored by [Telematika GmbH](http://www.telematika.de).

The source of this library is released under the BSD license (see LICENSE for details).

Requirements
------------

* PHP 5.3.x (Any version above 5 might work but I can't guarantee that.)
* curl
* simplexml
* YouTrack 3.0 with REST-API enabled

Usage
-----

    <?php
    require_once("YouTrack/src/Connection.php");
    $youtrack = new \YouTrack\Connection("http://example.com", "login", "password");
    $issue = $youtrack->getIssue("TEST-1");
    ...

Usage with ZF2 ZendSkeletonApplication
--------------

In your /init_autoloader.php

    <?php
    // ... snip
    if ($zf2Path) {
        if (isset($loader)) {
            $loader->add('Zend', $zf2Path);
        } else {
            include $zf2Path . '/Zend/Loader/AutoloaderFactory.php';
            Zend\Loader\AutoloaderFactory::factory(array(
                'Zend\Loader\StandardAutoloader' => array(
                    'autoregister_zf' => true,
                    'namespaces' => [                            // add this
                        'YouTrack' => 'vendor/YouTrack/src'      // ...
                    ],                                           // ...
                )
            ));
        }
    }
    // ... snip

From now on you can use YouTrack-Client-PHP-Library from any file in you ZF2-App.

    <?php
    // ...
    // example
    use YouTrack\Connection as YouTrackConnection;

    class ExampleController extends AbstractActionController
    {

        public function anyAction()
        {
            $youtrack = new YouTrackConnection("http://example.com", "login", "password");
            $issue = $youtrack->getIssue("TEST-1");
            // ...
        }
    }
