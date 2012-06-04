<?php
include '../include/comm.php';
checklogin();
checkac();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>申请列表</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style>
.title{background:#e7f4ff; width:25%; text-align:right;}
</style>
<script src="/js/jquery.js"  type="text/javascript"charset="utf-8" ></script>
<script src="/js/ximo_dns.js"  type="text/javascript" charset="utf-8"></script>
</head>

<body>
<div class="wrap">
<div class="content">
      <table width="768" class="s s_grid">
      	<tr>
          <td colspan="8" class="caption">申请列表</td>
        </tr>
            <tr>
              <td>ID</td>
              <td>二级域名</td>
              <td>域名</td>
              <td>IP</td>
              <td>申请单位</td>
              <td>申请人</td>
              <td>申请时间</td>
            </tr>
            <?
		$query=$db->query("select * from regroom where state=0");
		while($row = $db->fetchAssoc($query))
		{
			$bg="#ffffff";
			$sq = "select domainname from domain where domainid=".$row['doid'];
			$r = $db->fetchAssoc($db->query($sq));
		?>
            <tr>
              <td bgcolor="<?echo $bg?>"><?echo $row['id']?></td>
              <td bgcolor="<?echo $bg?>"><?echo $row['domain2']?></td>
              <td bgcolor="<?echo $bg?>"><?echo $r['domainname']?></td>			
              <td  bgcolor="<?echo $bg?>">
			    <?
				echo "通用：".$row['ip']."<br>";
				$que=$db->query("select * from aclips where regroom=".$row['id']);
				while($r = $db->fetchAssoc($que))
				{
					echo $r['aclname'].":".$r['ip']."<br>";
				}
				?>
			  </td>			 
              <td bgcolor="<?echo $bg?>"><?echo $row['com']?></td>
              <td bgcolor="<?echo $bg?>"><?echo $row['ownner']?></td>
              <td bgcolor="<?echo $bg?>"><?echo $row['time']?></td>
            </tr>
        <?}
      	?>
      </table>
 </div><div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>