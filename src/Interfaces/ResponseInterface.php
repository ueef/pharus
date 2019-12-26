<?php

declare(strict_types=1);

namespace Ueef\Pharus\Interfaces;

use Throwable;

interface ResponseInterface
{
    public function registerUncaughtException(Throwable $exception): void;
}