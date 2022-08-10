<?php

declare(strict_types=1);

namespace Di;

use Laminas\Di\Injector;
use Laminas\Di\Container\InjectorFactory as LaminasDiInjectorFactory;
use Laminas\Di\InjectorInterface;
use Laminas\Di\ConfigInterface;
use Psr\Container\ContainerInterface;
use Zend\Di\ConfigInterface as LegacyConfigInterace;

class InjectorFactory extends LaminasDiInjectorFactory
{
    /**
     * {@inheritDoc}
     */
    public function create(ContainerInterface $container): InjectorInterface
    {
        return new Injector($container->get(ConfigInterface::class), $container);
    }

    /**
     * Make the instance invokable
     */
    public function __invoke(ContainerInterface $container): InjectorInterface
    {
        return $this->create($container);
    }
}