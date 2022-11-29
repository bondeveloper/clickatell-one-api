<?php

namespace Clickatell\Models\Messages;

class Base
{
    public string $to;
    public string $content;
    public function __construct(string $to, string $content)
    {
        $this->to = $to;
        $this->content = $content;
    }

    public function toSendingMessagesFormat()
    {
        return ['messages' => [$this]];
    }
}