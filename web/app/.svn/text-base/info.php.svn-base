<?php
/*
 +-----------------------------------------------------
 * 	2010-2-26
 +-----------------------------------------------------
 *		
 +-----------------------------------------------------
 */

include '../include/comm.php';
checklogin();
checkac();
if (isset($_GET)){
    $id = $_GET['id'];
    $sql = "select * from regroom where id = $id";
    $row = $db->fetchAssoc($db->query($sql));
    
    $sq = "select domainname from domain where domainid=".$row['doid'];
	$r = $db->fetchAssoc($db->query($sq));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>.</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style>
.title{background:#e7f4ff; width:25%; text-align:right;}
</style>
<script src="/js/jquery.js"  type="text/javascript"charset="utf-8" ></script>
<script src="/js/ximo_dns.js"  type="text/javascript" charset="utf-8"></script>

</head>

<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; 域名绑定申请</div>
<div class="content">
<form id="record" name="record" method="post" action="reg.php" onsubmit="return checklogin();">
<table width="600"  class="s s_form">      
        <tr>
          <td colspan="2" class="caption"><?echo $domainname?>域名绑定申请</td>
        </tr>
        <tr>

              <td>域名名称：</td>
              <td>
                <?php echo $row['domain2'].".".$r['domainname'];?>
              </td>
            </tr>
            <tr>
              <td>记录类型：</td>
              <td>
              	<?php echo $row['rtype'];?>
              </td>
            </tr>
            <tr>
              <td>IP(通用)：</td>
              <td>
                <?php echo $row['ip'];?>
              </td>
            </tr>
			<tbody class="hid" style="">
			<?
			$sql = "select * from aclips where status=0 and regroom=".$row['id'];
			$que=$db->query($sql);
			while($res=$db->fetchAssoc($que))
			{
			?>
            <tr>
              <td>IP(<?php echo $res['aclname']?>)：</td>
              <td>
				<?=$res['ip']?>
              </td>
            </tr>		
			<?}?>
			</tbody>
            <tr>
              <td>申请单位：</td>
              <td>
                <?php echo $row['com'];?>
              </td>
            </tr>
            <tr>
              <td>申请人：</td>
              <td>
                <?php echo $row['ownner'];?>
              </td>
            </tr>
            <tr>
              <td>备注：</td>
              <td>
                <?php echo $row['beizhu'];?>
              </td>
            </tr>
   
    </table>
      </form>
	  	</div><div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>