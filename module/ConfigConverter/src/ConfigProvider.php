<?php

declare(strict_types=1);

namespace ConfigConverter;

class ConfigProvider
{
    /**
     * this method is only called for Mezzio applications
     */
    public function __invoke(): array
    {
        return [
            'laminas-cli'  => $this->getCliConfig(),
            'dependencies' => $this->getDependencyConfig(),
        ];
    }

    public function getCliConfig(): array
    {
        return [
            'commands' => [
                'scan-config'    => Command\ScanConfigCommand::class,
                'init-converter' => Command\InitConverterCommand::class,
                'convert-files'  => Command\ConvertFilesCommand::class,
            ],
            'chains'   => [
                Command\InitConverterCommand::class => [
                    Command\ConvertFilesCommand::class => [
                        '--module' => '--module',
                        '--backup' => '--backup',
                    ],
                ],
            ],
        ];
    }

    public function getDependencyConfig(): array
    {
        return [
            'factories' => [
                Command\CheckFiles::class   => Command\CheckFilesCommandFactory::class,
                Command\ConvertFiles::class => Command\ConvertFilesCommandFactory::class,
            ],
        ];
    }
}
