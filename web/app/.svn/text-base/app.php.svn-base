<?php
/*
 +-----------------------------------------------------
 * 	2010-2-4
 +-----------------------------------------------------
 *		
 +-----------------------------------------------------
 */

include '../include/comm.php';
checklogin();
checkac();
if (isset($_GET)){
	$ac = $_GET['ac'];
	$id = $_GET['id'];
	if ($ac == "yes"){
		$sql = "select * from regroom where id=$id";
		$row = $db->fetchAssoc($db->query($sql));
		
		//添加记录
		$sql="insert into drecord (ddomain,dname,dys,dtype,dvalue,dacl,dis,disapp,dupdate)values(";
		$sql .= $row['doid'].",'".$row['domain2']."',0,'".$row['rtype']."','".$row['ip']."','ANY',1,0,datetime('now','localtime'))";
		$db->query($sql);		
		$rr=$db->query("select * from aclips where regroom=".$row['id']);
		$n=1;
		while($res = $db->fetchAssoc($rr))
		{
			
			$db->query("insert into drecord(ddomain,dname,dys,dtype,dvalue,dacl,dis,disapp,dupdate)values(".$row['doid'].",'".$row['domain2']."',0,'".$row['rtype']."','".$res['ip']."','".$res['aclname']."',1,0,datetime('now','localtime'))");
			$db->query("update aclips set status=1 where regroom=".$row['id']);
			$n++;
		}
		$sql="update domain set domainnum=domainnum+".$n." where domainid=".$row['doid'];
		$db->query($sql);
		//生成反向解析
		$doid= $row['doid'];
		require 'ptr.php';
		$sql = "update regroom set state=1 where id =".$_GET['id'];
		$db->query($sql);
		showmessage('申请通过', 'app.php');
	}
	else if ($ac == "no"){
		$sql = "update regroom set state=2 where id=".$_GET['id'];
		$db->query($sql);
		$db->query("update aclips set status=2 where regroom=".$_GET['id']);
		showmessage('申请不通过', 'app.php');
	}
	else {
		
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>线路管理</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
</head>

<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; 申请管理</div>

     <div class="content"> <table width="768" class="s s_grid">
      	<tr>
          <td colspan="8" class="caption">申请管理</td>
        </tr>
            <tr>
              <th>ID</th>
              <th>二级域名</th>
              <th>域名</th>
              <th>IP</th>
              <th>申请单位</th>
              <th>申请人</th>
              <th>申请时间</th>
              <th>管理</th>
            </tr>
            <?
            /*
             * state 0:未审批
             * 		 1：通过
             * 		 2：未通过
             */
		$query=$db->query("select * from regroom where state=0");
		while($row = $db->fetchAssoc($query))
		{
			$bg="#ffffff";
			$sq = "select domainname from domain where domainid=".$row['doid'];
			$r = $db->fetchAssoc($db->query($sq));
		?>
            <tr>
              <td><?echo $row['id']?></td>
              <td><?echo $row['domain2']?></td>
              <td><?echo $r['domainname']?></td>
              <td>
			   <?
				echo "通用：".$row['ip']."<br>";
				$que=$db->query("select * from aclips where status=0 and regroom=".$row['id']);
				while($r = $db->fetchAssoc($que))
				{
					echo $r['aclname'].":".$r['ip']."<br>";
				}
				?>
			  </td>
              <td><?echo $row['com']?></td>
              <td><?echo $row['ownner']?></td>
              <td><?echo $row['time']?></td>
              <td><a href="mode.php?id=<?echo $row['id']?>">修改</a> | <a href="?ac=yes&id=<?echo $row['id']?>">通过</a> | <a href="?ac=no&id=<?echo $row['id']?>">拒绝</a> | <a href="info.php?id=<?echo $row['id']?>" >详细信息</a> </td>
            </tr>
        <?}
      	?>
      </table></div><div class="push"></div></div>

<? include "../copyright.php";?>
</body>
</html>