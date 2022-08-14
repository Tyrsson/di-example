<?php

declare(strict_types=1);

namespace ConfigConverter\Command;

use Laminas\Cli\Command\AbstractParamAwareCommand;
use Laminas\Config\Writer\PhpArray as Writer;
use Symfony\Component\Console\Command\Command;

class AbstractCommand extends Command
{
    public const MODULE_DIR      = __DIR__ . '/../../../../module/';
    public const CONFIG_DIR      = 'config/';
    public const BACKUP_FILENAME = 'module.config.php.bak';
    public const TARGET_FILENAME = 'module.config.php';
    /** @var string $configDir */
    protected $configDir;
    /** @var string $modulePath */
    protected $moduleDir;
    /** @var string $runtimeBackUpPath */
    protected $runtimeBackUpPath;
    /** @var string $runtimeTargetPath */
    protected $runtimeTargetPath;
    /** @var Writer $writer */
    protected $writer;
    public function __construct()
    {
        $this->modulePath        = self::MODULE_DIR;
        $this->configDir         = self::CONFIG_DIR;
        $this->runtimeBackUpPath = self::MODULE_DIR . '%s/' . self::CONFIG_DIR . self::BACKUP_FILENAME;
        $this->runtimeTargetPath = self::MODULE_DIR . '%s/' . self::CONFIG_DIR . self::TARGET_FILENAME;
        $this->writer            = new Writer();
        $this->writer->setUseBracketArraySyntax(true);
        $this->writer->setUseClassNameScalars(true);
        parent::__construct();
    }
}
