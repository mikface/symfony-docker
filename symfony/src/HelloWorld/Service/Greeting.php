<?php


namespace App\HelloWorld\Service;


class Greeting
{
    private const GREETING = 'Hello, everyone!';
    private const GREETING_LOGGED = 'Hello, logged user!';

    public function sayHello()
    {
        return self::GREETING;
    }

    public function sayHelloLogged()
    {
        return self::GREETING_LOGGED;
    }
}