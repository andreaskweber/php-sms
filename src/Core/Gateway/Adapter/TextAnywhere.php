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
     * @param bool    $debug   If debug mode should be enabled
     *
     * @return Response
     */
    public function send(Message $message, $debug = false)
    {
        Assertion::boolean($debug);

        $params = $this->createParamsInstance();

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

        $result = $this->call($method, $params);
        $meta = $this->extractResponseMetaData($result);

        $response = new Response(
            time(),
            $meta['code'] === 1,
            $meta['code'],
            $meta['message']
        );

        return $response;
    }

    /**
     * Fetches all queued messages from gateway.
     *
     * @param string $number The number to fetch messages from
     *
     * @return Message[]
     * @throws Exception When fetching messages failed
     */
    public function fetch($number)
    {
        Assertion::string($number);

        $params = $this->createParamsInstance();
        $params->number = $number;

        $xml = $this->call('GetSMSInbound', $params);
        $meta = $this->extractResponseMetaData($xml);

        if ($meta['code'] === 3) {
            // no messages in queue
            return array();
        }

        if ($meta['code'] !== 1) {
            throw new Exception(
                sprintf(
                    'An error occured while fetching messages: %s - %s',
                    $meta['code'],
                    $meta['message']
                )
            );
        }

        $messages = array();
        foreach ($xml->SMSInbounds->InboundSMS as $sms) {
            $dateTime = \DateTime::createFromFormat(
                'Y-m-d H:i:s',
                (string)$sms->Date . ' ' . (string)$sms->Time
            );

            $message = new Message(
                (string)$sms->Destination,
                (string)$sms->Originator,
                (string)$sms->Body,
                array(
                    'timestamp' => $dateTime->getTimestamp()
                )
            );

            $messages[] = $message;
        }

        return $messages;
    }

    /**
     * Creates a new params instance.
     *
     * @return \stdClass
     */
    private function createParamsInstance()
    {
        $params = new \stdClass();
        $params->returnCSVString = false;
        $params->externalLogin = $this->username;
        $params->password = $this->password;

        return $params;
    }

    /**
     * Call gateway.
     *
     * @param string    $method
     * @param \stdClass $params
     *
     * @return \SimpleXMLElement
     */
    private function call($method, \stdClass $params)
    {
        $xml = $this->parseXmlResponse(
            $method,
            $this->soapClient->__call($method, array($params))
        );

        return $xml;
    }

    /**
     * Parse an xml gateway response.
     *
     * @param string    $method Method name
     * @param \stdClass $xml    Api response
     *
     * @return \SimpleXMLElement
     * @throws \RuntimeException When xml couldn't be parsed
     */
    private function parseXmlResponse($method, \stdClass $xml)
    {
        $method = $method . 'Result';
        $xml = simplexml_load_string($xml->$method);

        if (!$xml instanceof \SimpleXMLElement) {
            throw new \RuntimeException('Could not parse response xml.');
        }

        return $xml;
    }

    /**
     * Extract the response meta data from given xml api response.
     *
     * @param \SimpleXMLElement $xml
     *
     * @return array
     */
    private function extractResponseMetaData(\SimpleXMLElement $xml)
    {
        return array(
            'code' => (int)$xml->Transaction->Code,
            'message' => (string)$xml->Transaction->Description,
        );
    }

    /**
     * Sets options to params instance.
     *
     * @param \stdClass $params
     * @param Message   $message
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
