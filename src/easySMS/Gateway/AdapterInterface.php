<?php

/*
 * This file is part of the easySMS library.
 *
 * (c) Andreas Weber <weber@webmanufaktur-weber.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace easySMS\Gateway;


use easySMS\MessageInterface;

interface AdapterInterface
{
    /**
     * Sends a message through the gateway.
     *
     * @param MessageInterface $message
     * @param bool             $debug If debug mode should be enabled
     *
     * @return \easySMS\ResponseInterface
     */
    public function send(MessageInterface $message, $debug = false);
} 
