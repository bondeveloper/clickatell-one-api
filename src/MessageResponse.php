<?php

declare(strict_types=1);

namespace Bondeveloper\ClickatellOneApi;

class MessageResponse
{
    public $apiMessageId;
    public $accepted;
    public $to;
    public $error;
    
    public function __construct($apiMessageId, $accepted, $to, ErrorResponse $error)
    {
        $this->apiMessageId = $apiMessageId;
        $this->accepted = $accepted;
        $this->to = $to;
        $this->error = $error;
    }
}