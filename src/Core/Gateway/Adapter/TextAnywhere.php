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
use Assert\Assertion;

class TextAnywhere extends AdapterAbstract
{
    /**
     * WSDL Url
     */
    const WSDL = 'http://www.textapp.net/webservice/service.asmx?wsdl';

    /**
     * @var string The username
     */
    private $username;

    /**
     * @var string The login password
     */
    private $password;

    /**
     * @var
     */
    private $soapClient;

    /**
     * __construct()
     *
     * @param string $username The username
     * @param string $password The login password
     */
    public function __construct($username, $password)
    {
        Assertion::string($username);
        Assertion::string($password);

        $this->username = $username;
        $this->password = $password;

        $this->soapClient = new \SoapClient(self::WSDL);
    }


    /**
     * Sends a message through the gateway.
     *
     * @param Message $message Message
     * @param bool $debug If debug mode should be enabled
     *
     * @return \AndreasWeber\SMS\Core\Response
     */
    public function send(Message $message, $debug = false)
    {
        $sc = $this->soapClient;

        $params = new \stdClass();
        $params->returnCSVString = false;
        $params->externalLogin = $this->username;
        $params->password = $this->password;
        $params->originator = $message->getFrom();
        $params->destinations = $message->getTo();
        $params->body = $message->getMessageText();
        $params->validity = 48;
        $params->characterSetID = 2;
        $params->replyMethodID = 4;

        $this->setOptions($params, $message);

        if ($debug) {
            $method = 'TestSendSMS';
        } else {
            $method = 'SendSMS';
        }

        $response = $this->parseXmlResponse(
            $method,
            $sc->__call($method, array($params))
        );

        return $response;
    }

    /**
     * Parse the gateways xml response.
     *
     * @param string $method
     * @param \stdClass $response
     *
     * @return Response
     */
    private function parseXmlResponse($method, \stdClass $response)
    {
        $method = $method . 'Result';
        $xml = simplexml_load_string($response->$method);

        $time = time();
        $code = (int)$xml->Transaction->Code;
        $message = (string)$xml->Transaction->Description;
        $success = (int)$code === 1;

        $response = new Response(
            $time,
            $success,
            $code,
            $message
        );

        return $response;
    }

    /**
     * Sets options to params instance.
     *
     * @param \stdClass $params
     * @param Message $message
     *
     * @return Message
     */
    private function setOptions(\stdClass $params, Message $message)
    {
        foreach ($message->getOptions() as $property => $value) {
            $params->$property = $value;
        }

        return $message;
    }
}
