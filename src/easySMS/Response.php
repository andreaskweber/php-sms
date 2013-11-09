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


class Response
    implements ResponseInterface
{
    /**
     * @var bool Sending successful
     */
    protected $successful;

    /**
     * @var int Timestamp message was sent
     */
    protected $tstamp;

    /**
     * @var mixed Gateway adapter response code
     */
    protected $code;

    /**
     * @var mixed Gateway adapter response message
     */
    protected $message;


    /**
     * __construct()
     *
     * @param int  $tstamp
     * @param bool $successful
     * @param null $code
     * @param null $message
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($tstamp, $successful, $code = null, $message = null)
    {
        if (!is_int($tstamp) || $tstamp < 0 || !is_bool($successful)) {
            throw new \InvalidArgumentException();
        }

        $this->tstamp = $tstamp;
        $this->successful = $successful;
        $this->code = $code;
        $this->message = $message;
    }


    /**
     * Returns the sending tstamp.
     *
     * @return int
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }


    /**
     * Returns the gateway response code.
     *
     * @return mixed
     */
    public function getResponseCode()
    {
        return $this->code;
    }


    /**
     * Returns the gateway response message.
     *
     * @return mixed
     */
    public function getResponseMessage()
    {
        return $this->message;
    }


    /**
     * Returns if the sending was successful.
     *
     * @return bool
     */
    public function wasSuccessful()
    {
        return $this->successful;
    }

} 
