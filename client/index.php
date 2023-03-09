<?php
session_start();
define('LIBRARIES', './libraries/');
define('TEMPLATE', './templates/');
define('ASSETS', './assets/');
define('SOURCES', './sources/');
define('LAYOUT', './layout/');

/* Config */
require_once LIBRARIES . "config.php";
require_once LIBRARIES . 'autoload.php';
new AutoLoad();
$injection = new AntiSQLInjection();
$d = new PDODb($config['database']);
$flash = new Flash();
$router = new AltoRouter();
$func = new Functions($d);

/* Router */
require_once LIBRARIES . "router.php";

/* Template */
include TEMPLATE . "index.php";
?>