<?php

/*
 * This file is part of the andreas-weber/php-sms library.
 *
 * (c) Andreas Weber <code@andreas-weber.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AndreasWeber\SMS\Core;

use AndreasWeber\SMS\Core\Gateway\AdapterInterface;

class Gateway
{
    /**
     * @var AdapterInterface Adapter
     */
    private $adapter;

    /**
     * @var bool Debug mode
     */
    private $debugMode;

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
     * @param Message $message
     *
     * @return \AndreasWeber\SMS\Core\Response
     */
    public function send(Message $message)
    {
        return $this->adapter->send(
            $message,
            $this->debugMode
        );
    }
}
