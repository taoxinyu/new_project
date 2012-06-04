<?php
require_once '../include/comm.php';
checklogin();
checkac();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GB18030">
<title>ISP信息</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
</head>
<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; ISP信息 </div>
<ul class="tab-menu">
    <li class="on"><span>ISP信息</span> </li>
    <li><a href="ispinfoadd.php">添加ISP信息</a></li>
</ul>
<div class="content"><table class="s s_grid" width="80%" >
<tr><td class="caption" colspan="6">ISP信息</td></tr>
   <tr><th>编号</th>
       <th>ISP</th>
       <th>描述</th>
       <th>类型</th>
       <th>启用状态</th>
       <th>操作</th>
  </tr>
<tbody>
<?
$rs=$db->query("select * from ispinfo;");
while($row=$db->fetch_array($rs))
{
	?>
	<tr  class="<?=$row['state']?'':'disable'?>" >
	<td>
	<?=$row['ispinfoid']?>
	</td>
	<td>
	<?=$row['name']?>
	</td>
	<td>
	<?=$row['desc']?>
	</td>
	<td>
	<?=$row['type']==1?'预定义':'用户定义'?>
	</td>
	<td>
	<?=$row['state']==1?'启用':'禁用'?>
	</td>
	<td>
        <?
        if(getPri('修改'))
        {
        	?>    	
	<a href="ispinfoadd.php?action=modispinfo&ispinfoid=<?=$row['ispinfoid']?>">编辑</a>
		<?
	}
	?>
        <?
        if(getPri('删除'))
        {
        	?>  
	<a href="ispaction.php?action=delispinfo&ispinfoid=<?=$row['ispinfoid']?>">删除</a>
		<?
	}
	?>
	</td>
	</tr>
	<?
}
?>
</tbody>
</table></div>
<div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
