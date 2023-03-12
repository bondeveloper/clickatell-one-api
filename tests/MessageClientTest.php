<?php

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use Clickatell\Client;
use Clickatell\Models\Messages\Sms;
use Clickatell\SignedRequest;
use Clickatell\RequestValidator;


class MessageClientTest extends TestCase
{
    public function testSendingMessage(): void
    {
        $client = new Client('your_working_token');
        $res = $client->sms->create($this->createSms());
        $this->assertTrue($res->success());
    }

    public function testSignedRequest(): void
    {
        $username = 'signedSignature';
        $password = '234234';
        $signedRequest = SignedRequest::create($username, $password);
        $this->assertEquals($username, $signedRequest->username);
        $this->assertEquals($password, $signedRequest->password);
    }

    public function testRequestValidation()
    {
        $validator = new RequestValidator('jane', 'janedoe');
        $signedRequest = SignedRequest::create('jane', 'janedoe');
        $this->assertTrue($validator->verify($signedRequest));
    }

    private function createSms(): Sms
    {
        return new Sms('your_test_mobile', 'Base sent from unit tests @ '.time(), 'your_test_from');
    }
}
