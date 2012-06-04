<? include('include/comm.php');
date_default_timezone_set('Asia/Shanghai');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>西默智能DNS</title>
<link rel="stylesheet" type="text/css" href="divstyle.css"/>
<style>
#toplogo{width:504px;height:67px;float:left;margin-left:auto;margin-right:auto;background:url(<?php echo $topimg;?>);}
</style>
</head>

<body>
<div id="topback">
  <div id="top">
     <div id="toplogo"></div>
	 <div id="topoverright"></div>
	 <div id="topunder">
	 <table width="498" height="26" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="29" height="26"></td>
		<td width="79" height="26"class="toptext"><?php echo $_SESSION['loginname'];?>,您好！</td>
		<td width="31" height="26"></td>
		<td width="174" height="26" class="toptext"><?php  echo date('Y年m月d日 H:i:s');?></td>
		<td width="82" height="26"><a href="desktop.php" target="mainFrame"><img src="images/top_indexbutton.gif" width="82" height="26" border="0" /></a></td>
		<td width="82" height="26"><a href="exit.php" target="_top"><img src="images/top_exitbutton.gif" width="82" height="26" border="0"/></a></td>
		<td width="21" height="26"></td>
	</tr>
</table>
	 </div>
  </div>
</div>
</body>
</html>
