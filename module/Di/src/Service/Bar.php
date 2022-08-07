<?php

declare(strict_types=1);

namespace Di\Service;

final class Bar
{
    public function getFoo(): string
    {
        return 'bar';
    }
}
