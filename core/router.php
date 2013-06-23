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

namespace Banana\Core;


/**
 * A router is a glue between path and closure function.
 *
 * @author Régis FLORET <regis.floret@gmail.com>
 */
class Router {
    public static $instance = null;
    var $pathes = [];

    /** Force singleton */
    public function __construct() {
        if (Router::$instance != null) {
            return Router::$instance;
        }
    }
    
    /**
     * Static method to return a singleton (Yes I know, it's bad)
     * @return \Banana\Core\Router The router object
     */
    public static function getInstance() {
        if (Router::$instance === null) {
            Router::$instance = new Router();
        }
        return Router::$instance;
    }
    
    
    /** Declare URL handled by a object
     * @param \Banana\Core\Controller A controller object
     * @return \Banana\Core\ControllerHandler
     */
    public function with ($objName) {
        return new ControllerHandler($objName, $this);
    }
    
    /** Add a route
     * @param String $url The url in regex format
     * @param String $controller The controller
     * @param String $method The method
     */
    public function addRoute($url, $controller, $method) {
        $this->pathes[$url] = ['controller' =>$controller, 'method' => $method ];
    }
    
    /** Add a named route for the URL
     */
    public function addNamedRoute($name, $url, $controller, $method) {
        $this->pathes[$url] = ['controller' =>$controller, 'method' => $method, 'name' => $name ];
    }
    
    public function getNamedRoute($name) {
        foreach ($this->pathes as $key => $value) {
            if (is_array($value)) {
                if (array_key_exists('name', $value)) {
                    if ($name == $value['name']) {
                        $key = preg_replace('[\#|\^|\$]', '', $key);
                        return [ 'path' => $key, 'name' => $value['name'], 'function' => $value['method'] ];
                    }
                }
            }
        }
        return null;
    }

    public function getPathForName($name) {
        $route = $this->getNamedRoute($name);
        $path =  str_replace(array('\\', '^', '$'),'',$route['path']);
        while (preg_match('#\/\/#', $path)) {
            $path = preg_replace('#\/\/#', '/', $path);
        }
        return $path;
    }

    public function haveNamedRoute($name) {
        return $this->getNamedRoute($name) !== null;
    }

    public function process() {
        $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
        foreach (array_keys($this->pathes) as $key) {
            if (preg_match($key, $path_info)) {
                $controller = new $this->pathes[$key]['controller'];
                $method = $this->pathes[$key]['method'];
                echo $controller->$method(new \Banana\Core\Request());
                return;
            }
        }
        // TODO: Better way for 404
        die("$path_info is not found in the URLs");
    }
}
