<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8e1085dfd9e15fdae94c6561e533b740
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Faker\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Faker\\' => 
        array (
            0 => __DIR__ . '/..' . '/fakerphp/faker/src/Faker',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit8e1085dfd9e15fdae94c6561e533b740::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8e1085dfd9e15fdae94c6561e533b740::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8e1085dfd9e15fdae94c6561e533b740::$classMap;

        }, null, ClassLoader::class);
    }
}
