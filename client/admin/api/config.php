<?php
session_start();
define('LIBRARIES', '../../libraries/');
define('SOURCES', '../sources/');

require_once LIBRARIES . "config.php";
require_once LIBRARIES . 'autoload.php';
new AutoLoad();
$d = new PDODb($config['database']);
$func = new Functions($d);