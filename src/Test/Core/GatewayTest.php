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

use AndreasWeber\SMS\Core\Gateway;
use AndreasWeber\SMS\Core\Gateway\AdapterInterface;
use AndreasWeber\SMS\Test\Core\Stub\Adapter;
use AndreasWeber\SMS\Test\Core\Stub\Message;

class GatewayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;

    protected function setUp()
    {
        $this->adapter = new Adapter();
    }

    public function testConstructorInjection()
    {
        $gateway = new Gateway(
            $this->adapter,
            true
        );

        $this->assertInstanceOf('\\AndreasWeber\\SMS\\Core\\Gateway', $gateway);
    }

    public function testConstructorFailsIfDebugModeTypeIsNotBool()
    {
        $this->setExpectedException('InvalidArgumentException');

        new Gateway(
            $this->adapter,
            'ABC'
        );
    }

    public function testConstructorFailsIfAdapterIsNotImplementingAdapterInterface()
    {
        $this->setExpectedException('PHPUnit_Framework_Error');

        new Gateway(
            'ABC',
            true
        );
    }

    public function testSendingReturnsObjectImplementingResponseInterface()
    {
        $gateway = new Gateway(
            $this->adapter,
            true
        );

        $message = new Message(
            '+4916090282219',
            'php-sms',
            'hi, how are you?'
        );

        $response = $gateway->send($message);

        $this->assertInstanceOf('\\AndreasWeber\\SMS\\Core\\Response', $response);
    }
}
