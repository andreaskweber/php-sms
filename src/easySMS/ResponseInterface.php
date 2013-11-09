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


interface ResponseInterface
{
    /**
     * Returns the sending tstamp.
     *
     * @return int
     */
    public function getTstamp();


    /**
     * Returns if the sending was successful.
     *
     * @return bool
     */
    public function wasSuccessful();


    /**
     * Returns the gateway response code.
     *
     * @return mixed
     */
    public function getResponseCode();


    /**
     * Returns the gateway response message.
     *
     * @return mixed
     */
    public function getResponseMessage();


} 
