<?php

/*
 * This file is part of the andreas-weber/php-sms library.
 *
 * (c) Andreas Weber <code@andreas-weber.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AndreasWeber\SMS\Test\Core;

use AndreasWeber\SMS\Core\Message;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorInjection()
    {
        // calling constructor with valid arguments
        $recipient = '49123456789';
        $sender = 'easySMS';
        $message = 'Hi, this is me';

        $instance = new Message($recipient, $sender, $message);

        $this->assertEquals($recipient, $instance->getTo());
        $this->assertEquals($sender, $instance->getFrom());
        $this->assertEquals($message, $instance->getMessageText());

        // calling constructor with bad arguments
        $this->setExpectedException('\InvalidArgumentException');
        new Message(null, $sender, $message);
        new Message($recipient, null, $message);
        new Message($recipient, $sender, null);

        // calling constructor without arguments
        $this->setExpectedException('PHPUnit_Framework_Error');
        new Message();
    }

    public function setTestRecipientIsSuccesful()
    {
        $recipient = '49123456789';
        $sender = 'easySMS';
        $message = 'Hi, this is me';

        $instance = new Message($recipient, $sender, $message);
        $this->assertEquals($recipient, $instance->getTo());
    }

    public function testSetRecipientWithBadArgumentFails()
    {
        $recipient = '49123456789';
        $sender = 'easySMS';
        $message = 'Hi, this is me';

        $instance = new Message($recipient, $sender, $message);

        $this->setExpectedException('\InvalidArgumentException');
        $instance->setTo(null);
    }

    public function setTestSenderIsSuccesful()
    {
        $recipient = '49123456789';
        $sender = 'easySMS';
        $message = 'Hi, this is me';

        $instance = new Message($recipient, $sender, $message);
        $this->assertEquals($sender, $instance->getFrom());
    }

    public function testSetSenderWithBadArgumentFails()
    {
        $recipient = '49123456789';
        $sender = 'easySMS';
        $message = 'Hi, this is me';

        $instance = new Message($recipient, $sender, $message);

        $this->setExpectedException('\InvalidArgumentException');
        $instance->setFrom(null);
    }

    public function setTestMessageIsSuccesful()
    {
        $recipient = '49123456789';
        $sender = 'easySMS';
        $message = 'Hi, this is me';

        $instance = new Message($recipient, $sender, $message);
        $this->assertEquals($message, $instance->getMessageText());
    }

    public function testSetMessageWithBadArgumentFails()
    {
        $recipient = '49123456789';
        $sender = 'easySMS';
        $message = 'Hi, this is me';

        $instance = new Message($recipient, $sender, $message);

        $this->setExpectedException('\InvalidArgumentException');
        $instance->setMessageText(null);
    }
}
