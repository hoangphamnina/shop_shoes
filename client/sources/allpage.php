<?php
if (!defined('SOURCES')) die("Error");

$favicon = $d->rawQueryOne("select photo from table_photo where type = ? and act = ? and find_in_set('hienthi',status) limit 0,1", array('favicon', 'photo_static'));

?>
