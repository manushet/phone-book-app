<?php

declare(strict_types=1);

namespace App\Kernel;

use Exception;
use Throwable;
use App\Router\Router;
use App\Kernel\Services;
use App\Http\Request\Request;
use App\Exceptions\HttpException;
use App\Http\Response\JsonResponse;

class Kernel
{
    private Request $request;

    public function __construct(
        private Router $router,
        private Services $services
    ) {
    }

    public function run()
    {
        $this->router->registerRoutes();

        $this->services->registerServices();

        return $this->handleRequest();
    }

    public function handleRequest(): JsonResponse
    {
        try {
            $this->request = Request::createFromGlobals();

            [$controller, $action] = $this->resolveControllerHandler();

            if (isset($controller) && isset($action)) {
                $response = $controller->$action($this->request);

                return $response;
            }

            return new JsonResponse('Failed to resolve the route handler', 404);
        } catch (HttpException $e) {
            return $this->createExceptionResponse($e);
        } catch (Exception $e) {
            return $this->createExceptionResponse($e);
        } catch (Throwable $e) {
            return new JsonResponse("An unexpected server error occured", 500);
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

    private function createExceptionResponse(Exception $e): JsonResponse
    {
        if ($e instanceof HttpException) {
            return new JsonResponse($e->getMessage(), $e->getStatusCode());
        }

        return new JsonResponse('An unexpected server error occured', 500);
    }
}