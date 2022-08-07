<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita3244d27a7e85d1879656afd83deaa90
{
    public static $files = array (
        'c9d07b32a2e02bc0fc582d4f0c1b56cc' => __DIR__ . '/..' . '/laminas/laminas-servicemanager/src/autoload.php',
    );

    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Webimpress\\SafeWriter\\' => 22,
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 8,
            'Psr\\Container\\' => 14,
            'PhpParser\\' => 10,
        ),
        'L' => 
        array (
            'Laminas\\View\\' => 13,
            'Laminas\\Validator\\' => 18,
            'Laminas\\Uri\\' => 12,
            'Laminas\\Stdlib\\' => 15,
            'Laminas\\SkeletonInstaller\\' => 26,
            'Laminas\\ServiceManager\\' => 23,
            'Laminas\\Router\\' => 15,
            'Laminas\\Mvc\\' => 12,
            'Laminas\\ModuleManager\\' => 22,
            'Laminas\\Loader\\' => 15,
            'Laminas\\Json\\' => 13,
            'Laminas\\Http\\' => 13,
            'Laminas\\EventManager\\' => 21,
            'Laminas\\Escaper\\' => 16,
            'Laminas\\Di\\' => 11,
            'Laminas\\DevelopmentMode\\' => 24,
            'Laminas\\Config\\' => 15,
            'Laminas\\ComponentInstaller\\' => 27,
        ),
        'D' => 
        array (
            'Di\\' => 3,
        ),
        'B' => 
        array (
            'Brick\\VarExporter\\' => 18,
        ),
        'A' => 
        array (
            'Application\\' => 12,
            'ApplicationTest\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Webimpress\\SafeWriter\\' => 
        array (
            0 => __DIR__ . '/..' . '/webimpress/safe-writer/src',
        ),
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/src',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'PhpParser\\' => 
        array (
            0 => __DIR__ . '/..' . '/nikic/php-parser/lib/PhpParser',
        ),
        'Laminas\\View\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-view/src',
        ),
        'Laminas\\Validator\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-validator/src',
        ),
        'Laminas\\Uri\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-uri/src',
        ),
        'Laminas\\Stdlib\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-stdlib/src',
        ),
        'Laminas\\SkeletonInstaller\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-skeleton-installer/src',
        ),
        'Laminas\\ServiceManager\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-servicemanager/src',
        ),
        'Laminas\\Router\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-router/src',
        ),
        'Laminas\\Mvc\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-mvc/src',
        ),
        'Laminas\\ModuleManager\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-modulemanager/src',
        ),
        'Laminas\\Loader\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-loader/src',
        ),
        'Laminas\\Json\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-json/src',
        ),
        'Laminas\\Http\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-http/src',
        ),
        'Laminas\\EventManager\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-eventmanager/src',
        ),
        'Laminas\\Escaper\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-escaper/src',
        ),
        'Laminas\\Di\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-di/src',
        ),
        'Laminas\\DevelopmentMode\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-development-mode/src',
        ),
        'Laminas\\Config\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-config/src',
        ),
        'Laminas\\ComponentInstaller\\' => 
        array (
            0 => __DIR__ . '/..' . '/laminas/laminas-component-installer/src',
        ),
        'Di\\' => 
        array (
            0 => __DIR__ . '/../..' . '/module/Di/src',
        ),
        'Brick\\VarExporter\\' => 
        array (
            0 => __DIR__ . '/..' . '/brick/varexporter/src',
        ),
        'Application\\' => 
        array (
            0 => __DIR__ . '/../..' . '/module/Application/src',
        ),
        'ApplicationTest\\' => 
        array (
            0 => __DIR__ . '/../..' . '/module/Application/test',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita3244d27a7e85d1879656afd83deaa90::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita3244d27a7e85d1879656afd83deaa90::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita3244d27a7e85d1879656afd83deaa90::$classMap;

        }, null, ClassLoader::class);
    }
}
