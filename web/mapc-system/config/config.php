<?php
{ // BLOCK:basic_config:20150807:기본값지정

    define('DEFAULT_VENDOR', 'Common');
    define('DEFAULT_MODULE', 'core');
    define('DEFAULT_ACTION', 'index');

    if( in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '172.19.0.1']) ) {

        define('DEBUG', true);
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

    } else {

        define('DEBUG', false);
        error_reporting(0);

    }

} // BLOCK

$config = [
    'site' => [
        'title'       => '사이트제목',
        'site_url'    => $_SERVER['REQUEST_URI'],
        'description' => 'site description',
        'lang'        => 'ko-KR',
        'type'        => 'website',
        'og_image'    => 'http://sample/images/img.png',
        'og_image_type'   => 'image/png',
        'og_image_width'  => '1024',
        'og_image_height' => '768',
        'author'   => '우연근',
        'email'    => 'webmaster@sample.com',
        'keywords' => '키워드, 키워드2',
        'favicon'  => 'favicon.ico',

        'layout' => 'core'
    ],

    'url' => [
        'layout' => ROOT_URL . 'layout' . DS . 'sbadmin' . DS, // 레이아웃의 기본 URL
        'oAuthServer' => 'http://127.0.0.1/mapc.me/web/mapc-public/'
    ],

    'menu' => [
        'admin' => [
            'my_info' => ROOT_URL . 'CommonAdmin/auth/info',
            'users' => ROOT_URL . 'CommonAdmin/users/'
        ]
    ],

    'secure' => [
        'upload_dir' => '',

        'dbadapter' => 'mysql',
        'dbhost'    => '127.0.0.1',
        'dbname' => 'dbname',
        'dbuser' => 'userid',
        'dbpass' => 'userpass',

        'encrypt_method' => 'sha512',
        'pass_key' => 'A5iFjnm27zkWuqH3'
    ],

    'api' => [
        'daum' => [
            'rest_api_key' => '#daum_api',
            'javascript_key' => '#javascript_key'
        ],
        'naver' => [
            'client_id' => '#your client id#', // 오픈 API 키 발급받은 client ID
            'client_secret' => '#your client secret#', // 오픈 API 키 발급받은 client secrete
            'authorize_url' => 'https://nid.naver.com/oauth2.0/authorize',
            'access_token_url' => 'https://nid.naver.com/oauth2.0/token',

            // 오픈 API 키 등록 시 입력한 callback 주소, tutorial에서는 "도메인주소/callback.php".
            'callback_uri' => '#your_callback_uri#',
            'index_uri' => '#your_website_uri#', // tutorial에서는 "도메인주소/index.php"

            'list_category_api_uri' => 'https://openapi.naver.com/blog/listCategory.json',
            'write_post_api_uri' => 'https://openapi.naver.com/blog/writePost.json'
        ],
        'juso' => [
            'authKey' => '#JUSO_API_from_juso.go.kr'
        ]
    ]
];

return $config;

// this is it
