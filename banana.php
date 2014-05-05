<?php
/*
 * Banana : The PHP Framework that tastes good
 * (c) Régis FLORET 2013 and Later
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 *  * The above copyright notice and this permission notice shall be included
 *    in all copies or substantial portions of the Software.
 *
 *  * The Software is provided "as is", without warranty of any kind, express
 *    or implied, including but not limited to the warranties of
 *    merchantability, fitness for a particular purpose and noninfringement. In
 *    no event shall the authors or copyright holders be liable for any claim,
 *    damages or other liability, whether in an action of contract, tort or
 *    otherwise, arising from, out of or in connection with the software or the
 *    use or other dealings in the Software.
 */

define('BASE_DIR',  realpath(__DIR__ . DIRECTORY_SEPARATOR . '..'));
define('BANANA_DIR', BASE_DIR . DIRECTORY_SEPARATOR . 'banana' );
define('PUBLIC_DIR', BASE_DIR . DIRECTORY_SEPARATOR . 'public' );
define('CONTROLLERS_PATH', PUBLIC_DIR . DIRECTORY_SEPARATOR . 'Controllers' );
define('MODELS_PATH', PUBLIC_DIR . DIRECTORY_SEPARATOR . 'Models' );
define('VIEWS_PATH', PUBLIC_DIR . DIRECTORY_SEPARATOR . 'Views' );

/**
 * Autoloader. If the namespace starts with Banana, remove it and try to find
 * it in the Banana directory
 * @param String $name The class name
 */
spl_autoload_register(function ($name) {
    if (preg_match('/^Banana/', $name)) {
        $name = str_replace('\\', DIRECTORY_SEPARATOR, $name);
        require_once(BASE_DIR  . DIRECTORY_SEPARATOR . strtolower($name) . '.php');
    } elseif (preg_match('#Controller$#', $name)) {
        require_once(CONTROLLERS_PATH  . DIRECTORY_SEPARATOR . strtolower($name) . '.php');
    } elseif (preg_match('#Model#', $name)) {
        require_once(MODELS_PATH  . DIRECTORY_SEPARATOR . strtolower($name) . '.php');
    }
});

/**
 * Singleton to get the database backend
 * @return Backend A backend object
 */
function getBackend() {
    static $db = NULL;

    if ($db == NULL) {
		$database = \Banana\Conf\Config::getInstance()->database;
		$engine = "\\Banana\\Db\\Backend\\" . $database['backend'];
		$db = new $engine($database['host'], $database['user'], $database['password'], $database['database']);
    }
    return $db;
}

include_once 'Utils/with_statment.php';
include_once 'configuration.php';

/**
 * Create the signal manager
 */
$sigManager = new \Banana\Core\SignalManager();

/**
 * Ensure minimal tables exists
 */
if (\Banana\Conf\Config::getInstance()->auto_evolve) {
    getBackend()->tableExists(\Banana\Model\SessionModel::SessionTableName, function($exists, $tableName, $tableList) {
        if ( ! $exists) {
            new \Banana\Model\AuthUserModel();
            new \Banana\Model\SessionModel();
        }
    });
}
