<?php

declare(strict_types=1);

namespace Ueef\Pharus\Interfaces;

use Iterator;

interface HandlerInterface
{
    public function handle(RequestInterface &$request, ResponseInterface &$response): Iterator;
}