<?php

declare(strict_types=1);

namespace Bondeveloper\ClickatellOneApi;

class MessageRequest
{
    public $channel;
    public $to;
    public $content;
    
    public function __construct($channel, $to, $content)
    {
        $this->channel = $channel;
        $this->to = $to;
        $this->content = $content;
    }
}