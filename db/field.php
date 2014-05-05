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

namespace Banana\Db;

/**
 * Description of field
 *
 * @author regis
 */
class Field {
	public $name = '';
    public $value = NULL;
    public $size = 0;
    public $null = FALSE;
    public $type = '';
    public $default = '';
    public $primary_key = FALSE;

	private $after = array();
    
    public function __construct($args) {
        if (array_key_exists("size", $args)) {
        	$this->size = $args['size'];
        }
        if (array_key_exists('null', $args)) {
        	$this->null = $args['null'];
        }
        if (array_key_exists('default',$args)) {
        	$this->default = $args['default'];
        }
        if (array_key_exists('primary' , $args)) {
        	$this->primary_key = TRUE;
        }
        
    }
    
    public function toString() {
    	// FIXME: auto_increment only with MySQL
    	return "`$this->name` $this->type " . ($this->size ? '(' . $this->size . ')' : '') . 
			    ($this->null == TRUE ? '' : ' NOT NULL') . 
				($this->primary_key ? ' PRIMARY KEY AUTO_INCREMENT' : '');
    }

	public function pushAfter($what) {
		$this->after[] = $what;
	}

	public function haveAfter() {
		return count($this->after) > 0;
	}

	public function getAfter() {
		return join(',', $this->after);
	}
}

