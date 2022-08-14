<?php

declare(strict_types=1);

namespace Test\Controller;

use Application\Utils\Debug;
use Laminas\Config\Config;
use Laminas\Config\Factory;
use Laminas\Config\Processor\Token as TokenProcessor;
use Laminas\Config\Writer\PhpArray as Writer;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use SplFileObject;

use function file_get_contents;
use function fopen;
use function is_array;
use function token_get_all;
use function token_name;

use const PHP_EOL;
use const T_CONSTANT_ENCAPSED_STRING;
use const T_STRING;

class IndexController extends AbstractActionController
{
    public function indexAction(): ViewModel
    {
        $writer = new Writer();
        $writer->setUseBracketArraySyntax(true);

        //$writer->toFile(__DIR__ . '/../../../../config/module.config.php', $config);
        $path = \dirname(__DIR__, 3);
       // $config = new Config(Factory::fromFile($path . '/Test/config/test.config.php'), true);
        //Debug::dump(Factory::fromFile($path . '/Test/config/test.config.php'));
       // $writer->toFile($path . '/Test/config/writetest.config.php', $config);
        //Debug::dump($path);
        $config = file_get_contents($path . '/Test/config/test.config.php');
        $tokens = token_get_all($config);
        Debug::dump($tokens);
        foreach ($tokens as $token) {
            if (is_array($token)) {
                echo token_name($token[0]) . ' ' . $token[1] . PHP_EOL;
            } else {
                echo $token . PHP_EOL;
            }
        }
        return new ViewModel();
    }
}
