<?php

/*
 * Banana: The PHP framework that rocks
 * (c) Régis FLORET 2013
 * 
 * {BSD licence}
 */

/**
 * Description of Router
 *
 * @author Régis FLORET <regis.floret@gmail.com>
 */
class BananaRouter {

    var $pathes = [];

    public function addRoute($path, $func) {
        if (is_callable($func)) {
            $this->pathes[$path] = $func;
        } else {
            error_log("$path don't have a function as argument. It will be ignored. ");
        }
        return $this;
    }

    public function process() {
        $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
        foreach (array_keys($this->pathes) as $key) {
            if (preg_match($key, $path_info)) {
                echo $this->pathes[$key](new BananaRequest());
                return;
            }
        }
    }

}
