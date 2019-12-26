<?php

declare(strict_types=1);

namespace Ueef\Pharus\Interfaces;

use Iterator;

interface DispatcherInterface
{
    public function dispatch(RequestInterface &$request, ResponseInterface &$response): Iterator;
}