WooYG
==============================

특징
------------------------------

* 순수 PHP
* MVC
* 빠른실행
* 쉬운 업데이트


설치1 (필수)
------------------------------

1. 서버도구 설치

    Git, Docker, Composer, NPM, NPX 설치 ($ npm i -g npx)

2. Git 클론(최초 1회)
    ```
    $ git clone https://github.com/wooygcom/mapc.me.git
    ```

3. 필요한 패키지 설치

    ```
    $ cd MAPC_ME_ROOT/web
    $ composer update (또는 php composer.phar update)
    $ npm install
    $ npm run build
    ```

4. 서버 실행(도커활용)
    ```
    $ sudo docker-compose up -d
    ```


설치2 (선택)
------------------------------

1. 클론 직후 .gitignore 무시하게끔 설정.
    ```
    $ git update-index --assume-unchanged .gitignore
    ```

2. 추가로 설치할 경우(필요할 때만)

    ```
    npm install PACKAGE --save
    ```

접속
------------------------------

1. 개발할 때의 접속주소
    http://접속주소/mapc-public/

2. 실 서버에서는 "mapc-public'이 웹루트가 되도록 설정할 것!!!(보안)

    ```
    // apache.conf 예제
    DocumentRoot /var/www/html/mapc-public
    ```


디렉토리구조
--------------------------------------------------
/mapc-app
    /bare : 새로운 프로그램 만들 때 이 디렉토리를 복사해서 사용
        /controllers
            /core
                /index.php : /mapc-public/index.php에서 호출하는 페이지
        /models : 프로그램에서 처리해야 되는 객체들이 저장된 곳
        /views
            /core
                /index.php : 컨트롤러에 대응하는 뷰페이지
/mapc-public
    /index.php 처음 접속 페이지
/mapc-system
    /config 다른 디렉토리로(예:config.my) 복사해서 사용가능
    /library 함수들 모음

/env.php : 디렉토리 및 기본환경설정 config을 config.my 로 변경해서 사용가능


FAQ
------------------------------

1. SERVER_URL/my/diary 라는 페이지를 만드려면

    1. mapc-app/ 디렉토리의 "bare" 디렉토리를 "my"라는 디렉토리로 복사
    2. "my/controllers 와 views 각 디렉토리 안의 index.php를 diary.php로 복사하거나 새로 만듦
    3. SERVER_URL/my/diary 로 접속






아래는 삭제 예정

기본형태 - vendor
==================================================

vendor/index.php [1/2]

* bare/index.php 참고

* 일반적인 형태(vendor/Common/index.php)와 별다른 차이가 없으면 아래 내용 그대로 복사해서 사용
    
    ```
    <?php
    { // BLOCK:get_common:20150825:Common/index.php 그대로 가져오기
    
        $rootDir = __DIR__;
        @include($rootDir . DS . '..' . DS . 'Common' . DS . 'index.php');
    
    } // BLOCK
    
    // this is it
    
    ```

vendor/index.php [2/2]
--------------------------------------------------

* vendor/index.php를 처음 만들 때는 [1/2] 또는 [2/2]를 복사 붙여넣기 하면 됨
* 아래는 vendor/Common/index.php(일반적인형태)와 다른 형태로 만들고 싶을때 사용
* 보통의 경우 vendor/index.php는 [1/2]를 그대로 복사해서 사용하면 됨

    ```
    <?php
    { // BLOCK:proc:20191204:선처리
    
        $rootDir = $rootDir ? $rootDir : __DIR__;
    
    } // BLOCK
    
    { // BLOCK:get_controller:20150825:컨트롤러 불러오기
    
        /**
         *
         * Get Controller...
         *
         */
        $v = [];
        @include($rootDir . '/controllers/' . $ROUTES['module'] . 'Controller.php');
    
    } // BLOCK
    
    { // BLOCK:publish:20150825:출력처리
    
        /**
         *
         * Get VIEW file and publish
         *
         */
        // 보안을 위해 CONFIG에서 필요한 값을 제외한 모든 환경설정값 지우기
        $v['url']  = $CONFIG['url'];
        $v['menu'] = $CONFIG['menu'];
        $v['site'] = $CONFIG['site'];
        unset($CONFIG);
        @include($rootDir . '/views/' . $ROUTES['module'] . 'View.php');
    
    } // BLOCK
    
    // this is it
    
    ```


기본형태 - Controllers
==================================================

vendor/controllers/packageController.php
--------------------------------------------------

```
<?php
if(!defined("__MAPC__")) { exit(); }

include($ROUTES['callback'] . '.php');

// this is it
```

vendor/controllers/package/module.php
--------------------------------------------------

1. 화면출력의 선처리 모듈의 경우(생략)
    ```
    <?php
    if(!defined("__MAPC__")) { exit(); }

    include(PROC_PATH . 'proc.autoload.php');
    include(PROC_PATH . 'proc.db.php');

    use Mapc\Common\Users;

    $user = new Users(['table' => $table]);
    ```

2. 입력값처리하는 모듈의 경우
    ```
    <?php
    if(!defined("__MAPC__")) { exit(); }

    include(PROC_PATH . 'proc.autoload.php');
    include(PROC_PATH . 'proc.db.php');
    include(PROC_PATH . 'proc.exec.php'); // csrf 처리

    use Mapc\Common\Users;

    $user = new Users(['table' => $table]);

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
        // POST값이 들어오면 "실행"
        switch($_POST['_method']) {
            case 'post':
            case 'put':
            case 'patch':
            case 'delete':
            default:
                // 
                break;
        }
    }

    // this is it
    ```


기본형태 - Models
==================================================

vendor/models/MyModel.php
--------------------------------------------------
```
<?php
namespace Mapc\Common;

use Mapc\Common\Crud;

/**
 * Bare Model
 * @version 0.1
 */
class Bare {

    public $id;
    public $vars;

} // class

// this is it
```


기본형태 - Views
==================================================

vendor/views/module/index.php [1/2]
--------------------------------------------------

단순한 형태 : moduleView.php에서 모두처리, 스크립트 처리가 필요없는 프로그램에서만 사용, 1번 기본형 추천

```
<?php
/**
 *
 * View
 *
 * @version 0.1
 *
 */
$layout = 'core';

include(LAYOUT_PATH . $layout . DS . 'head.php');
include(LAYOUT_PATH . $layout . DS . 'header.php');
?>

// 내용출력
<?= $v['foo']; ?>

<?php
include(LAYOUT_PATH . $layout . DS . 'footer.php');
include(LAYOUT_PATH . $layout . DS . 'foot.php');

// this is it
```


vendor/views/module/index.php [2/2]
--------------------------------------------------

```
<?php
/**
 *
 * View
 *
 * @version 0.1
 *
 */

$layout = 'core';

$v['header']['extension'] = <<< EOT
<!-- include libraries(jQuery, bootstrap) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 
<script src="<?= $v['url']['layout']; ?>path/src.js">
<script src="{ROOT_URL}/app.js"></script>
EOT;
$v['header']['extension'] = sprintf($v['header']['extension'], ROOT_URL);

include(LAYOUT_PATH . $layout . DS . 'head.php');
include(LAYOUT_PATH . $layout . DS . 'header.php');
?>

<!-- form:#formv1 -->
<form method="post" action="./" enctype="multipart/form-data">
    <input type="hidden" name="_csrf" value="<?= $_SESSION['csrf']; ?>" />
    <input type="hidden" name="_method" value="update" /><!-- POST, PUT, PATCH, DELETE -->
    <input type="hidden" name="content_type" value="<?= $ROUTES['action'] ? $ROUTES['action'] : 'intro'; ?>" />
</form>

<?php
include(LAYOUT_PATH . $layout . DS . 'footer.php');
include(LAYOUT_PATH . $layout . DS . 'foot.php');

// this is it
```
