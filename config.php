<?php
/*
 * Banana : The PHP Framework that rocks
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

class KeyNotExists extends Exception {}

/**
 * Description of BananaConfigParser
 *
 * @author regis
 */
class BananaConfig {
    static $config = null;
    var $container = [];

    public function __construct() {

    }

    static function getInstance() {
        if (BananaConfig::$config === null) {
            BananaConfig::$config = new BananaConfig();
        }
        return BananaConfig::$config;
    }

    public function __set($name, $value) {
        $this->container[$name] = $value;
    }

    public function __get($name) {
        if (array_key_exists($name, $this->container)) {
            return $this->container[$name];
        }
        throw new KeyNotExists("The key $name don't exists");
    }
}
