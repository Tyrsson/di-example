<?php

declare(strict_types=1);

namespace Di;

class Module
{
    public function getConfig(): array
    {
        /** @var array $config */
        return include __DIR__ . '/../config/module.config.php';
    }
}
