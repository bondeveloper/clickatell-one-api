<?php

declare(strict_types=1);

namespace Bondeveloper\ClickatellOneApi;

use PHPUnit\Framework\TestCase;
use Bondeveloper\ClickatellOneApi\ClicktellOneApiClient;
use Bondeveloper\ClickatellOneApi\ErrorResponse;
use Reflection;
use ReflectionClass;


class ClickatellOneApiTest extends TestCase
{
    protected $client;
    protected $reflector;
    protected $payload;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new ClicktellOneApiClient('token');
        $this->reflector = new ReflectionClass($this->client);
        $this->payload = [
            new MessageRequest('sms', '27603812851', 'Clickatell test oneapi')
        ];
    }

    public function testClickatellOneApiClientInstance()
    {
        $this->assertEquals('token', $this->client->getToken());
    }

    public function testSendMessageExists()
    {
        $this->assertTrue($this->reflector->hasMethod('sendMessage'));
    }

    public function testSendMessageThrowsException()
    {
        $this->expectExceptionCode(401);
        $this->client->sendMessage(...$this->payload);
    }

    public function testSendingMessage()
    {
        $client = new ClicktellOneApiClient('working_api_token');
        $res = $client->sendMessage(...$this->payload);
        $this->assertObjectHasAttribute('messages', $res);
        $this->assertIsArray($res->messages);
        $this->assertNotEmpty($res->messages);
    }
}