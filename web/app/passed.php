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
if (isset($_GET['del'])){
    $id = $_GET['del'];
    $sql = "delete from regroom where id=".$id;
    $db->query($sql);
	$db->query("delete from aclips where regroom=".$id);
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
<div class="position">&nbsp;当前位置:&gt;&gt; 已通过申请</div>
 <div class="content">

      <table width="768" class="s s_grid">
      	<tr>
          <td colspan="7" class="caption">已通过申请</td>
        </tr>
            <tr>
              <th>二级域名</th>
              <th>域名</th>
              <th>IP</th>
              <th>申请单位</th>
              <th>申请人</th>
              <th>申请时间</th>
              <th>管理</th>
            </tr>
            <?
		$query=$db->query("select * from regroom where state=1");
		while($row = $db->fetchAssoc($query))
		{
			$bg="#ffffff";
			$sq = "select domainname from domain where domainid=".$row['doid'];
			$r = $db->fetchAssoc($db->query($sq));
		?>
            <tr>
              <td><?echo $row['domain2']?></td>
              <td><?echo $r['domainname']?></td>
              <td><?echo "通用：".$row['ip']."<br>";?>
			    <?
				$que=$db->query("select * from aclips where status=1 and regroom=".$row['id']);
				while($r = $db->fetchAssoc($que))
				{
					echo $r['aclname'].":".$r['ip']."<br>";
				}
				?>
			  </td>
              <td><?echo $row['com']?></td>
              <td><?echo $row['ownner']?></td>
              <td><?echo $row['time']?></td>
               <td><a href="?del=<? echo $row['id']?>" >删除</a></td>
            </tr>
        <?}
      	?>
      </table>
 </div><div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>