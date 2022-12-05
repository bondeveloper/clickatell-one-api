<?php

namespace Clickatell\Models\Messages;

class Base
{
    public string $to;
    public string $content;
    public string $from;
    public function __construct(string $to, string $content, string $from)
    {
        $this->to = $to;
        $this->content = $content;
        $this->from = $from;
    }

    public function toSendingMessagesFormat()
    {
        return ['messages' => [$this]];
    }
}