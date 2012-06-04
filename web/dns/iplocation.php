<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();
$domain = $_GET['domain'];
$table = $_GET['table'];
$acl = $_GET['acl'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>记录查询设置</title>
<link href="../divstyle.css" rel="stylesheet" type="text/css" />


</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="28" align="left" background="../images/bg_topbg.gif">&nbsp;当前位置:&gt;&gt; 统计查询 </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<table width="625" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#82C4E8">
<?
$table = str_replace("dns", "url", $table);
$db2 = new SQL("pdo:database=/xmdns/var/log/dns.db");
$rs = $db2->query("select * from $table where domain = '$domain' and flag ='$acl' order by num desc");
?>
	<tr>
	    <td height="25" align="center" class="greenbg"  colspan="3" ><? echo $domain;?></td>
    </tr>
    <tr > 
      <td width="197" height="25" align="center" class="graybg">IP</td> 
      <td width="276" align="center" class="graybg">地区</td> 
      <td width="136" align="center" class="graybg">次数</td> 
	</tr> 
<?
while ($row = $db2->fetchAssoc($rs)){
?>
	<tr >
		<td align="center" bgcolor="#FFFFFF"><? echo $row['ip'];	?></td>
		<td align="center" bgcolor="#FFFFFF"><? echo convertip($row['ip']);	?></td>
		<td align="center" bgcolor="#FFFFFF"><? echo $row['num']; ?></td>
    </tr>
		
<?
}
$db2->close();
?>
	</table>
	</td>
  </tr>
</table>
<? include "../copyright.php";?>
</body>
</html>
