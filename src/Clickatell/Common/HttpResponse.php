<?php

namespace Clickatell\Common;

class HttpResponse
{
    const SUCCESS_CODES = [200, 201];

    /**
     * @var int
     */
    public $statusCode;

    public $body;

    /**
     * @var array
     */
    public $headers;

    public function __construct(int $statusCode = 200, $body = '')
    {
        $this->statusCode = $statusCode;
        $this->body = json_decode($body);
    }

    public function success()
    {
        return in_array($this->statusCode, self::SUCCESS_CODES);
    }
}