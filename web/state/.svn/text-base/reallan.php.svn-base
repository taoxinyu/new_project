<?php
include("../include/comm.php");
checklogin();
checkac();
$query = $db->query("select * from netface order by facename");
while($row = $db->fetch_array($query)){
	$eths[] = $row['facename'];
}
$eth = $eths[0];
if (isset($_GET['eth'])){
	$eth = $_GET['eth'];
}
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />

<title>网络接口实时流量监控</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; 网络流量实时监控</div>
<div class="content">
      <table width="708" class="s">
        <tr>
          <td class="caption"><?php echo $clan?>网络接口实时流量监控</td>
        </tr>
         <tr>
          <td>请选择网络接口：
            <select onchange="window.location='?eth='+this.value" size="1" name="if">
        <?php
      foreach ($eths as $v){
      	//echo $v.'  '.$eth;
      ?>
      <option value="<? echo $v?>" <? if ($v == $eth) echo "selected"?> ><? echo $v?></option>
      <? }?>
     		</select>
     	 </td>
        </tr>
        
        <tr>
		
          <td height="380" colspan="2" class="bluebg"><embed src="graph_net.php?ifnum=<?php echo $eth?>" type="image/svg+xml"
                width="708" height="354" pluginspage="http://www.adobe.com/svg/viewer/install/auto" /></td>
        </tr>
        <tr>
          <td colspan="2" class="footer"><strong><font color="FF0000">注意:</font></strong></span> 如果您看不到图形，可能您需要安装SVG插件。请下载安装插件：<a href="http://www.adobe.com/svg/viewer/install/" target="_blank">Adobe SVG viewer</a>.</td>
        </tr>
      </table><div class="push"></div></div></div>
 <?php  include ("../copyright.php")?>
</body>
</html>
