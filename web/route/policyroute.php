<?php
//策略路由管理
require_once '../include/comm.php';
checklogin();
checkac();
if(isset($_REQUEST['action'])&&$_REQUEST['action']=='del')
{
	checkac('删除');
	$db->query("delete from aclroute where arid=$_REQUEST[arid];");
	$db->query("update isapp set policyroute=1");
}
if(isset($_REQUEST['action'])&&$_REQUEST['action']=='app')
{
	checkac('应用');
	$q_policy=$db->query("select * from aclroute where state=1 order by level,arid");
	$i=252;
	while($r_policy=$db->fetch_array($q_policy))
	{

		$sh_con.="ip route add default via $r_policy[nexthop] table $i\n";
		$sh_con_del.="ip route del default via $r_policy[nexthop] table $i\n";
		$str_from=$r_policy['arsip']==''?'':" from $r_policy[arsip]";
		$str_to=$r_policy['ardip']==''?:" to $r_policy[ardip]";
		$str_priority=$r_policy['level']==''?:" priority $r_policy[level]";
		$sh_con.="ip rule add $str_from $str_to $str_priority table $i\n";
		$sh_con_del.="ip rule del $str_from $str_to $str_priority table $i\n";
		$i--;
		if($i<=0)
			break;
	}
	exec($fpolicy_route_del);
	writeShell($fpolicy_route, $sh_con);
	exec($fpolicy_route);
	writeShell($fpolicy_route_del,$sh_con_del);
	$db->query("update aclroute set isapp=0");
	$db->query("update isapp set policyroute=0");
	showmessage('策略路由应用成功', "policyroute.php");
	exit();
}
//判断是否有写到文件
$sql="select policyroute from isapp";
$query=$db->query($sql);
$row_app=$db->fetch_array($query);
$count=$row_app['policyroute'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<style type="text/css" >
table.thin
{
	margin:10px auto;
	border-collapse:collapse;
	border:1px solid #82C4E8;
}
table.thin td
{
	border:1px solid #82C4E8;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=GB18030">
<title>Insert title here</title>
</head>
<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 策略路由</div>
<ul class="tab-menu">
    <li class="on"><span>策略路由</span> </li>
	<li><a href="aclroute_add.php">添加策略路由</a></li>
	<?php if($count==1){?><li><a href="policyroute.php?action=app"> 应用</a> </li>   <?php }?> 
</ul>
    <div class="content"><table class="s s_grid" width="90%" >
      <tr >
        <td colspan="7" class="caption">策略路由</td>
      </tr>
      <tr>
        <td>序号</td>
        <td>源IP</td>
        <td >目的IP</td>
        <td >下一跳</td>
        <td>优先级</td>
        <td >启用状态</td>
        <td>操作</td>
      </tr>
      <?
		$query=$db->query("select * from aclroute order by level,arid");
		$no=0;
		while($row = $db->fetch_array($query))
		{
			$bg="";
			if($row['isapp']==1)
			{
				$bg="bg_red";
			}
			if((int)$row['state']==0)
			{
				$bg="off";
			}
			$no++;
			?>
	      	<tr class="<?=$bg;?>">
	        <td><?=$no?></td>
	        <td ><?=$row['arsip']?></td>
	        <td  ><?=$row['ardip']?></td>
	        <td  ><?=$row['nexthop']?></td>	        
	        <td><?=$row['level']?></td>
	        <td><?=(int)$row['state']==1?'启用':'禁用'?></td>
	        <td><a  class="linkbtn" href="aclroute_add.php?action=mod&arid=<?=$row['arid']?>">编辑</a> <a href="?action=del&arid=<?=$row['arid']?>" onClick="javascript:return   confirm('真的要删除吗？');">删除</a>

        </td>
      </tr>
      <?
		}
		$db->free_result($query);		
	 ?>
    </table></div>      
<div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
