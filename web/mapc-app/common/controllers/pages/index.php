<?php
if(!defined("__MAPC__")) { exit(); }

include(PROC_PATH . 'proc.autoload.php');
include(PROC_PATH . 'proc.db.php');

use Mapc\Common\Pages;

$posts = new Pages();

// this is it
