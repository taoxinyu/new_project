<?php
include ('../include/comm.php');
$pageaccess=2;
checklogin();
//checkaccess($pageaccess,$_SESSION['role']);
checkac('应用');

exec('/xmdns/sh/acl_check.sh');
exec('/xmdns/sh/checkzone /etc/namedb/master/'); //运行检测程序
exec('/xmdns/sh/acl_check.sh');

$zonename = "/etc/namedb/check/zone_name.t";
$zone = file($zonename);

$info = "/etc/namedb/check/info.log";
$ips = file($info);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>检测域名记录</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<script src="/js/jquery.js"></script>
<script src="/js/ximo_dns.js"></script>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
.STYLE1 {font-size:12px; color:#420505; margin-left:30px; font: "宋体";}
-->
</style></head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 检测域名记录</div>
<ul class="tab-menu">    
    <li><a href="domain.php">域名管理</a></li>
	<li><a href="domain_add.php">域名添加</a></li>
    <li><a href="domaingroup.php">域名转发管理</a></li>
	<li><a href="domain_input.php">批量导入</a></li>
    <li><a href="domain_output.php">域名导出</a></li>
	<!--li  class="on"><span>检测域名记录</span></li-->
    <li><a href="domain.php?ac=app">应用设置到系统</a></li>   
</ul>
<div class="content"> 

  	<table width="768" class="s s_grid">
	  <tr>
          <td  colspan="5" class="caption" >检测域名记录</td>
        </tr>
  		<th>线路</th>
  		<th>记录</th>
  		<th>类型</th>
  		<th>优先级</th> 
  		<th>解析结果</th>
  	
  	</tr>
	<? 
	for ($i=0; $i<sizeof($zone); $i++){
	?>
	<tr>
		<? 
		$cells = explode(' ', trim($zone[$i]));
			for ($j=0; $j<sizeof($cells); $j++){
		?>
		<td><?php echo $cells[$j]?></td>
		<? }?>
		<!-- 优先级 解析结果 -->
		<?php
		$yss = '';
		$jxs = '';
		if ( strpos( $ips[$i], '|') ){ //有"|"
			
			$ys = array();
			$jx = array();
			$aa=explode('|', trim($ips[$i]));
			foreach ($aa as $a){
				$rd = explode(' ', trim($a));
				$ys[] = $rd[0];
				$jx[] = $rd[1];	
			}
			$yss = implode('<br>', $ys);
			$jxs = implode('<br>', $jx);
		} else {
			$rd = explode(' ', trim($ips[$i]));
			$yss = $rd[0];
			$jxs = $rd[1];	
		}
		$yss = str_replace('#', '', $yss);
		?>
		<td><?php echo $yss?></td>
		<td><?php echo $jxs?></td>
	</tr>
	<? }?>
	</table><div class="push"></div>
</div></div>
<? include "../copyright.php";?>
</body>
</html>