<?php
if(!defined("__MAPC__")) { exit(); }

include(LIBRARY_PATH . 'image_thumbnail.php');

$dir_Y = date('Y');
$dir_m = date('m');
$dir_d = date('d');

$args   = '';
$argSep = '?';
// 화일 분류, 단순히 날짜별로 디렉토리를 구분하면 헤깔릴수도 있으니...
$group  = $_POST['group'];
// 화일 분류2
$group2 = $_POST['group2'];

if($group) {
$uploads_dir .= DS . $_POST['group'];
$args  .= $argSep . 'group=' . $group;
$argSep = '&';
}
if($group2) {
$uploads_dir .= DS . $_POST['group2'];
$args  .= $argSep . 'group2=' . $group2;
$argSep = '&';
}

$uploads_dir_real  = $uploads_dir  . DS . $dir_Y . DS . $dir_m . DS . $dir_d . DS;
$uploads_dir_real2 = $uploads_dir2 . DS . $dir_Y . DS . $dir_m . DS . $dir_d . DS;
$allowed_ext = array('jpg','jpeg','png','gif');

// 변수 정리
$error = $_FILES['file']['error'];
$name  = $_FILES['file']['name'];
$ext   = array_pop(explode('.', $name));
$uniqid = uniqid(); // 파일명에 들어갈 고유값

// 오류 확인
if( $error != UPLOAD_ERR_OK ) {
switch( $error ) {
	case UPLOAD_ERR_INI_SIZE:
	case UPLOAD_ERR_FORM_SIZE:
		echo "파일이 너무 큽니다. ($error)";
		break;
	case UPLOAD_ERR_NO_FILE:
		echo "파일이 첨부되지 않았습니다. ($error)";
		break;
	default:
		echo "파일이 제대로 업로드되지 않았습니다. ($error)";
}
exit;
}

// 확장자 확인
if( !in_array(strtolower($ext), $allowed_ext) ) {
echo "허용되지 않는 확장자입니다.";
exit;
}

// #TODO 파일명에 들어가는 날짜를 원글의 글쓴날의 날짜로 대체~!!! date함수 대신 원글Ymd로 대체~!!!!!
$server_filename = date('Ymd-His') . '.' . $uniqid . '.' . $ext;
$server_filename_thumb = date('Ymd-His') . '.' . $uniqid . '.thumb.' . $ext;

if(! is_dir($uploads_dir_real)) {
mkdir($uploads_dir_real, 0777, true);
}

// 파일 이동
move_uploaded_file( $_FILES['file']['tmp_name'], $uploads_dir_real . $server_filename );
// #TODO jpg 이외의 파일도 썸네일 만들어지도록~
if($ext == 'jpg') {
imageThumbnail(
    $uploads_dir_real . $server_filename,
    $uploads_dir_real . $server_filename_thumb
);
}

// 파일 정보 출력
echo ROOT_URL . 'Common/files/' . $server_filename . $args;

// this is it
