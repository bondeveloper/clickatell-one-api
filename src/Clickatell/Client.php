<?php

namespace Clickatell;

use Clickatell\Common\Authentication;
use Clickatell\Common\HttpClient;
use Clickatell\Resources\Messages\Sms;

class Client
{
    const ENDPOINT = 'https://platform.clickatell.com/v1';

    protected HttpClient $httpClient;

    public $sms;

    public function __construct(?string $accessKey = null, HttpClient $client = null)
    {
        if (is_null($client)) {
            $this->httpClient = new HttpClient(self::ENDPOINT);
        } else {
            $this->httpClient = $client;
        }

        if (!is_null($accessKey)) {
            $this->httpClient->setAuthentication(new Authentication($accessKey));
        }

        $this->sms = new Sms($this->httpClient);
    }
}
