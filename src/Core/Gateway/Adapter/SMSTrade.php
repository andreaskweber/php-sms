<?php

/*
 * This file is part of the andreas-weber/php-sms library.
 *
 * (c) Andreas Weber <code@andreas-weber.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AndreasWeber\SMS\Core\Gateway\Adapter;

use AndreasWeber\SMS\Core\Gateway\AdapterAbstract;
use AndreasWeber\SMS\Core\Message;
use AndreasWeber\SMS\Core\Response;
use AndreasWeber\SMS\Core\Response\Code;

class SMSTrade extends AdapterAbstract
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
    private $apiKey;

    /**
     * @var string Route
     */
    private $route;

    /**
     * __construct()
     *
     * @param string $apiKey Api key
     * @param string $route  Route to use
     *
     * @throws \InvalidArgumentException
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
     * @param Message $message Message
     * @param bool    $debug   If debug mode should be enabled
     *
     * @return \AndreasWeber\SMS\Core\Response
     * @throws \RuntimeException
     */
    public function send(Message $message, $debug = false)
    {
        // gather arguments
        $params = array(
            'key' => $this->apiKey,
            'to' => $message->getTo(),
            'message' => $message->getMessageText(),
            'route' => $this->route,
            'from' => $message->getFrom(),
            'debug' => $debug ? 1 : 0
        );

        // build request
        $query = http_build_query($params, null, '&');

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
     * Fetches all queued messages from gateway.
     *
     * @param string $number The number to fetch messages from
     *
     * @return null
     * @throws Exception
     */
    public function fetch($number)
    {
        throw new Exception('Fetching messages from SMSTrade-Gateway not supported.');
    }

    /**
     * Maps the gateway specific response codes to response messages.
     *
     * @param int $code Response code
     *
     * @return string
     */
    private function getResponseMessageToResponseCode($code)
    {
        switch ($code) {
            case 0:
                return Code::ETABLISH_CONNECTION_TO_GATEWAY_FAILED;
            case 10:
                return Code::BAD_RECIPIENT;
            case 20:
                return Code::SENDER_IDENTIFIER_TOO_LONG;
            case 30:
                return Code::MESSAGE_TOO_LONG;
            case 31:
                return Code::BAD_MESSAGE_TYPE_;
            case 40:
                return Code::BAD_SMS_TYPE;
            case 50:
                return Code::AUTHENTICATION_FAILED;
            case 60:
                return Code::OUT_OF_CREDIT;
            case 80:
            case 90:
                return Code::SMS_SENDING_FAILED;
            case 100:
                return Code::SMS_SENT_SUCCESSFULLY;
            default:
                return Code::OTHER_ERROR;
        }
    }
}
