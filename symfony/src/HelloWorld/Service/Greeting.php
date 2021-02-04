<?php

declare(strict_types=1);

namespace App\HelloWorld\Service;

class Greeting
{
    private const GREETING = 'Hello, everyone!';
    private const GREETING_LOGGED = 'Hello, logged user!';

    public function sayHello() : string
    {
        return self::GREETING;
    }

    public function sayHelloLogged() : string
    {
        return self::GREETING_LOGGED;
    }
}
