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

namespace Banana\Conf;

class KeyNotExists extends \Exception {}

/**
 * Description of BananaConfigParser
 *
 * @author regis
 */
class Config {
    static $config = null;
    var $container = [];
    public $auto_evolve = false;
    public $templatesDirectory = [];
	
    protected function __construct() {
        $this->libraryPath = BASE_DIR . 'libs' . DIRECTORY_SEPARATOR; // Default
        
        // Remember: PHP is not a _real_ functionnal language
        $this->cryproModule = function($value) { return crypt($value); };
    }
    
    protected function __clone() {}

    static function getInstance() {
        if (Config::$config === null) {
            Config::$config = new Config();
        }
        return Config::$config;
    }

    /** Add a new path to the php_path
     * @param string $path The new path to add
     */
    public function addPath($path) {
        set_include_path($path . PATH_SEPARATOR . get_include_path() );
    }

    /** Add a library in the php_path
     *
     * @param String $name the library name
     */
    public function addLibrary($name) {
        $this->addPath($this->libraryPath . $name);
    }

    /** Add multiple libraries
     *
     * @param Array $arr The libraries
     */
    public function addLibraries($libraries) {
        foreach($libraries as $lib) {
            $this->addLibrary($lib);
        }
    }

    public function __set($name, $value) {
        $this->container[$name] = $value;
    }

    public function __get($name) {
        if (array_key_exists($name, $this->container)) {
            return $this->container[$name];
        }
        return false;
    }

    public function __isset($name) {
        return array_key_exists($name, $this->container);
    }
}
