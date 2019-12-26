<?php

declare(strict_types=1);

namespace Ueef\Pharus;

use Exception;
use Iterator;
use Throwable;
use Ueef\Pharus\Interfaces\DispatcherInterface;
use Ueef\Pharus\Interfaces\HandlerInterface;
use Ueef\Pharus\Interfaces\RequestInterface;
use Ueef\Pharus\Interfaces\ResponseInterface;
use Ueef\Pheseus\Interfaces\RouteInterface;

class Dispatcher implements DispatcherInterface
{
    /** @var RouteInterface[] */
    private array $routes;

    /** @var HandlerInterface[][] */
    private array $handlers;


    public function __construct(array $binds = [])
    {
        foreach ($binds as $bind) {
            $this->bind(...$bind);
        }
    }

    public function bind(RouteInterface $route, HandlerInterface ...$handlers): void
    {
        $this->routes[] = $route;
        $this->handlers[] = array_reverse($handlers);
    }

    public function dispatch(RequestInterface &$request, ResponseInterface &$response): Iterator
    {
        foreach ($this->routes as $index => $route) {
            $args = $route->match($request->getPath());
            if (null === $args) {
                continue;
            }

            $request->setPathArgs($args);
            foreach ($this->handlers[$index] as $handler) {
                try {
                    yield from $handler->handle($request, $response);
                } catch (Throwable $e) {
                    $response->registerUncaughtException($e);
                }
            }

            return;
        }

        throw new Exception();
    }
}