<?php

declare(strict_types=1);

namespace Test;

use Laminas\Router\Http\Literal;

return [
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'router'       => [
        'routes' => [
            'test' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/test',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'di'           => [
        'instance' => [
            'alias'                       => [
                'db_adapter'                  => 'Laminas\Db\Adapter\Adapter',
                'db_driver'                   => 'Laminas\Db\Adapter\Driver\Mysqli\Mysqli',
                'db_connection'               => 'Laminas\Db\Adapter\Driver\Mysqli\Connection',
                'session_manager'             => 'Laminas\Session\SessionManager',
                'session_save_handler'        => 'Laminas\Session\SaveHandler\Cache',
                'redis_cache_backend'         => 'Laminas\Cache\Storage\Adapter\Redis',
                'redis_cache_backend_options' => 'Laminas\Cache\Storage\Adapter\RedisOptions',
            ],
            'db_adapter'                  => [
                'parameters' => [
                    'driver' => 'db_driver'
                ]
            ],
            'db_driver'                   => [
                'parameters' => [
                    'connection' => 'db_connection',
                    'options'    => [
                        'buffer_results' => true
                    ]
                ]
            ],
            'db_connection'               => [
                'parameters' => [
                    'connectionInfo' => []
                ]
            ],
            'session_manager'             => [
                'parameters' => [
                    'config'      => null,
                    'storage'     => null,
                    'saveHandler' => 'session_save_handler',
                ]
            ],
            'session_save_handler'        => [
                'parameters' => [
                    'cacheStorage' => 'redis_cache_backend',
                ]
            ],
            'redis_cache_backend'         => [
                'parameters' => [
                    'options' => 'redis_cache_backend_options',
                ]
            ],
            'redis_cache_backend_options' => [
                'parameters' => [
                    'server'   => [
                        'host'    => 'localhost',
                        'port'    => '6379',
                        'timeout' => 2,
                    ],
                    'database' => 0,
                    'ttl'      => 2678400, // 31 days
                ]
            ]
        ]
    ],
    'view_helpers'    => [
        'factories' => [],
    ],
];
