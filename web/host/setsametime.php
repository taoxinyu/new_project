<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();

if ($_POST['submitNtp']) {
	checkac('修改');
	$gaptimes=$_POST['gaptimes'];
	$sql1="UPDATE 'sametime' SET 'gaptime' = $gaptimes";	
    $sh=file($crontab);
    foreach($sh as $k=>$row){
		if(strstr($row,$ntp))unset($sh[$k]);
    }
    $sh[]="0 0 */$gaptimes * * root $ntp\n";
    file_put_contents($crontab,implode("",$sh));
	if ($as=$db->query($sql1)) {
		$mesNtp="时间间隔设置成功！";
	}
	else 
	{
		$mesNtp="时间间隔设置失败，请重试！";
	}
	
	$timeIP=$_POST['localIP'];
	//$sameIP="/ximorun/ximorun/ntp";
	$a=$ntpdate." ".$timeIP."\n";

	writeShell($ntp,$a);
	$mesNtp.="同步IP设置成功！";
//	if(!writeShell($ntp,$a))
//	{
//		$mesNtp.="同步IP设置成功！";
//	}
//	else 
//	{
//		$mesNtp.="同步IP设置失败，请重试！";
//	}
	writelog($db,'时间同步设置',$mesNtp);
	showmessage($mesNtp,'setsametime.php');	
}

if ($_GET['testNtp']) {
	checkac('应用');
	$cmds=read_file($ntp);
	exec("/usr/sbin/ntpdate ".$_GET['time'],$sameerror,$interror);
	if($interror==0) {
		writelog($db,'时间同步设置','同步时间成功');
		showmessage('同步时间成功','setsametime.php');
	}
	else
	{
		writelog($db,'时间同步设置','同步时间失败');
		showmessage('同步时间失败！请重试','setsametime.php');
	}
		
}

$query1=$db->query("select * from sametime");
$row1=$db->fetchAssoc($query1);
$readtime=$row1['gaptime'];

$strIP=read_file($ntp);
preg_match("/((\d){1,3}.){3}(\d){1,3}/",$strIP,$arrIP);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>时间同步设置</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<script language="javascript">

function checks(){
	if(document.gaptime.gaptimes.value == ''){	
		alert('请输入天数！');
		document.gaptime.gaptimes.select();
		return false;		
	}
	else
	{
		if(!checkInt(document.gaptime.gaptimes.value))
		{
			alert('请输入数字！');
			document.gaptime.gaptimes.select();
			return false;
		}
	}
	
	if(document.gaptime.localIP.value == '')
	{
		alert('请输入IP地址');
		document.gaptime.localIP.select();
		return false;
	}
	else
	{
		if(!checkip(document.gaptime.localIP.value))
		{
			alert('IP地址格式有误');
			document.gaptime.localIP.select();
			return false;
		}
	}
	
	return true;
}
function checkip(ip){
	var reg = /^\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b$/; 
	if (!reg.test(ip)) { 
		
	return false; 
	} 
	return true; 
}
function checkInt(str)
{
	var newPar=/^[0-9]*[1-9][0-9]*$/;
	if(!newPar.test(str))
	{
		return false;
	}
	

		return true;

}

</script>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 时间同步设置</div>
     <div class="content"><form id="gaptime" name="gaptime" method="POST" action="setsametime.php" onsubmit="return checks();">
	  <table width="768" align="center" class="s s_form">
       <tr>
          <td colspan="2" class="caption">时间同步设置</td>
        </tr>  
         <tr>
          <td>设置间隔时间：</td>
          <td ><input name="gaptimes" type="text" id="gaptimes" value="<?php echo $readtime; ?>" />天&nbsp;&nbsp;&nbsp;</td>
          </tr>   
        <tr>
          <td >NTP服务器IP：</td>
          <td><input name="localIP" type="text" id="localIP" value="<?php echo $arrIP[0] ?>" />ipv4地址</td>
        </tr>
         <tr>
          <td colspan="2" class="footer"><input type="submit" name="submitNtp" value="保存" onclick="return checks();" />&nbsp;<a href="setsametime.php?testNtp=1&time=<?php echo $arrIP[0]; ?>">时间同步</a>（立即生效）
        </td></tr>         
		
      </table>
        </form></div>
<div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
