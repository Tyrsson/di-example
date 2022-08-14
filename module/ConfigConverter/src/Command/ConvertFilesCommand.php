<?php

declare(strict_types=1);

namespace ConfigConverter\Command;

use ConfigConverter\Command\AbstractCommand;
use ConfigConverter\Command\ConverterTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use function count;
use function is_array;

final class ConvertFilesCommand extends AbstractCommand
{
    use ConverterTrait;

    /** @var string $defaultName */
    protected static $defaultName = 'convert-files';
    /** @var string $defaultDescription */
    protected static $defaultDescription = 'Convert Laminas-Di v2 config to Laminas-Di v3 config.';
    /** @var int $result */
    protected $result = 1;
    /** @var bool $proceed */
    protected $proceed = false;

    public function __construct()
    {
        parent::__construct();
    }

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
            'Backup config files',
            true
        );
    }

    /** @inheritDoc */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $module = $input->getOption('module');
        //var_dump($module);
        if (count($module) === 0) {
            $module = $this->autoDetect();
        }

        if ($input->getOption('backup')) {
            $output->writeln('<info>Creating backup(s)...</info>');
            if (is_array($module)) {
                for ($i = 0; $i < count($module); $i++) {
                    $this->backup($module[$i], $output);
                }
            }
        }
        if ($input->getOption('no-backup')) {
            $output->writeln('<comment>*** Skipping backups ***</comment>');
        }
        if (is_array($module)) {
            for ($i = 0; $i < count($module); $i++) {
                $this->convert($module[$i], $output);
            }
        }
        //$output->writeln('<info>Converting: ' . $module . '</info>');

        return 0;
    }
}
