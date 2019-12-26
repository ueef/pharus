<?php

declare(strict_types=1);

namespace Ueef\Pharus\Handlers;

use Iterator;
use Ueef\Pharus\Interfaces\HandlerInterface;
use Ueef\Pharus\Interfaces\RequestInterface;
use Ueef\Pharus\Interfaces\ResponseInterface;

class CallHandler implements HandlerInterface
{
    /** @var callable */
    private $callable;


    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    public function handle(RequestInterface &$request, ResponseInterface &$response): Iterator
    {
        $result = call_user_func($this->callable, $request, $response);
        if ($result instanceof Iterator) {
            yield from $result;
        }
    }
}