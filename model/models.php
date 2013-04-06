<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Banana\Model;

/**
 * Models is the base class for all database calls.
 *
 * @author regis
 */
class Models {
    protected $tableName; //!

    public function __construct() {
        print_r(get_object_vars($this));
    }

    public function find($args, $callback=null) {
        $result = [];
        if (is_callable($callback)) {
            return $callback(TRUE, $result);
        }
        return $result;
    }

    public function update($args, $callback=null) {
        $result = [];
        if (is_callable($callback)) {
            return $callback(TRUE, $result);
        }
        return $result;
    }
}
