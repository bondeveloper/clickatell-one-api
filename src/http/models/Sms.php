<?php

declare(strict_types=1);

namespace Bondeveloper\ClickatellOneAPI\Http\Models;

use Bondeveloper\ClickatellOneAPI\Http\Models\Message;

class Sms extends Message
{
    protected $channel = 'sms';
}