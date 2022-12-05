<?php

namespace Clickatell\Resources\Messages;


use Clickatell\Common\HttpClient;

class Sms extends \Clickatell\Resources\Messages\Base
{
    public function __construct(HttpClient $httpClient)
    {
        parent::__construct($httpClient);
    }

    public function create(\Clickatell\Models\Messages\Base $data)
    {
        $data = json_encode($data->toSendingMessagesFormat());
        return $this->httpClient->request(HttpClient::HTTP_POST,
            $this->resourceName,  $data);
    }

}
