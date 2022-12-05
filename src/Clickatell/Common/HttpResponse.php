<?php

namespace Clickatell\Common;

class HttpResponse
{
    const SUCCESS_CODES = [202, 207];
    public int $code;
    public object $data;


    public function __construct(int $statusCode, $data)
    {
        $this->code = $statusCode;
        $this->data = json_decode($data);
    }

    public function success()
    {
        return in_array($this->code, self::SUCCESS_CODES);
    }
}
