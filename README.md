YouTrack Client PHP Library
===========================

[![Build Status](https://travis-ci.org/nepda/youtrack.png?branch=master)](https://travis-ci.org/nepda/youtrack)


The bugtracker [YouTrack](http://www.jetbrains.com/youtrack/) provides a [REST-API](http://confluence.jetbrains.net/display/YTD3/YouTrack+REST+API+Reference). Because a lot of web applications are written in [PHP](http://php.net) I decided to write a client library for it. To make it easier for developers to write connectors to YouTrack.

The initial development was sponsored by [Telematika GmbH](http://www.telematika.de).
The current development is made by nepda.

The source of this library is released under the BSD license (see LICENSE for details).

## Requirements

* PHP 5.3.x (Tested with >= 5.5, Travis runs tests with 5.3, 5.4 and 5.5)
* curl
* simplexml
* YouTrack 3.0+ with REST-API enabled (currently, the production system runs with YouTrack 5.0.3)


## Usage

    <?php
    require_once("YouTrack/Connection.php");
    $youtrack = new \YouTrack\Connection("http://example.com", "login", "password");
    $issue = $youtrack->getIssue("TEST-1");
    ...


## Usage with ZF2 ZendSkeletonApplication

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
                        'YouTrack' => 'vendor/YouTrack'          // ...
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

## Tests

The testsuite depends on PHPUnit. You can install it with `composer.phar`:

    curl -sS https://getcomposer.org/installer | php --
    php composer.phar install


The unit tests are incomplete but you can run them using `phpunit` like this:

    ./vendor/bin/phpunit ./test
