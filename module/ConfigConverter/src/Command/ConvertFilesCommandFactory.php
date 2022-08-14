<?php

declare(strict_types=1);

namespace ConfigConverter;

use ConfigConverter\Command\ConvertFilesCommand;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ConvertFilesCommandFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): ConvertFilesCommand
    {
        return new $requestedName();
    }
}
