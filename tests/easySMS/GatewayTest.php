<?php

/*
 * This file is part of the easySMS library.
 *
 * (c) Andreas Weber <weber@webmanufaktur-weber.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace easySMS\Tests;

use easySMS\Gateway;

class GatewayTest
    extends \PHPUnit_Framework_TestCase
{
    protected $adapter;


    protected function setUp()
    {
        parent::setUp();

        // mock adapter
        $adapter = $this->getMock('\easySMS\Gateway\AdapterInterface');
        $this->adapter = $adapter;

        // prepare adapter mock        
        $adapter
            ->expects($this->any())
            ->method('send')
            ->will($this->returnValue(
                $this->getMock('\easySMS\ResponseInterface')
            ));
    }


    public function testConstructorInjection()
    {
        $gateway = new Gateway(
            $this->adapter,
            true
        );
        $this->assertInstanceOf('\easySMS\Gateway', $gateway);
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

        $message = $this->getMock('\easySMS\MessageInterface');
        $response = $gateway->send($message);

        $this->assertInstanceOf('\easySMS\ResponseInterface', $response);
    }
}
