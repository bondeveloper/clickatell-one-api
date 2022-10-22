<?php

namespace Bondeveloper\ClickatellOneAPI\Http\Models;

class ErrorResponse
{
    public $code;
    public $description;
    
    public function __construct(int $code, string $description)
    {
        $this->code = $code;
        $this->description = $description;
    }
}