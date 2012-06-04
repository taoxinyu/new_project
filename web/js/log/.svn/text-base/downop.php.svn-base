<?php
header("Content-type: application/octet-stream;charset=gb2312");
$filename = 'oplog.log';
header("Content-Disposition: attachment; filename=\"".$filename."\"");

include('../include/config.php');
include('../include/mysqlclass.php');
$db = new SQL($dbfile);

$sql=stripslashes($_GET['sql']);
$query = $db->query($sql);
	while($row1= $db->fetchAssoc($query))
    {
		$addtime=$row1['addtime'];
		$username=$row1['username'];
		$dotype=$row1['dotype'];
		$param=$row1['param'];
	  echo $addtime."\t".$username."\t".$dotype."\t".$param."\n";
	
	}


?>
