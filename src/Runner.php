<?php

declare(strict_types=1);

namespace Ueef\Pharus;

use Iterator;
use Ueef\Pharus\Interfaces\RunnerInterface;

class Runner implements RunnerInterface
{
    /** @var Iterator[] */
    private array $iterators;


    public function __construct(Iterator ...$iterators)
    {
        $this->iterators = $iterators;
    }

    public function add(Iterator $iterator): void
    {
        $this->iterators[] = $iterator;
    }

    public function run(float $timeout = 0): void
    {
        if ($timeout > 0) {
            $timeout = microtime(true) + $timeout;
        }

        while ($this->iterators && (0 == $timeout || $timeout > microtime(true))) {
            $this->step();
        }
    }

    public function step(): void
    {
        if (!$this->iterators) {
            return;
        }

        $iterator = current($this->iterators);
        $key = key($this->iterators);
        if (false === $iterator) {
            $iterator = reset($this->iterators);
        }

        if (!$iterator->valid()) {
            $iterator->next();
        }

        if (!$iterator->valid()) {
            unset($this->iterators[$key]);
        }
    }
}