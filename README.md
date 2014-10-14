YouTrack Client PHP Library
===========================

[![Build Status](https://travis-ci.org/nepda/youtrack.png?branch=master)](https://travis-ci.org/nepda/youtrack)
[![Dependency Status](https://www.versioneye.com/user/projects/53f72420e09da3fa11000327/badge.svg)](https://www.versioneye.com/user/projects/53f72420e09da3fa11000327)

The bugtracker [YouTrack](http://www.jetbrains.com/youtrack/) provides a
[REST-API](http://confluence.jetbrains.com/display/YTD5/YouTrack+REST+API+Reference).
Because a lot of web applications are written in [PHP](http://php.net) I decided to write a client library for it.
To make it easier for developers to write connectors to YouTrack.

The initial development was sponsored by [Telematika GmbH](http://www.telematika.de).
The current development is made by nepda.

The source of this library is released under the BSD license (see LICENSE for details).

## Requirements

* PHP >= 5.4 (Tested with >= 5.5, Travis runs tests with 5.4 and 5.5)
* curl
* simplexml
* YouTrack 3.0+ with REST-API enabled (currently, the production system runs with YouTrack 5.0.3)

## Changelog

### 2014-10-14 - v1.0.3

* Added support for long parameter values for method `createIssue` (It was not possible to do a request with more than 8205 chars (InCluod, nginx 414-Error))
* Improved DocBlocs for Connection class methods

### 2014-09-01 - v1.0.2

* Added more parameters (full support now) for ´executeCommand´. Thanks [@1ed](https://github.com/1ed). See [Apply Command to an Issue](http://confluence.jetbrains.com/display/YTD5/Apply+Command+to+an+Issue)

### 2014-09-01 - v1.0.1

* Added executeCountQueries ([Get Number of Issues for Several Queries](http://confluence.jetbrains.com/display/YTD5/Get+Number+of+Issues+for+Several+Queries)). See `./examples/query-count.php`. (Thanks [Limelyte](https://github.com/Limelyte/youtrack/commit/4e4f30e2a118e20f8f364119c37f3e17f38addfa)).

## Usage

    <?php
    require_once("YouTrack/Connection.php");
    $youtrack = new \YouTrack\Connection("http://example.com", "login", "password");
    $issue = $youtrack->getIssue("TEST-1");
    ...

See `./examples` folder for more usage examples.

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


## Contributors

* [@jan0sch](https://github.com/jan0sch)
* [@jkswoods](https://github.com/jkswoods)
* [@Shyru](https://github.com/Shyru)
* [@nepda](https://github.com/nepda)
* [@richardhinkamp](https://github.com/richardhinkamp)
* [@Limelyte](https://github.com/Limelyte)
* [@1ed](https://github.com/1ed)
