<?php

namespace Bondeveloper\ClickatellOneAPI\Http\Models;

class Response
{
    public $isSuccess;
    
    public function setIsSuccess($isSuccess)
    {
        $this->isSuccess = $isSuccess;
    }

    public function isSuccess()
    {
        return $this->isSuccess;
    }
}