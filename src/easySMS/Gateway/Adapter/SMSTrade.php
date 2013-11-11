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
use easySMS\Response\Codes;

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
     * @throws \RuntimeException
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
        $query = http_build_query($params, null, '&');

        // check if curl extension is enabled
        if (!extension_loaded('curl')) {
            throw new \RuntimeException('Curl extension not loaded');
        }

        // send request via curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::URI);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        curl_setopt($ch, CURLOPT_USERAGENT, 'easySMS-php');
        $responseCode = intval(curl_exec($ch));
        curl_close($ch);

        // prepare response
        $response = new Response(
            time(),
            (100 === $responseCode) ? true : false, // if response code === 100 -> sending was successful
            $responseCode,
            $this->getResponseMessageToResponseCode($responseCode)
        );

        // return response
        return $response;
    }


    /**
     * Maps the gateway specific response codes to response messages.
     *
     * @param int $code
     *
     * @return string
     */
    protected function getResponseMessageToResponseCode($code)
    {
        switch ($code) {
            case 0:
                return Codes::ETABLISH_CONNECTION_TO_GATEWAY_FAILED;
                break;
            case 10:
                return Codes::BAD_RECIPIENT;
                break;
            case 20:
                return Codes::SENDER_IDENTIFIER_TOO_LONG;
                break;
            case 30:
                return Codes::MESSAGE_TOO_LONG;
                break;
            case 31:
                return Codes::BAD_MESSAGE_TYPE_;
                break;
            case 40:
                return Codes::BAD_SMS_TYPE;
                break;
            case 50:
                return Codes::AUTHENTICATION_FAILED;
                break;
            case 60:
                return Codes::OUT_OF_CREDIT;
                break;
            case 80:
            case 90:
                return Codes::SMS_SENDING_FAILED;
                break;
            case 100:
                return Codes::SMS_SENT_SUCCESSFULLY;
                break;
            default:
                return Codes::OTHER_ERROR;
                break;
        }
    }
} 
