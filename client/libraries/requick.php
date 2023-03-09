<?php
/* Request data */
$com = (!empty($_REQUEST['com'])) ? htmlspecialchars($_REQUEST['com']) : '';
$act = (!empty($_REQUEST['act'])) ? htmlspecialchars($_REQUEST['act']) : '';
$kind = (!empty($_REQUEST['kind'])) ? htmlspecialchars($_REQUEST['kind']) : '';
$id_parent = (!empty($_REQUEST['id_parent'])) ? htmlspecialchars($_REQUEST['id_parent']) : '';
$id = (!empty($_REQUEST['id'])) ? htmlspecialchars($_REQUEST['id']) : '';
$curPage = (!empty($_GET['page'])) ? htmlspecialchars($_GET['page']) : 1;


/* Include sources */
if (file_exists(SOURCES . $com . '.php')) include SOURCES . $com . ".php";
else $template = "index";

?>