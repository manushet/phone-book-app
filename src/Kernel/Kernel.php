<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Router\Router;
use App\Kernel\Services;
use App\Http\Request\Request;
use App\Http\Response\Response;
use App\Exceptions\HttpException;

class Kernel
{

    private Request $request;

    private Response $response;

    public function __construct(
        private Router $router,
        private Services $services
    ) {
    }

    public function run()
    {
        $this->router->registerRoutes();

        $this->services->registerServices();

        $this->handleRequest();
    }

    public function handleRequest(): Response
    {
        try {
            $this->request = Request::createFromGlobals();

            [$controller, $action] = $this->resolveControllerHandler();

            if (isset($controller) && isset($action)) {
                $response = $controller->$action($this->request);

                return $response;
            }

            return new Response('Failed to resolve the route handler', 404);
        } catch (HttpException $e) {
            return $this->createExceptionResponse($e);
        }
    }

    private function resolveControllerHandler(): ?array
    {
        [$controllerClass, $action] = $this->router->dispatch($this->request);

        if (isset($controllerClass) && isset($action)) {
            $controller = $this->services->load($controllerClass);

            return [$controller, $action];
        }

        return null;
    }

    private function createExceptionResponse(\Exception $e): Response
    {
        if ($e instanceof HttpException) {
            return new Response($e->getMessage(), $e->getStatusCode());
        }

        return new Response('An unexpected server error occured', 500);
    }
}