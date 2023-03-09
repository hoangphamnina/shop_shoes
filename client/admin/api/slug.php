<?php
include "config.php";

$dataSlug = array();
$dataSlug['slug'] = (!empty($_POST['slug'])) ? trim(htmlspecialchars($_POST['slug'])) : '';
$dataSlug['id'] = (!empty($_POST['id'])) ? htmlspecialchars($_POST['id']) : 0;

echo ($func->checkSlug($dataSlug) == 'exist') ? 0 : 1;
?>