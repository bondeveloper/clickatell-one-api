<?php

declare(strict_types=1);

namespace Bondeveloper\ClickatellOneApi;

class ErrorResponse
{
    public $code;
    public $description;
    
    public function __construct($code, $description)
    {
        $this->code = $code;
        $this->description = $description;
    }
}