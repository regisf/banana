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


namespace Banana\Db\Backend;

class MySQL implements IBackend
{
	private $db;
	private $after = array();
	
	public function __construct($host, $user, $password, $database) {
		$this->db = mysqli_connect($host, $password, $database);
		mysqli_select_db($this->db, $database);
		// FIXME: Handle error
	}
	
	public function tableExists($tableName, $callback=NULL) {
		$tableList = [];
		$result = mysqli_query($this->db, "SHOW TABLES");
		// FIXME : Handle eror
		while($row = mysqli_fetch_array($result))
		{
			$tableList[] = $row[0];
		}

		$exists = FALSE;
		foreach($tableList as $table) {
			if ($table == $tableName) {
				$exists = TRUE;
				break;
			}
		}

		if (is_callable($callback)) {
			$callback($exists, $tableName, $tableList);
		} else {
			return $exists;
		}
	}
	
	public function createTable($tableName, $callback) {
		//echo("CREATE TABLE `$tableName` ( `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT," . $callback($this) . (count($this->after) > 0 ? ', ' : ' ') . join(',', $this->after) .  ')');die();
		mysqli_query($this->db, "CREATE TABLE $tableName ( `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT," . $callback($this) . (count($this->after) > 0 ? ', ' : ' ') . join(',', $this->after) .  ')');
		if (mysqli_errno($this->db)) {
			return FALSE;
		}
		
		// Create the id index
		mysqli_query($this->db, 'CREATE INDEX ' . $tableName . "_id_index ON $tableName (`id`)");
		if (mysqli_errno($this->db)) {
			return FALSE;
		}

		return TRUE;
	}
	
	public function getLastErrorMsg() {
		return mysqli_error($this->db);
	}
	
	public function pushAfter($what) {
		$this->after[] = $what;
	}
}
