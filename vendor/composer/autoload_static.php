<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit55e9c5c6f9b06c5b08db84db96f43eab
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit55e9c5c6f9b06c5b08db84db96f43eab::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit55e9c5c6f9b06c5b08db84db96f43eab::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
