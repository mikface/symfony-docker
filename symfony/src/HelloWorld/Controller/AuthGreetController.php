<?php

declare(strict_types=1);

namespace App\HelloWorld\Controller;

use App\HelloWorld\Service\Greeting;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AuthGreetController
{
    public function __construct(private Greeting $greeting)
    {
    }

    #[Route('/auth/hello-world/greet', name: 'auth.hello_world.greet')]
    public function action() : JsonResponse
    {
        return new JsonResponse(
            ['greet' => $this->greeting->sayHelloLogged()]
        );
    }
}
