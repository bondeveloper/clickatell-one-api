<?php

namespace Bondeveloper\ClickatellOneAPI\Http\Models;

class ErrorResponse extends Response
{
    public $code;
    public $description;
    
    public function __construct(int $code, string $description)
    {
        $this->code = $code;
        $this->description = $description;
    }
}