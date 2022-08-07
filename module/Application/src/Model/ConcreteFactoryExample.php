<?php

declare(strict_types=1);

namespace Application\Model;

use Di\Service\SpecialFoo;

final class ConcreteFactoryExample
{
    /** @var SpecialFoo $specialFoo */
    public $specialFoo;
    /** @return void */
    public function __construct(SpecialFoo $specialFoo, ?array $config = null)
    {
        $this->config     = $config;
        $this->specialFoo = $specialFoo;
    }
}
