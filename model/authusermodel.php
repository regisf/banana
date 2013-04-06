<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Banana\Model;

use Banana\Conf\Config as Config;
/**
 * Description of authusermodel
 *
 * @author regis
 */
class AuthUserModel extends Models {
    protected $tableName = "authmodel";

    public $username;
    public $email;
    public $password;
    public $firstname;
    public $lastname;
    public $isadmin;

    public function __construct() {
        $this->username = new Charfield(array('size' => 140, 'save' => function($val) { return filter_var($val, FILTER_SANITIZE_STRING); }));
        $this->email = new Emailfield();
        $this->firstname = new Charfield(array('size' => 140, 'null' => TRUE));
        $this->lastname = new Charfield(array('size' => 140, 'null' => TRUE));
        $this->isadmin = new Booleanfield(array('default' => FALSE));
        
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
        $this->insert(array($username, $password, Config::getInstance()->cryptoModule($password)), function($err) use ($me) {
            if (is_callable($callback)) {
                $callback($err, $me);
            }
        });
    }
}
