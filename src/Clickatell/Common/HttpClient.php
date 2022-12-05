<?php

namespace Clickatell\Common;

use Clickatell\Exceptions\AuthenticationException;
use Clickatell\Exceptions\HTTPException;

class HttpClient
{
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';

    protected string $endpoint;
    protected array $headers;
    protected int $timeout;
    protected int $connectionTimeout;
    protected array $options = [];
    protected ?Authentication $authentication;

    public function __construct(string $endpoint, $timeout = 30, $connectionTimeout = 60, array $headers = [])
    {
        if (!is_string($endpoint) || empty($endpoint)) {
            throw new InvalidArgumentException('Endpoint must be a string and not empty.');
        }

        if ($timeout < 1 || !is_int($timeout)) {
            throw new InvalidArgumentException('Timeout must be > 1 and an integer.');
        }

        if ($connectionTimeout < 0 || !is_int($connectionTimeout)) {
            throw new InvalidArgumentException('Connection timeout must be > 1 and an integer.');
        }

        if (!is_array($headers)) {
            throw new InvalidArgumentException('Header must be an array.');
        }

        $this->endpoint = $endpoint;
        $this->headers = $headers;
        $this->timeout = $timeout;
        $this->connectionTimeout = $connectionTimeout;
    }


    /**
     * Get endpoint
     */
    public function getEndpoint(): string
    {
        return $this->endpoint;
    }


    /**
     * Set endpoint
     */
    public function setEndpoint($endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Get timeout
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * Set timeout
     */
    public function setTimeout($timeout): void
    {
        $this->timeout = $timeout;
    }

    /**
     * Get connection timeout
     */
    public function getConnectionTimeout(): int
    {
        return $this->connectionTimeout;
    }

    /**
     * Set connection timeout
     */
    public function setConnectionTimeout($connectionTimeout)
    {
        $this->connectionTimeout = $connectionTimeout;
    }

    /**
     * Get headers
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Set headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * Add option
     */
    public function addOption(string $option, $value): void
    {
        $this->options[$option] = $value;
    }

    /**
     * Get options
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Set authentication
     */
    public function setAuthentication(Authentication $authentication): void
    {
        $this->authentication = $authentication;
    }

    /**
     * Get authentication
     */
    public function getAuthentication()
    {
        return $this->authentication;
    }

    /**
     * Request URL
     */
    public function getRequestUrl(string $resourceName): string
    {
        return $this->endpoint.'/'.$resourceName;
    }

    /**
     * send request
     * @throws AuthenticationException|HTTPException
     */
    public function request(string $method, string $resourceName, ?string $body = null): ?HttpResponse
    {
        $curl = curl_init();

        if (is_null($this->authentication)) {
            throw new AuthenticationException('API request needs to be authenticated');
        }

        $headers = [
            'Accept: application/json',
            'Authorization: '.$this->authentication->accessKey,
            'Content-Type: application/json',
        ];
        var_dump($body);

        if(!empty($this->headers)) {
            $headers = array_merge($headers, $this->headers);
        }

        curl_setopt($curl, \CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, \CURLOPT_HEADER, false);
        curl_setopt($curl, \CURLOPT_URL, $this->getRequestUrl($resourceName));
        curl_setopt($curl, \CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, \CURLOPT_CONNECTTIMEOUT, $this->connectionTimeout);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt_array($curl, $this->options);

        switch($method) {
            case self::HTTP_GET:
                curl_setopt($curl, \CURLOPT_HTTPGET, true);
                break;
            case self::HTTP_POST:
                curl_setopt($curl, \CURLOPT_POST, true);
                curl_setopt($curl, \CURLOPT_POSTFIELDS, $body);
                break;
            default:
                throw new HTTPException('Unknown request method');
        }

        $response = curl_exec($curl);

        if ($response === false) {
            throw new HTTPException(curl_error($curl), curl_errno($curl));
        }
        $statusCode = (int)curl_getinfo($curl, \CURLINFO_HTTP_CODE);

        curl_close($curl);
        return new HttpResponse($statusCode, $response);
    }
}
