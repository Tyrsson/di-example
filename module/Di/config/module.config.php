<?php

declare(strict_types=1);

namespace Di;

use Di\Injector;
use Di\InjectorFactory;
use Di\Service\TypeExample;
use Laminas\Di\InjectorInterface;
use Laminas\Di\Resolver\TypeInjection;

return [
    'service_manager' => [
        'aliases'   => [
            'di' => Injector::class,
        ],
        'factories' => [
            InjectorInterface::class => InjectorFactory::class,
        ],
    ],
    'dependencies'    => [
        'auto' => [
            'preferences' => [
                Service\FooInterface::class => Service\Foo::class,
            ],
            'types'       => [
                TypeExample::class => [
                    'preferences' => [],
                    'parameters'  => [
                        'hydratorPluginManager' => Service\HydratorPluginManager::class,
                        'config'                => new TypeInjection('config'), // insures no lookup is performed
                    ],
                ],
                'MyClass.A'        => [
                    'typeOf'      => Service\MyClass::class,
                    'preferences' => [
                        Service\FooInterface::class => Service\SpecialFoo::class,
                    ],
                ],
                'MyClass.B'        => [
                    'typeOf'      => Service\MyClass::class,
                    'preferences' => [
                        Service\FooInterface::class => Service\Bar::class,
                    ],
                ],
            ],
        ],
    ],
];
