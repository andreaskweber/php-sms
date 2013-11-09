<?php

/*
 * This file is part of the easySMS library.
 *
 * (c) Andreas Weber <weber@webmanufaktur-weber.de>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace easySMS\Gateway\Adapter;


use easySMS\Gateway\AdapterAbstract;
use easySMS\MessageInterface;
use easySMS\Response;

class SMSTrade
    extends AdapterAbstract
{
    /**
     * Routes
     */
    const ROUTE_BASIC = 'basic';
    const ROUTE_GOLD = 'gold';
    const ROUTE_DIRECT = 'direct';

    /**
     * Additional constants
     */
    const URI = 'http://gateway.smstrade.de';

    /**
     * @var string API-Key
     */
    protected $apiKey;

    /**
     * @var string Route
     */
    protected $route;


    /**
     * __construct()
     *
     * @param string $apiKey
     * @param string $route
     *
     * @throws \InvalidArgumentException()
     */
    public function __construct($apiKey, $route = self::ROUTE_GOLD)
    {
        if (!is_string($apiKey) || !is_string($route)) {
            throw new \InvalidArgumentException();
        }

        $this->apiKey = $apiKey;
        $this->route = $route;
    }


    /**
     * Sends a message through the gateway.
     *
     * @param MessageInterface $message
     * @param bool             $debug If debug mode should be enabled
     *
     * @return \easySMS\ResponseInterface
     */
    public function send(MessageInterface $message, $debug = false)
    {
        // gather arguments
        $params = array(
            'key'     => $this->apiKey,
            'to'      => $message->getTo(),
            'message' => $message->getMessageText(),
            'route'   => $this->route,
            'from'    => $message->getFrom(),
            'debug'   => $debug ? 1 : 0
        );

        // build request
        $request = '';
        foreach ($params as $key => $value) {
            $request .= $key . "=" . urlencode($value);
            $request .= "&";
        }

        // send request via curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::URI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        $responseCode = intval(curl_exec($ch));
        curl_close($ch);

        // prepare response
        $response = new Response(
            time(),
            (100 === $responseCode) ? true : false, // if response code === 100 -> sending was successful
            $responseCode,
            null // Todo: Mapping response codes <-> defined constants
        );

        // return response
        return $response;
    }

} 
