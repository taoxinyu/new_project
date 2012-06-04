<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();

if(isset($_POST['Submit'])){
    checkac('添加');
    $sql="insert into yz (yzname,yzip,yztime) values('".$_POST['yzname']."','".$_POST['yzip']."',".$_POST['yztime'].")";	
    $db->query($sql);
    $db->close();
    showmessage('添加成功!','host.php');		

}
if(isset($_GET['ac']))
{
	if($_GET['ac']=='del')
	{
		checkac('删除');
		$sql="delete from yz where id=".$_GET['id'];
		$db->query($sql);
	}
	if($_GET['ac']=='stop')
	{
	    checkac('应用');
		$sql="update yz set yzis=0 where id=".$_GET['id'];
		$db->query($sql);
		
	}
	if($_GET['ac']=='start')
	{
	    checkac('应用');
		$sql="update yz set yzis=1 where id=".$_GET['id'];
		$db->query($sql);
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>监控主机设置</title>
<link href="../divstyle.css" rel="stylesheet" type="text/css" />

</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="28" align="left" background="../images/bg_topbg.gif">&nbsp;当前位置:&gt;&gt; 监控主机设置</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="857" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <td width="234" height="30" align="center" bgcolor="#99FF00" class="graybg">监控名称</td>
        <td width="169" height="30" align="center" bgcolor="#99FF00" class="graybg">监控主机IP</td>
        <td width="109" height="30" align="center" bgcolor="#99FF00" class="graybg">监控方式</td>
        <td width="73" align="center" bgcolor="#99FF00" class="graybg">状态</td>
        <td width="74" align="center" bgcolor="#99FF00" class="graybg">启用/停用</td>
        <td width="74" height="30" align="center" bgcolor="#99FF00" class="graybg">检测时间</td>
        <td width="88" height="30" align="center" bgcolor="#99FF00" class="graybg">管理</td>
      </tr>
      <?
    
		$query=$db->query("select * from yz order by id desc");
while($row = $db->fetchAssoc($query))
{
?>
      <tr>
        <td height="25" align="center" bgcolor="#FFFFFF" class="graytext"><?echo $row['yzname']?></td>
        <td height="25" align="center" bgcolor="#FFFFFF" class="graytext"><?echo $row['yzip']?></td>
        <td height="25" align="center" bgcolor="#FFFFFF" class="graytext">PING检测方式</td>
        <td align="center" bgcolor="#FFFFFF" class="graytext"><a href="mhost.php?ip=<?echo $row['yzip']?>" target="_blank">点击查看</a></td>
        <td align="center" bgcolor="#FFFFFF" class="graytext"><?if($row['yzis']=='1'){echo '启用中';}else{echo '停用中';}?>&nbsp;</td>
        <td height="25" align="center" bgcolor="#FFFFFF" class="graytext"><?echo $row['yztime']?>分钟</td>
        <td height="25" align="center" bgcolor="#FFFFFF" class="graytext"> <?if($row['yzis']=='1'){?><a href="?id=<?echo $row['id']?>&ac=stop" onclick="javascript:return   confirm('真的要停止解析本记录吗？');">停用</a><?}else{?><a href="?id=<?echo $row['id']?>&ac=start" onclick="javascript:return   confirm('真的要启用解析本记录吗？');">启用</a><?}?>  | <a href="?ac=del&id=<?echo $row['id']?>" onclick="javascript:return   confirm('真的要删除此监控主机吗?');">删除</a></td>
      </tr>
      <?}
      $db->close();?>
    </table></td>
  </tr>
</table>
<? include "../copyright.php";?>
</body>
</html>
