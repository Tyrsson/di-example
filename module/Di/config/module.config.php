<?php

declare(strict_types=1);

namespace Di;

return [
    'dependencies' => [
        'auto' => [
            'preferences' => [
                Service\FooInterface::class => Service\Foo::class,
            ],
            'types'       => [
                'MyClass.A' => [
                    'typeOf'      => Service\MyClass::class,
                    'preferences' => [
                        Service\FooInterface::class => Service\SpecialFoo::class,
                    ],
                ],
                'MyClass.B' => [
                    'typeOf'      => Service\MyClass::class,
                    'preferences' => [
                        Service\FooInterface::class => Service\Bar::class,
                    ],
                ],
            ],
        ],
    ],
];
