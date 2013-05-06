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
 * Description of BananaConfigParser
 *
 * @author Regis FLORET
 */
class Request {
    private $post_container = [];
    private $get_container = [];
    private $method;

    const POST = 0;
    const GET = 1;
    const PUT = 2;
    const DELETE = 3;

    public function __construct() {
        if (isset($_POST)) {
            $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);
            foreach ($POST as $key => $value ) {
                $this->post_container[$key] = $value;
            }
            $this->method == Request::POST;
        } else if (isset($_GET)) {
            $GET = filter_var_array($_GET, FILTER_SANITIZE_STRING);
            foreach ($GET as $key => $value ) {
                $this->get_container[$key] = $value;
            }
            $this->method == Request::GET;
        }
    }

    public function isPost() {
        return $this->method == Request::POST;
    }

    public function isGet() {
        return $this->method == Request::GET;
    }

    public function isPut() {
        return $this->method == Request::PUT;
    }

    public function isDelete() {
        return $this->method == Request::DELETE;
   }

    public function isAjax() {

    }

    public function get($name, $default=NULL) {

    }

    public function post($name, $default=NULL) {

    }

    public function put($name, $default=NULL) {

    }

    public function delete($name, $default=NULL) {

    }
}

