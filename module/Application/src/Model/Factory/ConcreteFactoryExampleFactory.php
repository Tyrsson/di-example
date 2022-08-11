<?php

declare(strict_types=1);

namespace Application\Model\Factory;

use Application\Model\ConcreteFactoryExample;
use Laminas\Di\Injector;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

final class ConcreteFactoryExampleFactory implements FactoryInterface
{
    /** @inheritDoc */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        ?array $options = null
    ): ConcreteFactoryExample {
        /**
         * Say you have a use case where you need to pull a service from the container,
         * but it depends on a service only available via the Di configuration? This is
         * how you accomplish that.
         * $requestedName is the name of the class we are creating. that will be pulled from the service manager.
         * The caveat is that once this happens, it will also be available via the DI since it has access to the
         * service manager.
         */
        return new $requestedName(
            // important to note that if MyClass.A is not defined the factory will fail, Exception is thrown
            $container->get(Injector::class)->create('MyClass.A')->foo, // create the class using the injector.
            $container->get('config')['dependencies'] // so that you can see the config.
        );
    }
}
