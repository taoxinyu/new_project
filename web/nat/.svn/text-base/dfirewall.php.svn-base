<?
include ('../include/comm.php');
$pageaccess=0;
checklogin();
//checkaccess($pageaccess,$_SESSION['role']);
checkac();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><? echo $system['xmtactype'];?></title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style>
.s td.title{background:#e7f4ff; width:30%;}
</style>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
</head>
<?
if($_GET['action']=='del'){
	
	$db->query("delete from firewall where fwid=".$_GET['id']);
	$db->query("update firewall  set fwisapp=0");
	$db->query("update isapp set firewall=1");
	
}

if ($_GET['action']=='shut') {
	exec('cat '.$firewall,$arrfw);
	//var_dump($arrfw);
	unset($arrfw[count($arrfw)-1]);
	foreach ($arrfw as $key=>$value)
	{
		if (strchr($value,'LOG --log')) {
			unset($arrfw[$key]);
		}
	}
	$shutStr=join("\n",$arrfw);
	writeFile($firewall,$shutStr);
	showmessage('完成关闭','dfirewall.php');
}

?>
<?
//判断是否有写到文件
$sql="select * from isapp";
$query=$db->query($sql);
$row=$db->fetch_array($query);
$count=$row['firewall'];
?>
<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; 端口防火墙 </div>
<ul class="tab-menu">
    <li class="on"><span>防火墙规则</span> </li>
    <li><a href="dfirewall_add.php">添加防火墙</a></li>	  
</ul>
<div class="content">

<?php
if ($count>0) {
	$sqlos="select osport from firewall";
	$rows=$db->fetchAssoc($db->query($sqlos));
	//echo $db->error();
	$osport=$rows['osport'];
?>
<form name="setfw" id="setfw" action="setfw.php" method="POST">
    <table width="500" class="s s_form">
    
    <tr >
        <td colspan="2" class="caption">应用防火墙设置</td>
      </tr>
     <tr>
         <td class="title">全部（未指定）端口状态：</td>
         <td>
         <select name="osport" id="osport">
         <option value="0" <?php if($osport==0) echo 'selected'; ?> >关闭</option>
         <option value="1" <?php if($osport==1) echo 'selected'; ?> >开启</option>
         </select>
        </td>
      </tr>
      <tr>
          <td colspan="2" class="footer">
			<input type="submit" name="theseport" value="保存" />（立即生效）
          </td>
        </tr>
     </table></form>
  
<?php } ?>
<table width="95%" class="s s_grid">
      <tr >
        <td colspan="9"class="caption">防火墙规则</td>
      </tr>
      <tr>
        <th>序号</th>
        <th>
          名称
        </th>
        <th>动作</th>
        <!-- <th>方向</th> -->
		<!-- <th>时间计划</th> -->
        <th>协议与服务</th>
        <th>源IP</th>
        <th>目的IP</th>
		<th>网口</th>
        <th>状态</th>
        <th>管理</th>
      </tr>
    <?
		$query=$db->query("select * from firewall,timeset,portlist where firewall.fwtime=timeset.tid and firewall.fwprotol=portlist.plid and checkall=1 order by fwnumber desc");
while($row = $db->fetch_array($query))
{

$bg="";
	if($row['fwisapp']==0)
	{
		$bg="bg_red";
	}
	if($row['fwstate']==0)
	{
		$bg="off";
	}
?>
      <tr class="<?echo $bg?>" onmouseover="javascript:this.bgColor='#fdffc5';" onmouseout="javascript:this.bgColor='<?echo $bg?>';">
           <td><?echo $row['fwnumber']?></td>
        <td><?echo $row['fwname']?></td>
        <td><?if($row['fwaction']==1){echo "通过";}else {echo "拒绝";}?></td>
        <td><?echo $row['plname'];?><?if($row['fwprotol']==0 || $row['fwprotol']==-1)echo "(".$row['fwport'].")";?></td>
        <td><?echo $row['fwsip'];?></td>
        <td><?echo $row['fwdip'];?></td>
		<td><?echo $row['fwwk']?></td>
        <td><?if($row['fwstate']==0){echo "停用状态";}else{echo "启用状态";}?></td>
        <td><a href="dfirewall_mode.php?id=<? echo $row['fwid'];?>">编辑</a> <a href="?id=<? echo $row['fwid'];?>&action=del" onclick="javascript:return   confirm('真的要删除吗？');">删除</a></td>
      </tr>
      <?
		}
		$db->free_result($query);
		$db->close();		
		?>
    </table>      
    </div><div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
