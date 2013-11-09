<?php

/*
 * This file is part of the easySMS library.
 *
 * (c) Andreas Weber <weber@webmanufaktur-weber.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

// vars
$apiKey = 'XXXXXXXXXXXX';
$debugMode = true;

$recipient = '+49160123456789';
$sender = 'easySMS';
$messageText = 'Hello, how are you?';

// get autoloader
require __DIR__ . '/vendor/autoload.php';

// create gateway
$gateway = new \easySMS\Gateway(
    new \easySMS\Gateway\Adapter\SMSTrade($apiKey),
    $debugMode
);

// create message
$message = new \easySMS\Message(
    $recipient,
    $sender,
    $messageText
);

// send message
$response = $gateway->send($message);

// print response
// echo "<pre>";
var_dump($response);
