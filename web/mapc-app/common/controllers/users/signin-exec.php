<?php
include(PROC_PATH . 'proc.autoload.php');;
include(PROC_PATH . 'proc.db.php');
include(PROC_PATH . 'proc.exec.php');
include(LIBRARY_PATH . 'http_move.php');

use Mapc\Common\Users;


$user = new Users();

$user->signin(array($_POST['userid'], $_POST['userpasswd']));

$reffererUrl = isset($_REQUEST['reffererUrl']) ? $_REQUEST['reffererUrl'] : ROOT_URL;

httpMove(200, $reffererUrl);

exit;

// this is it
