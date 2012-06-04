<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>自动更新</title>
<link href="../divstyle.css" rel="stylesheet" type="text/css" />


</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="28" align="left" background="../images/bg_topbg.gif">&nbsp;当前位置:&gt;&gt; 自动更新 </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="35" align="center"><?//取出地址
$query=$db->query("select * from setupdate where updateid=1");
$row=$db->fetchAssoc($query);
$url=$row['updateurl'];

//更新不同线路内容
$query=$db->query("select * from setacl where acltype=0");
while($row=$db->fetchAssoc($query)){
	$geturl=$url.$row['aclident'];
	//echo $geturl;die();
	if(($cnc=@file_get_contents( $geturl ))){
		writeFile($binddir."acl/".$row['aclident']."_M",$cnc);
		
		if (file_exists($binddir."acl/".$row['aclident']."_ADD")){
			$cnc = str_replace("};\n", "",$cnc);
			$cnc = str_replace("};", "",$cnc);
			$cip = @file_get_contents($binddir."acl/".$row['aclident']."_ADD");
			$cnc = $cnc.$cip."\n};\n";
		}
		writeFile($binddir."acl/".$row['aclident'],$cnc);
		
		$sql="insert into updatelog (updatetime,updateresult,updatecontent)values(datetime('now','localtime'),'".$row['aclident']."更新成功','".$row['aclname']."线路更新成功')";
		$db->query($sql);
		echo $row['aclname']."线路IP更新成功！<br>";
	}else 
	{
		$sql="insert into updatelog (updatetime,updateresult,updatecontent)values(datetime('now','localtime'),'".$row['aclident']."更新失败','".$row['aclname']."线路更新失败')";
		$db->query($sql);
		echo $row['aclname']."线路IP更新失败！<br>";
	}
}
//更新黑名单内容
//$bldir = "/ximorun/ximodb/";
$geturl = $url."black";
if ($bl = @file_get_contents($geturl)){
    writeFile($bldir."hostURL_M", $bl);
    if (file_exists($bldir."hostURL_ADD")){
        $add = file_get_contents($bldir."hostURL_ADD");
        $bl .= $add;
    }
    writeFile($bldir."hostURL", $bl);
    $sql="insert into updatelog (updatetime,updateresult,updatecontent)values(datetime('now','localtime'),'黑名单更新成功','黑名单更新成功')";
	$db->query($sql);
	echo "黑名单更新成功！<br>";
}
else {
    $sql="insert into updatelog (updatetime,updateresult,updatecontent)values(datetime('now','localtime'),'黑名单更新失败',' 黑名单更新失败')";
	$db->query($sql);
	echo "黑名单更新失败！<br>";
}
$db->query("update setupdate set lastupdate=datetime('now','localtime') where updateid=1");
showmessage('自动更新完成','setupdate.php');
?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?$db->close();?>
<? include "../copyright.php";?>
</body>
</html>
