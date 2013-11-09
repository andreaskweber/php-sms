<?php

/*
 * This file is part of the easySMS library.
 *
 * (c) Andreas Weber <weber@webmanufaktur-weber.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace easySMS;


use easySMS\Gateway\AdapterInterface;

class Gateway
    implements GatewayInterface
{
    /**
     * @var AdapterInterface Adapter
     */
    protected $adapter;


    /**
     * @var bool Debug mode
     */
    protected $debugMode;


    /**
     * __construct()
     *
     * @param AdapterInterface $adapter
     * @param bool             $debugMode Enables or disables debug mode
     */
    public function __construct(AdapterInterface $adapter, $debugMode = false)
    {
        $this->adapter = $adapter;
        $this->setDebugMode($debugMode);
    }


    /**
     * Enables or disables debug mode.
     *
     * @param bool $state
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setDebugMode($state)
    {
        if (!is_bool($state)) {
            throw new \InvalidArgumentException();
        }

        $this->debugMode = $state;
        return $this;
    }


    /**
     * Sends a message through the gateway.
     *
     * @param MessageInterface $message
     *
     * @return \easySMS\ResponseInterface
     */
    public function send(MessageInterface $message)
    {
        return $this->adapter->send(
            $message,
            $this->debugMode
        );
    }

} 
