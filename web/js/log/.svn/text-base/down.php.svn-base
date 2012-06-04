<?php
$file = $_GET['file'];
$filename = basename($_GET['file']);
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"".$filename."\""); 
readfile($_GET['file']);
?>