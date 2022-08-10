<?php

declare(strict_types=1);

namespace Di\Service;

final class Bar
{
    /** @var string $foo */
    public $foo;
    /** @var string $otherFoo */
    public $otherFoo;
    public function getFoo(): string
    {
        return $this->foo;
    }
}
