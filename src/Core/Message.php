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

class Message
{
    /**
     * @var string Recipient
     */
    private $to;

    /**
     * @var string Sender
     */
    private $from;

    /**
     * @var string Message text
     */
    private $messageText;
    
    /**
     * __construct()
     *
     * @param string $recipient Recipient
     * @param string $sender Sender
     * @param string $messageText Message text
     */
    public function __construct($recipient, $sender, $messageText)
    {
        $this->setTo($recipient);
        $this->setFrom($sender);
        $this->setMessageText($messageText);
    }

    /**
     * Sets the recipient.
     *
     * @param string $recipient Recipient
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setTo($recipient)
    {
        if (!is_string($recipient)) {
            throw new \InvalidArgumentException();
        }
        $this->to = $recipient;
        return $this;
    }
    
    /**
     * Returns the recipient.
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }
    
    /**
     * Sets the sender.
     *
     * @param string $sender Sender
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setFrom($sender)
    {
        if (!is_string($sender)) {
            throw new \InvalidArgumentException();
        }
        $this->from = $sender;
        return $this;
    }

    /**
     * Returns the sender.
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }
    
    /**
     * Sets the message text.
     *
     * @param string $messageText Message text
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setMessageText($messageText)
    {
        if (!is_string($messageText)) {
            throw new \InvalidArgumentException();
        }
        $this->messageText = $messageText;
        return $this;
    }
    
    /**
     * Returns the message text.
     *
     * @return string
     */
    public function getMessageText()
    {
        return $this->messageText;
    }
}
