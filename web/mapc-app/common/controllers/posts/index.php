<?php
if(!defined("__MAPC__")) { exit(); }

include(PROC_PATH . 'proc.autoload.php');
include(PROC_PATH . 'proc.db.php');

use Mapc\Common\Posts;

$posts = new Posts(['table' => 'board']);

// this is it
