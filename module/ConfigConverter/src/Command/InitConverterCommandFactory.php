<?php

declare(strict_types=1);

namespace ConfigConverter\Command;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class InitConverterCommandFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new $requestedName();
    }
}
