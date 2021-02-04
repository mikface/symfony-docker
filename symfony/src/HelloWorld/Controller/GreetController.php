<?php

namespace App\HelloWorld\Controller;

use App\HelloWorld\Service\Greeting;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GreetController
{
    public function __construct(private Greeting $greeting)
    {
    }

    #[Route('/hello-world/greet', name: 'hello_world.greet')]
    public function action()
    {
        return new JsonResponse(
            ['greet' => $this->greeting->sayHello()]
        );
    }
}