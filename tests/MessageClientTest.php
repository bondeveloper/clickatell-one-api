<?php

declare(strict_types=1);

namespace Bondeveloper\ClickatellOneAPI;

use PHPUnit\Framework\TestCase;
use Bondeveloper\ClickatellOneAPI\Http\Services\MessageClient;
use Bondeveloper\ClickatellOneAPI\Http\Models\Sms;
use ReflectionClass;


class MessageClientTest extends TestCase
{
    protected $client;
    protected $reflector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new MessageClient('token');
        $this->reflector = new ReflectionClass($this->client);
    }

    public function testSendMessagesExists()
    {
        $this->assertTrue($this->reflector->hasMethod('sendSms'));
        $this->assertTrue($this->reflector->hasMethod('sendWhatsapp'));
    }

    public function testSendInvalidToken()
    {
        $res = $this->client->sendSms($this->createSms());
        $this->assertTrue(1 === $res->code);
    }

    public function testSendingMessage()
    {
        $client = new MessageClient('iuWKNhtDSk6EHHzNdjM0UA==');
        $res = $client->sendSms($this->createSms());
        $this->assertTrue($res->isSuccess());
        $this->assertObjectHasAttribute('apiMessageId', $res);
        $this->assertObjectHasAttribute('accepted', $res);
        $this->assertObjectHasAttribute('to', $res);
    }

    private function createSms()
    {
        return new Sms('27603812851', 'Message sent from unit tests @ '.time());
    }
}