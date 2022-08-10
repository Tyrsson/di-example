<?php

/**
 * The setup of the Listener and the Json strategy is not related to the Di
 * However, I thought I would include it, since I know your team is using Json heavily.
 * To test the json simplely type http(s)://<host>/application/json in your browser. and inspect the response.
 * I included a controller trait to create an example of how to use traits in controllers
 * without having the need to create controller plugins.
 */

declare(strict_types=1);

namespace Application;

use Application\View\Strategy\JsonStrategy;
use Application\Utils\Debug;
use Di\Service\Bar;
use Di\Service\Foo;
use Di\Service\MyFactoryExample;
use Di\Service\TypeExample;
use Laminas\Di\Injector;
use Laminas\Di\InjectorInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\View\View;

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
        $eventManager   = $e->getApplication()->getEventManager();
        // wire the listener, this is not related to the DI, its for another part of the example.
        $eventManager->attach(MvcEvent::EVENT_RENDER, [$this, 'registerJsonStrategy'], 100);
        /** @var Injector $injector */
        $injector = $serviceManager->get(Injector::class); // call the injector directly
        /**
         * To see where the aliases and default configuration for the Di is setup see the below classes.
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
        $barData = [
            'foo'      => 'some value for foo',
            'otherFoo' => 'some value for otherFoo',
        ];
        /**
         * The notable part of this is that TypeExample does not have a concrete factory
         * You will need to read the docs very closely in respect to what is required and the
         * in which the Di checks, and what it does based on what is found.
         */
        $typeExample = $di->create(TypeExample::class);
        $typeExample->hydrateBar($barData, $bar);
    }

    public function registerJsonStrategy(MvcEvent $e)
    {
        $container    = $e->getApplication()->getServicemanager();
        $view         = $container->get(View::class);
        $jsonStrategy = $container->get(JsonStrategy::class);
        $jsonStrategy->attach($view->getEventManager(), 100);
    }
}
