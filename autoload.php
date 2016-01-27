<?php
/**
 * Created by PhpStorm.
 * User: Yuriy
 * Date: 26.01.2016
 * Time: 22:05
 */

function my_autoload($class) {

    $classParts = explode('\\', $class);
    $classParts[0] = __DIR__;
    $path = implode(DIRECTORY_SEPARATOR, $classParts) . '.php';
    if (file_exists($path)) {
        require $path;
    }
}

spl_autoload_register('my_autoload');