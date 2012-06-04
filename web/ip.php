<?php
/*
 +-----------------------------------------------------
 * 	2010-4-15
 +-----------------------------------------------------
 *		
 +-----------------------------------------------------
 */


include ('include/comm.php');
$pageaccess=1;
checklogin();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>线路管理</title>
<link href="../divstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="28" align="left" background="../images/bg_topbg.gif"> </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
          <table width="746" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
          	<tr><td height="30" colspan="4" bgcolor="#ffffff" align="center" class="greenbg">线路默认IP管理</td></tr>
            <tr>
              <td width="53" height="30" align="center" bgcolor="#99FF00" class="graybg">线路名称</td>
              <td width="59" height="30" align="center" bgcolor="#99FF00" class="graybg">线路标识</td>
              <td width="152" align="center" bgcolor="#99FF00" class="graybg">描述</td>
              <td width="200" align="center" bgcolor="#99FF00" class="graybg">管理</td>
            </tr>
            <?
    		$query=$db->query("select * from setacl where acltype=0 order by aclid desc");
    		while($row = $db->fetchAssoc($query))
    		{
    			$bg="#ffffff";
    		?>
            <tr>
              <td height="25" align="center" bgcolor="<?echo $bg?>" class="graytext"><?echo $row['aclname']?></td>
              <td height="25" align="center" bgcolor="<?echo $bg?>" class="graytext"><?echo $row['aclident']?></td>
              <td align="center" bgcolor="<?echo $bg?>" class="graytext"><?echo $row['aclabout']?></td>
              <td align="center" bgcolor="<?echo $bg?>" class="graytext"><a href="dns/acl_mip.php?aclname=<?echo $row['aclident'];?>&type=<? echo $row['acltype']?>">管理默认IP</a></td>
            </tr>
            <?}
      		?>
          </table>            
    </td>
  </tr>
</table>
<? include "copyright.php";?>
</body>
</html>
