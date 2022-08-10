<?php

declare(strict_types=1);

namespace Di;

use Laminas\Di\Definition\DefinitionInterface;
use Laminas\Di\Definition\RuntimeDefinition;
use Laminas\Di\Injector as LaminasInjector;
use Psr\Container\ContainerInterface;
use RuntimeException;

use function get_class;
use function sprintf;

final class Injector extends LaminasInjector
{
    /**
     * This should probably throw an exception if the config service is not available.
     */
    public function dependencies(?string $key = null): array
    {
        if (! $this->container instanceof ContainerInterface) {
            throw new RuntimeException('This implementation will only work with an instance of Psr\Container\ContainerInterface');
        }
        if ($this->container->has('config')) {
            $target = $key ?? 'auto';
            return $this->container->get('config')[$key];
        } else {
            throw new RuntimeException('Config service is not available');
        }
    }

    public function definitions(): DefinitionInterface
    {
        return $this->definition ?? new RuntimeDefinition();
    }

    public function get(string $name)
    {
        if (! isset($this->container)) {
            throw new RuntimeException('Laminas\Di does not have a container');
        }
        if (! $this->container instanceof ContainerInterface) {
            throw new RuntimeException(
                'Container must be an instance of Psr\Container\ContainerInterface'
                . 'Received ' . sprintf(
                    '%s',
                    get_class($this->container)
                )
            );
        }
    }
}
