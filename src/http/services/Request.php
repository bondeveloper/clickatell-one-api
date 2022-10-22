<?php
declare(strict_types=1);

namespace Bondeveloper\ClickatellOneAPI\Http\Services;

use Exception;

class Request
{
    protected $token;
    protected $options;
    protected $connectionTimeout;
    protected $timeout;
    protected $session;

    const ERROR_CODES = [400, 401, 402, 404, 503];

    public function __construct(string $token, $options = [])
    {
        $this->token = $token;
        $this->options = $options;
        $this->connectionTimeout = 120;
        $this->timeout = 120;
    }

    private function connect(string $endpoint)
    {
        $this->session = curl_init($endpoint);
    }

    private function disconnect()
    {
        return curl_close($this->session);
    }
    
    public function post($data, $endpoint)
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
            CURLOPT_CONNECTTIMEOUT => $this->connectionTimeout,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_RETURNTRANSFER => true
        ];

        $this->connect($endpoint);
        curl_setopt_array($this->session, ($this->options + $defaults));
        $response = json_decode(curl_exec($this->session));
        $status_code = curl_getinfo($this->session, CURLINFO_HTTP_CODE);
        $this->disconnect();
        return [
            "data"=> $response,
            "error"=> in_array($status_code, static::ERROR_CODES)
        ];
    }
}