<?php
include(PROC_PATH . 'proc.autoload.php');;
include(PROC_PATH . 'proc.db.php');
include(PROC_PATH . 'proc.exec.php');
include(LIBRARY_PATH . 'http_move.php');

// #TODO 아래는 임시코드

session_start();

use Mapc\Common\Users;


$user = new Users();

$user->signin(array($_POST['user_email'], $_POST['user_password']));

$reffererUrl = isset($_REQUEST['reffererUrl']) ? $_REQUEST['reffererUrl'] : ROOT_URL;

httpMove(200, $reffererUrl);

exit;

// this is it
