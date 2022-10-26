<?php

namespace Clickatell\Http;

class Client
{
    protected $token;
    protected $options;
    protected $connectionTimeout;
    protected $timeout;
    protected $session;
    protected $headers;


    public function __construct(string $token, $options = [])
    {
        $this->token = $token;
        $this->options = $options;

        $this->headers = [
            'Accept: application/json',
            'Authorization: '.$this->token,
            'Content-Type: application/json',
        ];
        $this->timeout = 120;
        $this->connectionTimeout = 120;
    }

    public function setTimeout(int $timeout): void
    {
        $this->timeout = $timeout;
    }

    public function setConnectionTimeout(int $connectionTimeout): void
    {
        $this->connectionTimeout = $connectionTimeout;
    }

    public function setHeaders(array $headers): void
    {
        array_merge($this->headers, $headers);
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function get(string $endpoint)
    {
        return $this->request($endpoint);
    }

    public function post(string $endpoint, string $data)
    {
        return $this->request($endpoint, 'post', $data);
    }

    public function request($endpoint, $type='get', $data=null)
    {
        switch($type)
        {
            case 'post':
                $options = [
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $data,
                ];
                break;
            default:
                $options = [];
        }

        $defaults = array_merge([
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => $this->headers,
            CURLOPT_CONNECTTIMEOUT => $this->connectionTimeout,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_RETURNTRANSFER => true
        ], $options);

        $this->connect($endpoint);
        curl_setopt_array($this->session, ($this->options + $defaults));
        $response = json_decode(curl_exec($this->session));
        $statusCode = curl_getinfo($this->session, CURLINFO_HTTP_CODE);
        $this->disconnect();
        return new Response($statusCode, $response);
    }


    private function connect(string $endpoint)
    {
        $this->session = curl_init($endpoint);
    }

    private function disconnect()
    {
        return curl_close($this->session);
    }
}