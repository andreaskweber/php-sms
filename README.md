# andreas-weber/php-sms

SMS library for PHP 5.3+.

## Supported sms providers
- [SMSTrade](http://www.smstrade.de/)

## Requirements
Check shipped composer.json.

## Installation

Simply add a dependency on `andreas-weber/php-sms` to your project's [Composer](http://getcomposer.org/) `composer.json` file.

## Usage

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

## Developer

Boot development environment:

```
vagrant up
```

Run tests:

```
cd /var/php-sms
vendor/bin/phpunit src/Test/ 
```

## Thoughts
Built with love. Hope you'll enjoy.. :-)
