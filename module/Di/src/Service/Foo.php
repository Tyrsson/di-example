<?php

declare(strict_types=1);

namespace Di\Service;

use Di\Service\FooInterface;

final class Foo implements FooInterface
{
    public function getFoo(): string
    {
        return 'foo';
    }
}
