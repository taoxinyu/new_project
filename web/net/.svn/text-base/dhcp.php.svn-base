<?
include ('../include/comm.php');
//$pageaccess=0;
checklogin();
checkac();
//checkaccess($pageaccess,$_SESSION['role']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><? echo $system['xmtactype'];?></title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
</head>
<?
if($_GET['ac']=='del'){
	checkac('删除');
	$sql = "delete from dhcp where dhid =".$_GET['id'];
	$db->query($sql);
	$db->query('update isapp set dhcp=1');
	showmessage("删除成功", "dhcp.php");
}

?>
<?
//判断是否有写到文件
$sql="select * from isapp";
$query=$db->query($sql);
$row=$db->fetch_array($query);
$count=$row['dhcp'];
?>
<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; DHCP设置 </div>
<ul class="tab-menu">
    <li class="on"><span>DHCP设置列表</span> </li>
    <li><a href="dhcp_add.php">添加DHCP设置</a></li>
	<li><a href="dhcpuser.php">DHCP用户列表</a></li>
	<?if($count>0){?>
    <li><a href="setdhcp.php">应用</a></li><?}?>	  
</ul>
<div class="content"><table width="90%"  class="s s_grid" >
      <tr >
        <td colspan="10" class="caption">DHCP设置列表</td>
      </tr>
      <tr>
        <th>网络接口</th>
        <th>网段及子网掩码</th>
        <th>分配地址段</th>
        <th>网关</th>
        <th>WINS</th>
        <th>DNS</th>
        <th>租约时间</th>
        <th>状态</th>
        <th>管理</th>
      </tr>
      <?
	$query=$db->query("select * from dhcp  order by dhid desc");
	while($row = $db->fetch_array($query))
	{
		$bg="";
		if($row['dhisapp']==0)
		{
			$bg="bg_red";
		}
		if($row['dhstate']==0)
		{
			$bg="off";
		}
		?>
      	<tr class="<?echo $bg?>" onmouseover="javascript:this.bgColor='#fdffc5';" onmouseout="javascript:this.bgColor='<?echo $bg?>';">
     	<td><?echo $row['dheth']?></td>
        <td><?echo "网段:".$row['dhip']."<br>掩码".$row['dhmask'];?></td>
        <td><?echo "开始:".$row['dhrange']."<br>结束:".$row['dhrange1'];?></td>
        <td><?echo $row['dhgateway']?></td>
        <td><?echo $row['dhwig1']."<br>".$row['dhwig2'];?></td>
        <td><?echo $row['dhdns1']."<br>".$row['dhdns2'];?></td>
        <td>
        <?
        if((int)$row['defaultrelease']>0)
        {
        	?>
        	默认<?echo $row['defaultrelease']?>秒<br />
        	<?
        }
        if((int)$row['maxrelease']>0)
        {
        	?>        
			最大<?echo $row['maxrelease']?>秒
        	<?
        }
        ?>		
		</td>
        <td><?if($row['dhstate']==0){echo "停用状态";}else{echo "启用状态";}?></td>
        <td><a href="dhcp_edit.php?id=<? echo $row['dhid'];?>">编辑</a> <a href="?id=<? echo $row['dhid'];?>&ac=del" onclick="javascript:return confirm('真的要删除吗？');">删除</a></td>
    </tr>
      <?
		}
		$db->free_result($query);
		$db->close();
		?>
    </table></div>
<div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
