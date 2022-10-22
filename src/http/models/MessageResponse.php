<?php

declare(strict_types=1);

namespace Bondeveloper\ClickatellOneAPI\Http\Models;

class MessageResponse
{
    public $apiMessageId;
    public $accepted;
    public $to;
    
    public function __construct($apiMessageId, $accepted, $to)
    {
        $this->apiMessageId = $apiMessageId;
        $this->accepted = $accepted;
        $this->to = $to;
    }
}