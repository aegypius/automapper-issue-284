<?php

declare(strict_types=1);

namespace App;

abstract readonly class Fruit
{
    final public function __construct(
        public int $weight,
    ) {
    }
}
