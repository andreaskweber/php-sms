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


class Message
    implements MessageInterface
{
    /**
     * @var string Recipient
     */
    protected $to;

    /**
     * @var string Sender
     */
    protected $from;

    /**
     * @var string Message text
     */
    protected $messageText;


    /**
     * __construct()
     *
     * @param string $recipient
     * @param string $sender
     * @param string $messageText
     */
    function __construct($recipient, $sender, $messageText)
    {
        $this->setTo($recipient);
        $this->setFrom($sender);
        $this->setMessageText($messageText);
    }


    /**
     * Sets the recipient.
     *
     * @param string $recipient
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
     * @throws \RuntimeException When no recipient was set
     */
    public function getTo()
    {
        if (is_null($this->to)) {
            throw new \RuntimeException('No recipient was set');
        }
        return $this->to;
    }


    /**
     * Sets the sender.
     *
     * @param string $sender
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
     * @throws \RuntimeException When no sender was set
     */
    public function getFrom()
    {
        if (is_null($this->from)) {
            throw new \RuntimeException('No sender was set');
        }
        return $this->from;
    }


    /**
     * Sets the message text.
     *
     * @param string $messageText
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
     * @throws \RuntimeException When no message was set
     */
    public function getMessageText()
    {
        if (is_null($this->messageText)) {
            throw new \RuntimeException('No message text was set');
        }
        return $this->messageText;
    }

} 
