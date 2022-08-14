<?php

declare(strict_types=1);

namespace Test;

use Laminas\Mvc\Controller\LazyControllerAbstractFactory;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

class Module
{
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getControllerConfig(): array
    {
        return [
            'factories' => [
                Controller\IndexController::class => LazyControllerAbstractFactory::class,
            ],
        ];
    }
}
