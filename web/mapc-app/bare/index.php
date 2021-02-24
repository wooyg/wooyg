<?php
/**
 *
 * vendor/index.php
 *
 * 아래는 common/index.php 를 그대로 호출해서 사용함
 * 다른 방식으로 사용하고 싶다면
 * common/index.php 내용을 복붙하고 편집하면 됨
 *
 */
{ // BLOCK:get_common:20150825:common/index.php 그대로 가져오기

    $rootDir = __DIR__;
    @include($rootDir . DS . '..' . DS . 'common' . DS . 'index.php');

} // BLOCK

// this is it
