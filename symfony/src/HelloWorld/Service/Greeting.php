<?php

declare(strict_types=1);

namespace App\HelloWorld\Service;

final readonly class Greeting
{
    private const string Greeting = 'Hello, everyone!';
    private const string GreetingLogged = 'Hello, logged user!';

    public function sayHello(): string
    {
        return self::Greeting;
    }

    public function sayHelloLogged(): string
    {
        return self::GreetingLogged;
    }
}
