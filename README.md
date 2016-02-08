YouTrack Client PHP Library
===========================

[![Build Status](https://travis-ci.org/Angerslave/youtrack.png?branch=master)](https://travis-ci.org/Angerslave/youtrack)

The bugtracker [YouTrack](http://www.jetbrains.com/youtrack/) provides a
[REST-API](http://confluence.jetbrains.com/display/YTD5/YouTrack+REST+API+Reference).
Because a lot of web applications are written in [PHP](http://php.net) I decided to write a client library for it.
To make it easier for developers to write connectors to YouTrack.

The initial development was sponsored by [Telematika GmbH](http://www.telematika.de).
The current development is made by nepda.

The source of this library is released under the BSD license (see LICENSE for details).

## Requirements

* PHP >= 5.4 (Tested with >= 5.5, Travis runs tests with 5.4, 5.5 and 5.6)
* curl
* simplexml
* json
* YouTrack 3.0+ with REST-API enabled (currently, the production system runs with YouTrack 6.0)

## Changelog

### 2015-02-10 - v1.0.9

* Merged #6 'Fetch issues by filter only + with comments'. Thanks [@chabberwock](https://github.com/chabberwock)

### 2015-01-15 - v1.0.8

* Merged #5 'Fixed executing queries.'. Thanks [@wdamien](https://github.com/wdamien)
* Added example for executing simple command

### 2014-12-02 - v1.0.7

* Improved error handling - On 404 error, the call will throw a `YouTrack\NotFoundException`
* Improved error handling - `YouTrack\Exception`/`YouTrack\Error` is now aware of JSON responses
* Improved connection request method. If the body is array it will no longer check if the file exists (Notice was thrown by PHP)

### 2014-11-29 - v1.0.6

* Fixed Issue #4, Improved `getAccessibleProjects`, see `examples/get-all-projects.php`. Thanks [@openWebX](https://github.com/openWebX)


(Please look into CHANGELOG for a complete list of the past releases)

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
* [@openWebX](https://github.com/openWebX)
* [@wdamien](https://github.com/wdamien)
* [@angerslave](https://github.com/Angerslave)

(and more: https://github.com/nepda/youtrack/network/members)
