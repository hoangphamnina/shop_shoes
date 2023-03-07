<?php
if (!defined('LIBRARIES')) die("Error");

/* Timezone */
date_default_timezone_set('Asia/Ho_Chi_Minh');

/* Cấu hình chung */
$config = array(
    'database' => array(
        'server-name' => $_SERVER["SERVER_NAME"],
        'url' => '/shop_shoes/client/',
        'type' => 'mysql',
        'host' => 'localhost',
        'username' => 'root',
        'dbname' => 'db',
        'password' => '',
        'port' => 3306,
        'charset' => 'utf8mb4'
    ),
    'website' => array(
        'video' => array(
            'extension' => array('mp4'),
            'poster' => array(
                'width' => 700,
                'height' => 610,
                'extension' => '.jpg|.png|.jpeg'
            ),
            'allow-size' => '100Mb',
            'max-size' => 100 * 1024 * 1024
        ),
    ),
);

/* Path */
define('ROOT', str_replace(basename(__DIR__), '', __DIR__));

/* Cấu hình base */
$http = 'http://';
$configUrl = $config['database']['server-name'] . $config['database']['url'];
$configBase = $http . $configUrl;

/* Cấu hình upload */
/* require_once LIBRARIES . "constant.php"; */
include LIBRARIES . "upload.php";
?>