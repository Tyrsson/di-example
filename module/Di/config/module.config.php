<?php

declare(strict_types=1);

namespace Di;

use Di\Service\TypeExample;

return [
    'dependencies' => [
        'auto' => [
            'preferences' => [
                Service\FooInterface::class => Service\Foo::class,
            ],
            'types'       => [
                TypeExample::class => [
                    'preferences' => [],
                    'parameters'  => [
                        'hydratorPluginManager' => Service\HydratorPluginManager::class,
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
