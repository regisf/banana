<?php
/*
 * Banana : The PHP Framework that rocks
 * (c) Régis FLORET 2013 and Later
 * 
 */

define('BASE_DIR', getcwd() . DIRECTORY_SEPARATOR);

include_once 'configuration.php';

/**
 * Autoloader. If the class starts with Banana, remove it and try to find
 * it in the Banana directory
 * @param String $name The class name
 */
function __autoload($name) {
    $dir = './';

    if (preg_match('/^Banana/', $name)) {
        $name = str_ireplace('Banana', '', $name);
        $dir .= 'banana/';
    }

    require_once($dir . strtolower($name).'.php');
}


/**
 * With statment  in functionnal programm. This function allow local scope and
 * don't pollute the namespace
 * @param Object $obj The object we works with
 * @param Function $func, the function to call
 */
function with($obj, $func) {
    if (is_callable($func)) {
        $func($obj);
    }
}