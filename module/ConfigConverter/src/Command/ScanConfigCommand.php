<?php

declare(strict_types=1);

namespace ConfigConverter\Command;

use ConfigConverter\Command\AbstractCommand;
use ConfigConverter\Command\ConverterTrait;
use DirectoryIterator;
use Laminas\Config\Factory as ConfigFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use function implode;

final class ScanConfigCommand extends AbstractCommand
{
    use ConverterTrait;

    /** @var string $defaultName */
    protected static $defaultName = 'scan-config';
    /** @var string $defaultDescription */
    protected static $defaultDescription = 'Scan config files for Laminas-Di v2 config.';

    protected function configure(): void
    {
        $this->setName(self::$defaultName);
        $this->setDescription(self::$defaultDescription);
        $this->addOption(
            'module',
            null,
            InputOption::VALUE_IS_ARRAY | InputOption::VALUE_REQUIRED,
            'Module(s) to convert',
            []
        );
        $this->addOption(
            'backup',
            null,
            InputOption::VALUE_NEGATABLE,
            'Bckup config files',
            'backup'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $targets = [];
        $targets = $this->scan($input, $output);
        $output->writeln('<info>Di v2 config found in the following module config files:</info>');
        foreach ($targets as $target) {
            $output->writeln('<comment>' . $target . '</comment>');
        }
        return 0;
    }
}
