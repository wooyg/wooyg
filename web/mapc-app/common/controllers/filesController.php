<?php
if(!defined("__MAPC__")) { exit(); }

// env.php에 DATA_PATH2를 설정해놓으면 파일을 분할해서 가져올 수 있음
$uploads_dir  = DATA_PATH . $CONFIG['upload_dir'];

if(DATA_PATH2) {
    $uploads_dir2 = DATA_PATH2 . $CONFIG['upload_dir'];
} else {
    $uploads_dir2 = DATA_PATH . $CONFIG['upload_dir'];
}

@include($ROUTES['callback'] . '.php');

// this is it
