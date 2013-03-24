<?php
/*
 * Banana: The PHP framework that rocks
 * (c) Régis FLORET 2013
 * 
 * {BSD licence}
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
