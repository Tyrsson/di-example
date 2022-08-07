<?php

declare(strict_types=1);

namespace Application;

use Di\Service\Bar;
use Di\Service\Foo;
use Di\Service\MyFactoryExample;
use Laminas\Di\Injector;
use Laminas\Di\InjectorInterface;
use Laminas\Mvc\MvcEvent;

class Module
{
    public function getConfig(): array
    {
        /** return array */
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        // get an instance of the service manager
        $serviceManager = $e->getApplication()->getServiceManager();
        /** @var Injector $injector */
        $injector = $serviceManager->get(Injector::class); // call the injector directly
        /**
         * /vendor/laminas/laminas-di/src/Module.php
         * /vendor/laminas/laminas-di/src/ConfigProvider.php
         *
         * @var InjectorInterface $injectorInterface
         */
        $injectorInterface = $serviceManager->get(InjectorInterface::class); // call the injector by its alias
        // the Di is the injector
        $di               = $injector; // this is really useless, but its just to show they are the same
        $bar              = $di->create(Bar::class); // get an instance of Bar
        $foo              = $di->create(Foo::class); // get an instance of Foo
        $myclassA         = $di->create('MyClass.A'); // get an instance of MyClass.A
        $myclassB         = $di->create('MyClass.B'); // get an instance of MyClass.B
        $myFactoryExample = $di->create(MyFactoryExample::class); // this works because the Di autowire factory jumped in to autowire it.
        //$myFactoryExample = $di->create('MyFactoryExample'); // This will fail because its not in the config
        //var_dump($di); this works on my system, but due to the vast amount of data youre not gonna learn much from it
    }
}
