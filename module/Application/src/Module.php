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
use Di\Injector;
use Di\Service\Bar;
use Di\Service\Foo;
use Di\Service\MyFactoryExample;
use Di\Service\TypeExample;
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
        /**
         * This is now a custom implementation of the Injector.
         * It extends the Di\Injector class and provides some of the
         * methods that were removed in version 3 of the Injector.
         *
         * See the Di\config\module.config.php for the override setup
         * that facilitates the use of this class.
         *
         * @var Injector $injector */
        $injector = $serviceManager->get(Injector::class); // call the injector directly
        /**
         * This is equivalent to calling the injector directly. as done above.
         * This works because of the alias in the Di\config\module.config.php
         */
        $di      = $serviceManager->get('di');
        $areSame = false;
        if ($di === $injector) {
            $areSame = true; // This is true because both are called from the same service manager.
        }
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
        $definitions = $di->definitions(); // get the definitions
    }

    public function registerJsonStrategy(MvcEvent $e)
    {
        $container    = $e->getApplication()->getServicemanager();
        $view         = $container->get(View::class);
        $jsonStrategy = $container->get(JsonStrategy::class);
        $jsonStrategy->attach($view->getEventManager(), 100);
    }
}
