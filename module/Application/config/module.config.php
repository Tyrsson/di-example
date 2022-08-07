<?php

/**
 * This works because the class lives in the same namespace as the module.
 * Which allows us to the class without a use statement.
 * To use classes outside of the module, you need a use statement
 * like what was provided for the InvokableFactory.
 * then you use the short name of the class.
 * Also of note here is that we are using the same Factory for both the
 * the Example Model and the IndexController. Which factory is used
 * does not matter, as long as it is able to create and return and
 * instance of the object that is requested.
 *
 * - We did not have to add an additional route because the route
 * defined for the IndexController uses the placeholder for the
 * action, which means it will load any action in the controller
 * It loads as is without a view file because it uses the
 * JsonRenderingStrategy.
 */

declare(strict_types=1);

namespace Application;

use Laminas\Mvc\Controller\LazyControllerAbstractFactory;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'service_manager' => [
        'factories' => [
            Model\ConcreteFactoryExample::class => Model\Factory\ConcreteFactoryExampleFactory::class,
            Model\Example::class                => InvokableFactory::class,
        ],
    ],
    'router'          => [
        'routes' => [
            'home'        => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers'     => [
        'factories' => [
            Controller\IndexController::class => LazyControllerAbstractFactory::class,
        ],
    ],
    'view_manager'    => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack'      => [
            __DIR__ . '/../view',
        ],
    ],
];
