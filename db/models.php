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


namespace Banana\Db;

use \Banana\Conf\Config as Config;

/** 
 * Singleton to get the database backend
 * @return Backend A backend object
 */
function getBackend() {
	static $db = NULL;
	
	if ($db == NULL) {
		$database = Config::getInstance()->database;
		$engine = __NAMESPACE__ . "\\Backend\\" . $database['backend'];
		$db = new $engine($database['host'], $database['user'], $database['password'], $database['database']);
	}
	return $db;
}

/**
 * Models is the base class for all database calls.
 *
 * @author Régis FLORET
 */
class Models {
    protected $tableName; //!
    private $backend;
    public $id;
    
    public function __construct() {
    	$this->backend = getBackend();

    	if (Config::getInstance()->auto_evolve === TRUE) {
    		$me = $this;
    		$this->backend->tableExists($this->tableName, function($exists, $tableName, $tableList) use ($me) {
    			if ( ! $exists) {
	    			$me->backend->createTable($tableName, function() use ($me) {
	    				$fields = [];
				        foreach ($me as $var => $field) {
				        	if ($field instanceof Field) {
				        		$field->name = $var;
				         		$fields[] = $field->toString();
				         		// TODO: index on field
				        	}
				        }
				        return join(",\n", $fields);
	    			}) or die("Error : ". $me->backend->getLastErrorMsg());
    			}
    		});
    	}

    	// Create the ID 
    	$this->id = new Integerfield(['null' => FALSE, 'primary' => TRUE]);
    	
    }

    /** Find a element in the database
     * @param array $args
     * @param function $callback
     * @return QuerySet
     */
    public function find($args, $callback=null) {
        $result = [];
        
        if (is_callable($callback)) {
            return $callback(TRUE, $result);
        }
     
        return new QuerySet();
    }

    public function update($args, $callback=null) {
        $result = [];
        if (is_callable($callback)) {
            return $callback(TRUE, $result);
        }
        return new QuerySet();
    }
}
