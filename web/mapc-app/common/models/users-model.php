<?php
namespace Mapc\Common;

use \RedBeanPHP\R;
use Mapc\Common\Crud;

/**
 * User Model
 * @version 0.1
 */
class Users extends Crud {

	public $uuid;
	public $name;
	public $email;
	public $group;
	public $role;

    public function __construct($args = []) {

    	if(! isset($args['table'])) { $args = ['table' => 'mc_user_info']; }

        parent::__construct($args);

    }

	public function signin($args = []) {

		$query     = "select * from mc_user_info where user_id = ?, user_passwd = ?";
		$loginInfo = R::getRow( $query, array($args['userid'], $args['userpasswd']) );
		print_r($loginInfo);

		$this->uuid  = 'TESTTESTTEST';
		$this->name  = '손님';
		$this->email = 'guest@ooooo.ooooo';
		$this->group = 'group1';
		$this->role  = 'guest';
	}
	public function signout() {}

} // class

// this is it
