<?php

declare(strict_types=1);

namespace Ueef\Pharus\Interfaces;

interface RequestInterface
{
    public function getPath(): string;

    public function setPathArgs(array $args): void;
}