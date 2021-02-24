<?php
spl_autoload_register(function($className) {

    $classArray = explode("\\", $className);
    $fileName   = APP_PATH . strtolower($classArray[1]) . DS . 'models' . DS . strtolower($classArray[2]) . '-model.php';
echo $fileName;exit;
    if($classArray[0] == 'Mapc' && file_exists($fileName)) {
        include_once $fileName;
    }

});

include_once(VENDOR_PATH . 'autoload.php');

// this is it
