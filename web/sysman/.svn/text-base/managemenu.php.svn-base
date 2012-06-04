<?
include "../include/comm.php";
checklogin();
checkac();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>菜单管理</title>
<link href="../divstyle.css" rel="stylesheet" type="text/css" />
</head>
<?
if($_GET['action']=='del'){
	$rst = $db->query("select father from module where module_id =".$_GET['id']);
	$arr = $db->fetchAssoc($rst);
	if ($arr['father'] == -1){
		$db->query("delete from module where pid =".$_GET['id']);
		$query=$db->query("delete from module where module_id=".$_GET['id']);
	}
	else {
		$query=$db->query("delete from module where module_id=".$_GET['id']);
	}
	echo '<script>window.parent.frames.leftFrame.location.reload()</script>';
}
?>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="28" align="left" background="../images/bg_topbg.gif">&nbsp;当前位置:&gt;&gt; 菜单管理 </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="26" align="center"><a href="menuadd.php">&gt;&gt;添加菜单</a></td>
  </tr>
  <tr>
    <td>
      <table width="768" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#82C4E8">
        <tr>
          <td height="25" colspan="7" align="center" bgcolor="#D7F5F9" class="greenbg">菜单管理</td>
        </tr>
        <tr>
          <td width="105" align="center" bgcolor="#C2F8E1" class="graybg"><strong>类别</strong></td>
          <td width="181" align="center" bgcolor="#C2F8E1" class="graybg"><strong>名称</strong></td>
          <td width="92" align="center" bgcolor="#C2F8E1" class="graybg"><strong>URL</strong></td>
          <td width="92" align="center" bgcolor="#C2F8E1" class="graybg"><strong>SORT</strong></td>
          <td width="115" align="center" bgcolor="#C2F8E1" class="graybg"><strong>管理</strong></td>
        </tr>
<?php
$query=$db->query("select * from module where pid is null order by [order] asc");
while($row = $db->fetchAssoc($query))
{
?>
        <tr>
          <td height="25" align="left" bgcolor="#FFFFFF" class="graytext"><label><? echo "父菜单".$row['module_id'];?></label></td>
          <td align="center" bgcolor="#FFFFFF" class="graytext"><? echo $row['name'];?></td>
          <td align="center" bgcolor="#FFFFFF" class="graytext"><? echo $row['url'];?></td>
          <td align="center" bgcolor="#FFFFFF" class="graytext"><? echo $row['order'];?></td>
          <td align="center" bgcolor="#FFFFFF"><a href="menuedit.php?id=<? echo $row['module_id'];?>">编辑</a> <a href="managemenu.php?id=<? echo $row['id'];?>&action=del" onclick="javascript:return   confirm('真的要删除此用户吗？');">删除</a></td>
        </tr>

<?php
	$id = $row['module_id'];
	$son = $db->query("select * from module where pid = $id order by [order]");
	while ($arr = $db->fetchAssoc($son)){
?>
        <tr>
          <td height="25" align="right" bgcolor="#FFFFFF" class="graytext"><label><? echo "子菜单";?></label></td>
          <td align="center" bgcolor="#FFFFFF" class="graytext"><? echo $arr['name'];?></td>
          <td align="center" bgcolor="#FFFFFF" class="graytext"><? echo $arr['url'];?></td>
          <td align="center" bgcolor="#FFFFFF" class="graytext"><? echo $arr['order'];?></td>
          <td align="center" bgcolor="#FFFFFF"><a href="menuedit.php?id=<? echo $arr['module_id'];?>">编辑</a> <a href="managemenu.php?id=<? echo $arr['module_id'];?>&action=del" onclick="javascript:return   confirm('真的要删除此用户吗？');">删除</a></td>
        </tr>
<?php		
	}
}
?>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
