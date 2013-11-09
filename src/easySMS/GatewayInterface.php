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


interface GatewayInterface
{
    /**
     * Enables or disables debug mode.
     *
     * @param bool $state
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setDebugMode($state);


    /**
     * Sends a message through the gateway.
     *
     * @param MessageInterface $message
     *
     * @return \easySMS\ResponseInterface
     */
    public function send(MessageInterface $message);
} 
