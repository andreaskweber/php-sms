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


interface MessageInterface
{
    /**
     * Sets the recipient.
     *
     * @param string $recipient
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setTo($recipient);


    /**
     * Returns the recipient.
     *
     * @return string
     */
    public function getTo();


    /**
     * Sets the sender.
     *
     * @param string $sender
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setFrom($sender);


    /**
     * Returns the sender.
     *
     * @return string
     */
    public function getFrom();


    /**
     * Sets the message text.
     *
     * @param string $messageText
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setMessageText($messageText);


    /**
     * Returns the message text.
     *
     * @return string
     */
    public function getMessageText();

} 
