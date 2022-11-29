<?php

namespace Test;

use Clickatell\Client;
use Clickatell\Models\Messages\Sms;
use PHPUnit\Framework\TestCase;

class MessagesTest extends TestCase
{
    /**
     * Test client send message
     */
    public function testSendSms()
    {
        $client = new Client();
        $message = new Sms('456456', 'tester');
        $client->sms->create($message);
    }

}