<?php

declare(strict_types=1);

namespace Bondeveloper\ClickatellOneAPI\Http\Models;

class Message
{
    public $to;
    public $content;
    
    public function __construct($to, $content)
    {
        $this->to = $to;
        $this->content = $content;
    }
}