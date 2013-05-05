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

namespace Banana\Model;

use \Banana\Db;

/**
 * Description of authusermodel
 *
 * @author regis
 */
class AuthUserModel extends Db\Models {
    protected $tableName = 'auth_user';

    public $username;
    public $password;
    public $email;
    public $firstname;
    public $lastname;
    public $isadmin;

    public function __construct() {
        $this->username = new Db\Charfield(array('size' => 140, 'save' => function($val) { return filter_var($val, FILTER_SANITIZE_STRING); }));
        $this->password = new Db\Charfield(array('size' => 140, 'save' => function($val) { return \Banana\Conf\Config\cryptoModule($password); }));
        $this->email = new Db\Emailfield(array('index' => TRUE));
        $this->firstname = new Db\Charfield(array('size' => 140, 'null' => TRUE));
        $this->lastname = new Db\Charfield(array('size' => 140, 'null' => TRUE));
        $this->isadmin = new Db\Booleanfield(array('default' => FALSE));
        
        parent::__construct();
    }

    /**
     * Create an user with only its username, email and password. If callback
     * is null, return the value.
     * @param String $username
     * @param String $email
     * @param String $password
     * @param Function $callback
     */
    public static function createUser($username, $email, $password, $callback=null) {
        $me=$this;
        $this->insert(array($username, $password, \Banana\Conf\Config::getInstance()->cryptoModule($password)), function($err) use ($me) {
            if (is_callable($callback)) {
                $callback($err, $me);
            }
        });
    }
}
