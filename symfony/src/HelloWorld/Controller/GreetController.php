<?php

declare(strict_types=1);

namespace App\HelloWorld\Controller;

use App\HelloWorld\Service\Greeting;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final readonly class GreetController
{
    public function __construct(private Greeting $greeting)
    {
    }

    #[Route('/hello-world/greet', name: 'hello_world.greet')]
    public function action(): JsonResponse
    {
        return new JsonResponse(
            ['greet' => $this->greeting->sayHello()],
        );
    }
}
