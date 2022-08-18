<?php

declare(strict_types=1);

namespace Di;

use Di\Injector;
use Di\InjectorFactory;
use Di\Service\TypeExample;
use Laminas\Db\Adapter\Adapter;
use Laminas\Db\Adapter\Driver\Mysqli\Connection;
use Laminas\Db\Adapter\Driver\Mysqli\Mysqli;
use Laminas\Di\InjectorInterface;
use Laminas\Di\Resolver\TypeInjection;
use Laminas\Session\SaveHandler\Cache;
use Laminas\Session\SessionManager;
use Laminas\Session\Storage\SessionArrayStorage;

return [
    'service_manager' => [
        'aliases'   => [
            'di' => Injector::class,
        ],
        'factories' => [
            InjectorInterface::class => InjectorFactory::class,
        ],
    ],
    'session_config'  => [],
    'session_storage'    => [
        'type' => SessionArrayStorage::class,
    ],
    'dependencies'    => [
        'auto' => [
            'preferences' => [
                Service\FooInterface::class => Service\Foo::class,
            ],
            'types'       => [
                TypeExample::class            => [
                    'preferences' => [],
                    'parameters'  => [
                        'hydratorPluginManager' => Service\HydratorPluginManager::class,
                        'config'                => new TypeInjection('config'), // insures no lookup is performed
                    ],
                ],
                'MyClass.A'                   => [
                    'typeOf'      => Service\MyClass::class,
                    'preferences' => [
                        Service\FooInterface::class => Service\SpecialFoo::class,
                    ],
                ],
                'MyClass.B'                   => [
                    'typeOf'      => Service\MyClass::class,
                    'preferences' => [
                        Service\FooInterface::class => Service\Bar::class,
                    ],
                ],
                'db_adapter'                  => [
                    'typeOf'     => Adapter::class,
                    'parameters' => [
                        'driver' => 'db_driver',
                    ],
                ],
                'db_driver'                   => [
                    'typeOf'     => Mysqli::class,
                    'parameters' => [
                        'connection' => 'db_connection',
                        'options'    => [
                            'buffer_results' => true,
                        ],
                    ],
                ],
                'db_connection'               => [
                    'typeOf'     => Connection::class,
                    'parameters' => [
                        'connectionInfo' => [],
                    ],
                ],
                'session_manager'             => [
                    'typeOf'     => SessionManager::class,
                    'parameters' => [
                        'config'      => null,
                        'storage'     => null,
                        // a change to this is going to be required I think, need to do some more reading on this
                        //'saveHandler' => 'session_save_handler',
                    ],
                ],
                'session_save_handler'        => [
                    'typeOf'     => Cache::class,
                    'parameters' => [
                        'cacheStorage' => 'redis_cache_backend', // has been MANY changes to the cache component
                    ],
                ],
                'redis_cache_backend'         => [
                    'parameters' => [
                        'options' => 'redis_cache_backend_options', // see above comment
                    ],
                ],
                'redis_cache_backend_options' => [ // not sure if this exists anymore
                    'parameters' => [
                        'server'   => [
                            'host'    => 'localhost',
                            'port'    => '6379',
                            'timeout' => 2,
                        ],
                        'database' => 0,
                        'ttl'      => 2678400,
                    ],
                ],
            ],
        ],
    ],
];
