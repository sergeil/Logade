<?php

if (!defined('LOGADE_TESTING')) {
    set_include_path(
        realpath(__DIR__.'/../lib').PATH_SEPARATOR.get_include_path()
    );

    class LogadeClassLoader
    {
        static public function register()
        {
            spl_autoload_register(array('LogadeClassLoader', 'load'));
        }

        static public function load($className)
        {
            require_once implode(DIRECTORY_SEPARATOR, explode('_', $className)).'.php';
        }
    }
    LogadeClassLoader::register();



    define('LOGADE_TESTING', true);
}

