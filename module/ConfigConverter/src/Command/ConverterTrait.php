<?php

declare(strict_types=1);

namespace ConfigConverter\Command;

use ConfigConverter\Command\AbstractCommand;
use DirectoryIterator;
use Laminas\Config\Config;
use Laminas\Config\Exception\InvalidArgumentException;
use Laminas\Config\Exception\RuntimeException;
use Laminas\Config\Factory as ConfigFactory;
use Laminas\Config\Writer\PhpArray as Writer;
use Laminas\Di\LegacyConfig;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function count;
use function is_array;
use function sprintf;

trait ConverterTrait
{
    /** @var Config $config*/
    protected $config;
    /** @var ConfigWriter $configWriter */
    protected $configWriter;
    /** @var LegacyConfig $legacyConfig */
    protected $legacyConfig;
    /** @var InputInterface $input */
    protected $input;
    /** @var OutputInterface $output */
    protected $output;

    protected function scan(InputInterface $input, OutputInterface $output): array
    {
        $output->writeln('<info>Scanning config files for Laminas-Di v2 config...</info>');
        $handler = new DirectoryIterator(AbstractCommand::MODULE_DIR);
        foreach ($handler as $dir) {
            if ($dir->isDir() && ! $dir->isDot() && $dir->getFilename() !== 'ConfigConverter') {
                $output->writeln('<info>Scanning ' . $dir->getFilename() . '...</info>');
                $config = ConfigFactory::fromFile(
                    $dir->getPathname()
                    . '/config/module.config.php',
                    true
                );
                if ($config->count() > 0 && isset($config->di)) {
                    $targets[] = $dir->getFilename();
                    //$output->writeln('<info>Found Laminas-Di v2 config in ' . $dir->getFilename() . '</info>');
                }
            }
        }
        return $targets;
    }

    protected function autoDetect(): array
    {
        $modules = [];
        $handler = new DirectoryIterator(AbstractCommand::MODULE_DIR);
        foreach ($handler as $dir) {
            if ($dir->isDir() && ! $dir->isDot() && $dir->getFilename() !== 'ConfigConverter') {
                $config = ConfigFactory::fromFile($dir->getPathname() . '/config/module.config.php', true);
                if ($config->count() > 0 && isset($config->di) && $config !== []) {
                    $modules[] = $dir->getFilename();
                }
            }
        }
        return $modules;
    }

    protected function convert(string $module, OutputInterface $output)
    {
        $converted = [];
        $output->writeln('<info>Starting ' . $module . ' conversion...</info>');
        $config = new Config(ConfigFactory::fromFile(sprintf($this->runtimeTargetPath, $module)), true);
        // $config = new Config($config, true);

        if ($config->count() > 0 && isset($config->di)) {
            $legacyConfig                      = new LegacyConfig($config->di);
            $converted['dependencies']['auto'] = $legacyConfig->toArray();
            unset($config->di);
            $config->merge(new Config($converted));
            $this->writer->toFile(
                sprintf($this->runtimeTargetPath, $module),
                $config->toArray(),
                true
            );
            $output->writeln(
                '<comment>' . $module . ' confguration written to: ' . sprintf($this->runtimeTargetPath, $module) . '</comment>'
            );
        }
    }

    protected function backup(string $module, OutputInterface $output)
    {
        if (is_string($module)) {
            $output->writeln('<info>Backing up ' . $module . '...</info>');
            $config = ConfigFactory::fromFile(
                sprintf($this->runtimeTargetPath, $module),
                true
            );
            if ($config->count() > 0 && isset($config->di)) {
                $this->writer->toFile(
                    sprintf($this->runtimeBackUpPath, $module),
                    $config
                );
                $output->writeln(
                    '<comment>'
                    . $module
                    . ' backup written to: '
                    . sprintf($this->runtimeBackUpPath, $module)
                    . '</comment>'
                );
            }
        }
    }
}
