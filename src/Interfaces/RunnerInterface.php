<?php

declare(strict_types=1);

namespace Ueef\Pharus\Interfaces;

interface RunnerInterface
{
    public function run(float $timeout = 0): void;
    public function step(): void;
}