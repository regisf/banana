<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//namespace Banana
/**
 * Description of authusermodel
 *
 * @author regis
 */
class AuthUserModel extends BananaModels {
    protected $tableName = "authmodel";

    public $username;
    public $email;
    public $password;
    public $firstname;
    public $lastname;
    public $isadmin;

    public function __construct() {
        $this->username = new Banana\Model\Charfield();

        parent::__construct();
    }
    public static function createUser($username, $email, $password, $callback=null) {
        $me=$this;
        $this->insert(array($username, $password, BananaConfig::getInstance()->cryptoModule($password)), function($err) use ($me) {
            if (is_callable($callback)) {
                $callback($err, $me);
            }
        });
    }
}
