<?php

namespace Clickatell\Common;

final class Authentication
{
    public string $accessKey;

    public function __construct(string $accessKey = '')
    {
        $this->accessKey = $accessKey;
    }
}
