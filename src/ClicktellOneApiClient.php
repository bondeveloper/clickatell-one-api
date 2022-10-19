<?php
declare(strict_types=1);

namespace Bondeveloper\ClickatellOneApi;

use Exception;

class ClicktellOneApiClient
{
    protected $token;
    protected $base_url = 'https://platform.clickatell.com/v1';
    const ERROR_CODES = [400, 401, 402, 404, 503];

    public function __construct(String $token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function sendMessage(MessageRequest ...$messages)
    {
        try {
            return $this->post(json_encode(['messages'=>$messages]), $this->base_url.'/message');
        }catch(Exception $err) {
            throw new Exception($err->getMessage(), $err->getCode());
        }
    }

    private function post(string $data, string $endpoint, array $options = [])
    {
        $headers = [
            'Accept: application/json',
            'Authorization: '.$this->token,
            'Content-Type: application/json',
        ];

        $defaults = [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT => 120,
            CURLOPT_RETURNTRANSFER => true
        ];

        $session = curl_init($endpoint);
        curl_setopt_array($session, ($options + $defaults));
        $response = json_decode(curl_exec($session));
        $status_code = curl_getinfo($session, CURLINFO_HTTP_CODE);
        curl_close($session);
        if (in_array($status_code, static::ERROR_CODES))
        {
            throw new Exception($response->error->description, $status_code);
        }
        return $response;
    }
}