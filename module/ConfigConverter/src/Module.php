<?php

declare(strict_types=1);

namespace ConfigConverter;

use ConfigConverter\ConfigProvider;
use Laminas\Config\Factory;
use Laminas\Di\LegacyConfig;
use Laminas\Mvc\MvcEvent;

class Module
{
    public function getConfig(): array
    {
        $configProvider = new ConfigProvider();
        return [
            'laminas-cli'     => $configProvider->getCliConfig(),
            'service_manager' => $configProvider->getDependencyConfig(),
        ];
    }

}
