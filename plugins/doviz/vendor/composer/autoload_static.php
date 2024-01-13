<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbdf59a813e064d0a44f6819f587b0443
{
    public static $files = array (
        'def43f6c87e4f8dfd0c9e1b1bab14fe8' => __DIR__ . '/..' . '/symfony/polyfill-iconv/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Teknomavi\\Tcmb\\' => 15,
            'Teknomavi\\Common\\' => 17,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Iconv\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Teknomavi\\Tcmb\\' => 
        array (
            0 => __DIR__ . '/..' . '/teknomavi/tcmb/src',
        ),
        'Teknomavi\\Common\\' => 
        array (
            0 => __DIR__ . '/..' . '/teknomavi/common/src',
        ),
        'Symfony\\Polyfill\\Iconv\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-iconv',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbdf59a813e064d0a44f6819f587b0443::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbdf59a813e064d0a44f6819f587b0443::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitbdf59a813e064d0a44f6819f587b0443::$classMap;

        }, null, ClassLoader::class);
    }
}
