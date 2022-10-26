<?php

declare(strict_types=1);

namespace Test;

use PHPUnit\Framework\TestCase;
use Clickatell\Exceptions\AuthenticationException;
use Clickatell\Exceptions\ClickatellException;

class ExceptionsTest extends TestCase
{
    public function testClickatellException()
    {
        $this->expectException(ClickatellException::class);
        throw new ClickatellException();
    }

    public function testAuthenticationException()
    {
        $this->expectException(AuthenticationException::class);
        throw new AuthenticationException();
    }
}