<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita224fc0282f835cbcaaf1cc8caf63e8e
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPGraphQL\\Extensions\\BuddyPress\\' => 32,
        ),
        'D' => 
        array (
            'Dealerdirect\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 55,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPGraphQL\\Extensions\\BuddyPress\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Dealerdirect\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\' => 
        array (
            0 => __DIR__ . '/..' . '/dealerdirect/phpcodesniffer-composer-installer/src',
        ),
    );

    public static $classMap = array (
        'Dealerdirect\\Composer\\Plugin\\Installers\\PHPCodeSniffer\\Plugin' => __DIR__ . '/..' . '/dealerdirect/phpcodesniffer-composer-installer/src/Plugin.php',
        'WPGraphQL\\Extensions\\BuddyPress\\Connection\\GroupConnection' => __DIR__ . '/../..' . '/src/Connection/GroupConnection.php',
        'WPGraphQL\\Extensions\\BuddyPress\\Data\\Connection\\GroupsConnectionResolver' => __DIR__ . '/../..' . '/src/Data/Connection/GroupsConnectionResolver.php',
        'WPGraphQL\\Extensions\\BuddyPress\\Data\\Factory' => __DIR__ . '/../..' . '/src/Data/Factory.php',
        'WPGraphQL\\Extensions\\BuddyPress\\Data\\Loader\\GroupObjectLoader' => __DIR__ . '/../..' . '/src/Data/Loader/GroupObjectLoader.php',
        'WPGraphQL\\Extensions\\BuddyPress\\Model\\Group' => __DIR__ . '/../..' . '/src/Model/Group.php',
        'WPGraphQL\\Extensions\\BuddyPress\\TypeRegistry' => __DIR__ . '/../..' . '/src/TypeRegistry.php',
        'WPGraphQL\\Extensions\\BuddyPress\\Type\\WPEnum\\GroupEnums' => __DIR__ . '/../..' . '/src/Type/Enum/GroupEnums.php',
        'WPGraphQL\\Extensions\\BuddyPress\\Type\\WPObject\\GroupType' => __DIR__ . '/../..' . '/src/Type/Object/GroupType.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita224fc0282f835cbcaaf1cc8caf63e8e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita224fc0282f835cbcaaf1cc8caf63e8e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInita224fc0282f835cbcaaf1cc8caf63e8e::$classMap;

        }, null, ClassLoader::class);
    }
}
