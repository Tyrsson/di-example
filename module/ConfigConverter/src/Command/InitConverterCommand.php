<?php

declare(strict_types=1);

namespace ConfigConverter\Command;

use ConfigConverter\Command\AbstractCommand;
use ConfigConverter\Command\ConverterTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InitConverterCommand extends AbstractCommand
{
    use ConverterTrait;

    /** @var string $defaultName */
    protected static $defaultName = 'init-converter';
    /** @var Factory $configFactory */
    protected $configFactory;
    /** @var int $result */
    protected $result = 1;

    protected function configure(): void
    {
        $this->setName(self::$defaultName);
        $this->addOption(
            'module',
            null,
            InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED,
            'Modules to convert',
            $this->autoDetect()
        );
        $this->addOption(
            'backup',
            null,
            InputOption::VALUE_NEGATABLE,
            'Backup config files',
            true
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $module = $input->getOption('module');
        // var_dump($module);
        //if ($module === []) {
            $scanConfigCommand = $this->getApplication()->find('scan-config');
            $scanConfigCommand->run($input, $output);
       // }
        return 0;
    }
}
