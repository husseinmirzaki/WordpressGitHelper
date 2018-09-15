<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6535e10261e748d37545da3fdab0e6f4
{
    public static $files = array (
        'a0edc8309cc5e1d60e3047b5df6b7052' => __DIR__ . '/..' . '/guzzlehttp/psr7/src/functions_include.php',
        'ddc0a4d7e61c0286f0f8593b1903e894' => __DIR__ . '/..' . '/clue/stream-filter/src/functions.php',
        '8cff32064859f4559445b89279f3199c' => __DIR__ . '/..' . '/php-http/message/src/filters.php',
        'c964ee0ededf28c96ebd9db5099ef910' => __DIR__ . '/..' . '/guzzlehttp/promises/src/functions_include.php',
        '37a3dc5111fe8f707ab4c132ef1dbc62' => __DIR__ . '/..' . '/guzzlehttp/guzzle/src/functions_include.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\OptionsResolver\\' => 34,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Cache\\' => 10,
        ),
        'H' => 
        array (
            'Http\\Promise\\' => 13,
            'Http\\Message\\' => 13,
            'Http\\Discovery\\' => 15,
            'Http\\Client\\Common\\Plugin\\' => 26,
            'Http\\Client\\Common\\' => 19,
            'Http\\Client\\' => 12,
            'Http\\Adapter\\Guzzle6\\' => 21,
        ),
        'G' => 
        array (
            'GuzzleHttp\\Psr7\\' => 16,
            'GuzzleHttp\\Promise\\' => 19,
            'GuzzleHttp\\' => 11,
            'Github\\' => 7,
        ),
        'C' => 
        array (
            'Clue\\StreamFilter\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\OptionsResolver\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/options-resolver',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Psr\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/cache/src',
        ),
        'Http\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-http/promise/src',
        ),
        'Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-http/message/src',
            1 => __DIR__ . '/..' . '/php-http/message-factory/src',
        ),
        'Http\\Discovery\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-http/discovery/src',
        ),
        'Http\\Client\\Common\\Plugin\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-http/cache-plugin/src',
        ),
        'Http\\Client\\Common\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-http/client-common/src',
        ),
        'Http\\Client\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-http/httplug/src',
        ),
        'Http\\Adapter\\Guzzle6\\' => 
        array (
            0 => __DIR__ . '/..' . '/php-http/guzzle6-adapter/src',
        ),
        'GuzzleHttp\\Psr7\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/psr7/src',
        ),
        'GuzzleHttp\\Promise\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/promises/src',
        ),
        'GuzzleHttp\\' => 
        array (
            0 => __DIR__ . '/..' . '/guzzlehttp/guzzle/src',
        ),
        'Github\\' => 
        array (
            0 => __DIR__ . '/..' . '/knplabs/github-api/lib/Github',
        ),
        'Clue\\StreamFilter\\' => 
        array (
            0 => __DIR__ . '/..' . '/clue/stream-filter/src',
        ),
    );

    public static $classMap = array (
        'ClientInterface' => __DIR__ . '/../..' . '/admin/ClientInterface.php',
        'GitHubClient' => __DIR__ . '/../..' . '/admin/GitHubClient.php',
        'LoginPart' => __DIR__ . '/../..' . '/admin/LoginPart.php',
        'MainPagePart' => __DIR__ . '/../..' . '/admin/MainPagePart.php',
        'Mirzaki' => __DIR__ . '/../..' . '/includes/class-mirzaki.php',
        'MirzakiGitAuth' => __DIR__ . '/../..' . '/includes/class-mirzaki-git-auth.php',
        'Mirzaki_Activator' => __DIR__ . '/../..' . '/includes/class-mirzaki-activator.php',
        'Mirzaki_Admin' => __DIR__ . '/../..' . '/admin/class-mirzaki-admin.php',
        'Mirzaki_Deactivator' => __DIR__ . '/../..' . '/includes/class-mirzaki-deactivator.php',
        'Mirzaki_Loader' => __DIR__ . '/../..' . '/includes/class-mirzaki-loader.php',
        'Mirzaki_i18n' => __DIR__ . '/../..' . '/includes/class-mirzaki-i18n.php',
        'ShowBranchesPart' => __DIR__ . '/../..' . '/admin/ShowBranchesPart.php',
        'ShowCommitPart' => __DIR__ . '/../..' . '/admin/ShowCommitPart.php',
        'ShowCommitsPart' => __DIR__ . '/../..' . '/admin/ShowCommitsPart.php',
        'ShowRepositoriesPart' => __DIR__ . '/../..' . '/admin/ShowRepositoriesPart.php',
        'Utilities' => __DIR__ . '/../..' . '/admin/Utilities.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6535e10261e748d37545da3fdab0e6f4::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6535e10261e748d37545da3fdab0e6f4::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6535e10261e748d37545da3fdab0e6f4::$classMap;

        }, null, ClassLoader::class);
    }
}
