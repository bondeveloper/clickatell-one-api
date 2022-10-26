<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Clickatell\Http\Client;
use Clickatell\Http\Response;


class HttpClientTest extends TestCase
{
    public function testResponse()
    {
        $stub = $this->createStub(Response::class);
        $stub->method('isSuccess')->willReturn(true);
    }

    public function testSetHeaders()
    {
        $this->mockClient('setHeaders')
            ->once()
            ->with(['accept' => 'application/json']);
    }


    public function testGetHeaders()
    {
        $method = 'getHeaders';
        $mock = $this->mockClient($method);

        $mock->expects($this->once())
            ->method($method)
            ->willReturn(['accept' => 'application/json']);
    }

    public function testSetTimeout()
    {
        $this->mockClient('setTimeout')
            ->with(120)
            ->once();
    }

    public function testSetConnectionTimeout()
    {
        $this->mockClient('setConnectionTimeout')
            ->with(120)
            ->once();
    }

    private function mockClient($method)
    {
        return $this->getMockBuilder(Client::class)
            ->addMethods([$method])
            ->getMock();
    }

    public function testPost()
    {
        $this->mockClient('post')
            ->with('some_endpoint', 'some_json_encoded_data')
            ->once()
            ->willReturn(Response::class);
    }

    public function testGet()
    {
        $this->mockClient('get')
            ->with('some_endpoint')
            ->once()
            ->willReturn(Response::class);
    }
}