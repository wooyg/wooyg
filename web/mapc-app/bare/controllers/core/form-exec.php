<?php
// #TODO form-exec예제 만들기
if(!defined("__MAPC__")) { exit(); }

include(PROC_PATH . 'proc.autoload.php');
include(PROC_PATH . 'proc.exec.php');
include(LIBRARY_PATH . 'library/some-library.php');

use Mapc\Common\Users;

$obj_users = new Users;

$query = " select * from tableA where fielda = ? and fieldb = ? ";
$value = ['a', 'b'];

R::exec( $query, $value );

// this is it
