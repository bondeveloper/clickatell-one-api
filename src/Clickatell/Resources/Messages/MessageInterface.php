<?php

namespace Clickatell\Resources\Messages;

interface MessageInterface
{
    public function create(\Clickatell\Models\Messages\Base $data);

}