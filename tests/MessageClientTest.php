<?php

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use Clickatell\Client;
use Clickatell\Models\Messages\Sms;


class MessageClientTest extends TestCase
{
    public function testSendingMessage(): void
    {
        $client = new Client('your_working_token');
        $res = $client->sms->create($this->createSms());
        $this->assertTrue($res->success());
    }

    private function createSms(): Sms
    {
        return new Sms('your_test_mobile', 'Base sent from unit tests @ '.time(), 'your_test_from');
    }
}