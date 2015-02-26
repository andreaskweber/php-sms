# andreas-weber/php-sms

[![Build Status](https://travis-ci.org/andreas-weber/php-sms.svg?branch=master)](https://travis-ci.org/andreas-weber/php-sms)

SMS library for PHP 5.3+.

## Supported sms providers
- [SMSTrade](http://www.smstrade.de/)
- [TextAnywhere](http://www.textanywhere.de/)

## Features

- Send messages
- Receive messages (only if gateway supports inbound messages)

## Requirements
Check shipped composer.json.

## Installation

Simply add a dependency on `andreas-weber/php-sms` to your project's [Composer](http://getcomposer.org/) `composer.json` file.

## Usage

### Send a message

```
use AndreasWeber\SMS\Core\Gateway;
use AndreasWeber\SMS\Core\Gateway\Adapter\SMSTrade;
use AndreasWeber\SMS\Core\Message;

// create gateway
$gateway = new Gateway(
    new SMSTrade('XXXXXXXXXXXX'),
    true
);

// create message
$message = new Message(
    '+49160123456789',
    'php-sms',
    'Hello, how are you?'
);

// send message
$response = $gateway->send($message);

// print response
var_dump($response);
```

### Receive messages

```
use AndreasWeber\SMS\Core\Gateway;
use AndreasWeber\SMS\Core\Gateway\Adapter\TextAnywhere;

// create gateway
$gateway = new Gateway(
    new TextAnywhere('XXXXXXXX', 'XXXXXXXX'),
    true
);

// receive messages
$messages = $gateway->fetch('+49177123456789');

// print messages
var_dump($messages);
```

## Developer

### Environment

Boot:

```
vagrant up
```

Enter virtual machine:

```
vagrant ssh
```

Run tests:

```
cd /vagrant
vendor/bin/phpunit src/Test/
```

### Build targets

```
vagrant@andreas-weber:/vagrant$ ant
Buildfile: /vagrant/build.xml

help:
     [echo]
     [echo] The following commands are available:
     [echo]
     [echo] |   +++ Build +++
     [echo] |-- build                (Run the build)
     [echo] |   |-- dependencies     (Install dependencies)
     [echo] |   |-- tests            (Lint all files and run tests)
     [echo] |   |-- metrics          (Generate quality metrics)
     [echo] |-- cleanup              (Cleanup the build directory)
     [echo] |
     [echo] |   +++ Composer +++
     [echo] |-- composer             -> composer-download, composer-install
     [echo] |-- composer-download    (Downloads composer.phar to project)
     [echo] |-- composer-install     (Install all dependencies)
     [echo] |
     [echo] |   +++ Testing +++
     [echo] |-- phpunit              -> phpunit-full
     [echo] |-- phpunit-tests        (Run unit tests)
     [echo] |-- phpunit-full         (Run unit tests and generate code coverage report / logs)
     [echo] |
     [echo] |   +++ Metrics +++
     [echo] |-- coverage             (Show code coverage metric)
     [echo] |-- phploc               (Show lines of code metric)
     [echo] |-- qa                   (Run quality assurance tools)
     [echo] |-- |-- phpcpd           (Show copy paste metric)
     [echo] |-- |-- phpcs            (Show code sniffer metric)
     [echo] |-- |-- phpmd            (Show mess detector metric)
     [echo] |
     [echo] |   +++ Metric Reports +++
     [echo] |-- phploc-report        (Generate lines of code metric report)
     [echo] |-- phpcpd-report        (Generate copy paste metric report)
     [echo] |-- phpcs-report         (Generate code sniffer metric report)
     [echo] |-- phpmd-report         (Generate mess detector metric report)
     [echo] |
     [echo] |   +++ Tools +++
     [echo] |-- lint                 (Lint all php files)
     [echo]
```

## Thoughts
Pull requests are highly appreciated. Built with love. Hope you'll enjoy.. :-)
