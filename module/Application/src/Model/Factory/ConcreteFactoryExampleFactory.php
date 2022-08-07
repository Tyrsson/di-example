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
         * This is also to exemplify the duplication that is occurring in your application since we have to call the
         * Di from the service manager. The only benefit is being able to map preferences of objects
         * and their creation context. Honestly, I can not think of a use case for this. Not saying
         * that there's not one, I just cant think of one. I could just as easily map the service
         * MyClass.A as an alias in the service manager and just call it that way.
         * Since the keys have to be in string form, which I try my best to avoid.
         */
        return new $requestedName(
            $container->get(Injector::class)->create('MyClass.A')->foo, // create the class using the injector.
            $container->get('config')['dependencies'] // so that you can see the config.
        );
    }
}
