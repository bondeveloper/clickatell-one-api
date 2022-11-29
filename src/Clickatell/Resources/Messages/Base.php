<?php

namespace Clickatell\Resources\Messages;

use Bondeveloper\ClickatellOneAPI\Http\Models\Message;
use Clickatell\Common\HttpClient;
use Clickatell\Resources\Messages\MessageInterface;

class Base implements MessageInterface
{
    protected HttpClient $httpClient;
    protected string $resourceName = 'message';

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function create(\Clickatell\Models\Messages\Base $data)
    {
        // TODO: Implement create() method.
    }
}