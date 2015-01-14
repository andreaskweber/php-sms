<?php

/*
 * This file is part of the andreas-weber/php-sms library.
 *
 * (c) Andreas Weber <code@andreas-weber.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AndreasWeber\SMS\Core\Gateway;

use AndreasWeber\SMS\Core\Message;

interface AdapterInterface
{
    /**
     * Sends a message through the gateway.
     *
     * @param Message $message Message
     * @param bool             $debug If debug mode should be enabled
     *
     * @return \AndreasWeber\SMS\Core\Response
     */
    public function send(Message $message, $debug = false);
}
