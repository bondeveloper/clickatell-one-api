<?php

declare(strict_types=1);

namespace Bondeveloper\ClickatellOneAPI\Http\Services;

use Bondeveloper\ClickatellOneAPI\Http\Models\Sms;
use Bondeveloper\ClickatellOneAPI\Http\Models\Whatsapp;
use Bondeveloper\ClickatellOneAPI\Http\Services\Request;
use Bondeveloper\ClickatellOneAPI\Http\Models\ErrorResponse;
use Bondeveloper\ClickatellOneAPI\Http\Models\MessageResponse;
use Exception;

class MessageClient 
{
    protected $request;
    const BASE_URL = 'https://platform.clickatell.com/v1/';

    public function __construct(string $token)
    {
        $this->request = new Request($token);
    }

    public function sendSms(Sms $data)
    {
        return $this->sendMessage($data);
    }

    public function sendWhatsApp(Whatsapp $data)
    {
        return $this->sendMessage($data);
    }

    public function errorResponse($response): ErrorResponse
    {
        return new ErrorResponse($response->error->code, $response->error->description);
    }

    private function sendMessage($data)
    {
        $response = $this->send(json_encode(['messages'=>[$data]]), 'message');
        $data = isset($response['data']) ? $response['data'] : null;
        if (isset($response['error']) && $response['error']) {
            return $this->errorResponse($data); 
        }
        $data = $data->messages[0];
        return new MessageResponse($data->apiMessageId, $data->accepted, $data->to);
    }

    private function send(string $data, $endpoint)
    {
        return $this->request->post($data, self::BASE_URL.$endpoint);
    }
}