<?php

declare(strict_types=1);

namespace Di\Service;

final class SpecialFoo implements FooInterface
{
    public function getFoo(): string
    {
        return 'special_foo';
    }
}
