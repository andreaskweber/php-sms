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

use AndreasWeber\SMS\Core\Response;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructorInjection()
    {
        $time = time();
        $successful = true;
        $code = 10;
        $message = 'Yeah, everything went well!';

        // calling constructor with valid arguments
        $instance = new Response($time, $successful, $code, $message);
        $this->assertEquals($time, $instance->getTstamp());
        $this->assertEquals($successful, $instance->wasSuccessful());
        $this->assertEquals($code, $instance->getResponseCode());
        $this->assertEquals($message, $instance->getResponseMessage());

        // calling constructor without arguments
        $this->setExpectedException('PHPUnit_Framework_Error');
        new Response();
    }

    public function testThrowsExceptionByNegativeTstamp()
    {
        $time = -500; // negative tstamp
        $successful = true;
        $code = 10;
        $message = 'Yeah, everything went well!';

        $this->setExpectedException('\InvalidArgumentException');
        new Response($time, $successful, $code, $message);
    }

    public function testThrowsExceptionByTstampNotInt()
    {
        $time = 'ABC'; // not INT
        $successful = true;
        $code = 10;
        $message = 'Yeah, everything went well!';

        $this->setExpectedException('\InvalidArgumentException');
        new Response($time, $successful, $code, $message);
    }
    
    public function testThrowsExceptionBySuccessfulStateNotBool()
    {
        $time = time();
        $successful = 'ABC'; // not bool
        $code = 10;
        $message = 'Yeah, everything went well!';

        $this->setExpectedException('\InvalidArgumentException');
        new Response($time, $successful, $code, $message);
    }
}
