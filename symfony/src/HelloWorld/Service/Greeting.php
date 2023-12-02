<?php

declare(strict_types=1);

namespace App\HelloWorld\Service;

final readonly class Greeting
{
    private const string GREETING = 'Hello, everyone!';
    private const string GREETING_LOGGED = 'Hello, logged user!';

    public function sayHello(): string
    {
        return self::GREETING;
    }

    public function sayHelloLogged(): string
    {
        return self::GREETING_LOGGED;
    }
}
