<?php
if(!defined("__MAPC__")) { exit(); }

// usage
// //[URL]/common/files/[FILENAME].jpg?group=[GROUP]
// //[URL]/common/files/20191209-131746-12345.jpg?group=featured
$group  = $_GET['group'];
$group2 = $_GET['group2'];
// 파일명
$filename = $ROUTES['id'];

// 확장자
$ext   = array_pop(explode('.', $filename));
// 파일명.thumb.확장자 이름 구하기 (파일명만 넘어오기 때문에 thumb구하는 로직이 따로 필요함)
$filename_thumb = substr($filename, 0, -1*(strlen($ext)+1)) . '.thumb.' . $ext;
$dir_Y = substr($filename, 0, 4);
$dir_m = substr($filename, 4, 2);
$dir_d = substr($filename, 6, 2);

if($group) {
    $uploads_dir .= $group;
}
if($group2) {
    $uploads_dir .= $group2;
}
$uploads_dir_real  = $uploads_dir  . DS . $dir_Y . DS . $dir_m . DS . $dir_d . DS;
$uploads_dir_real2 = $uploads_dir2 . DS . $dir_Y . DS . $dir_m . DS . $dir_d . DS;

// 분할 드라이브에 썸네일 파일이 있으면 그걸 가져오고
if(is_file($uploads_dir_real2 . $filename_thumb)) {
    $imgpath = $uploads_dir_real2 . $filename_thumb;
// 아니면 원래 드라이브에서 썸네일 가져오고
} elseif(is_file($uploads_dir_real . $filename_thumb)) {
    $imgpath = $uploads_dir_real . $filename_thumb;
// 없으면 원본 가져오기
} else {
    $imgpath = $uploads_dir_real . $filename;
}

// Get the mimetype for the file
$finfo = finfo_open(FILEINFO_MIME_TYPE);  

// return mime type ala mimetype extension
$mime_type = finfo_file($finfo, $imgpath);
 
finfo_close($finfo);

switch ($mime_type){

    case "image/jpeg":

        // Set the content type header - in this case image/jpg
        header('Content-Type: image/jpeg');
          
        // Get image from file
        $img = imagecreatefromjpeg($imgpath);
          
        // Output the image
        imagejpeg($img);
          
        break;

    case "image/png":

        // Set the content type header - in this case image/png
        header('Content-Type: image/png');
          
        // Get image from file
        $img = imagecreatefrompng($imgpath);
          
        // integer representation of the color black (rgb: 0,0,0)
        $background = imagecolorallocate($img, 0, 0, 0);
          
        // removing the black from the placeholder
        imagecolortransparent($img, $background);
          
        // turning off alpha blending (to ensure alpha channel information 
        // is preserved, rather than removed (blending with the rest of the 
        // image in the form of black))
        imagealphablending($img, false);
          
        // turning on alpha channel information saving (to ensure the full range 
        // of transparency is preserved)
        imagesavealpha($img, true);
          
        // Output the image
        imagepng($img);
          
        break;

    case "image/gif":
        // Set the content type header - in this case image/gif
        header('Content-Type: image/gif');
          
        // Get image from file
        $img = imagecreatefromgif($imgpath);
          
        // integer representation of the color black (rgb: 0,0,0)
        $background = imagecolorallocate($img, 0, 0, 0);
          
        // removing the black from the placeholder
        imagecolortransparent($img, $background);
          
        // Output the image
        imagegif($img);
          
        break;
}

// Free up memory
imagedestroy($img);

// this is it
