<?php

namespace Clickatell\Http;

class Response
{
    const SUCCESS_CODES = [200, 201];

    protected $isSuccess;

    /**
     * @var int
     */
    public $statusCode;

    public $content;

    /**
     * @var array
     */
    public $headers;

    public function __construct(int $statusCode, $content, array $headers)
    {
        $this->statusCode = $statusCode;
        $this->content = $content;
        $this->headers = $headers;
    }

    public function isSuccess()
    {
        return in_array($this->statusCode, self::SUCCESS_CODES);
    }
}