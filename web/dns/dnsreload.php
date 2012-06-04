<? include ('../include/comm.php');
include ('../mail/sendmail.php');
$time=date('Y-m-d H:i:s');
$pageaccess=2;
checklogin();
checkac();
exec( $rndccmd." status", &$dnsstatus );
$dnsstatus = join( "<br>", $dnsstatus );	
if($dnsstatus!=""){
		$mydns="DNS正常运行中....";
		$dns=1;
}else 
{
	$mydns="DNS已经停止服务....";
	$dns=0;
}
if($_GET['op']=='reload'){
	checkac('应用');		  
//	exec( $rndccmd." reload", &$ping );
	exec( $rndccmd." stop" );
	exec( $named, &$ping);
	exec( $rndccmd." status", &$dnsstatus );
	$dnsstatus = join( "<br>", $dnsstatus );	
	if($dnsstatus!=""){
    $nowstatus=1;
	}else 
		{
			$nowstatus=0;
		}
//	$ping = join( "<br>", $ping );
	if($nowstatus==0){
		$s1='';
	}else{
		$s1="DNS服务重载完成！";
		$rowmail=$db->fetchAssoc($db->query("select * from setmail"));
		if($rowmail['dnShape']==1){
			$subject='DNS服务变更';
			$body=$time.'时，您的DNS服务已经被重载一次，特发此邮件通知。';
			$sendName=split('@',$rowmail['recMail']);
			sendMail($rowmail['recSmtp'],$sendName[0],$rowmail['recPWD'],$rowmail['recMail'],$subject,$body,$rowmail['sendMail']);
		}
	}
	writelog($db,'DNS RELOAD操作','重新装载DNS设置');
	showmessage("DNS服务重载完成！",'dnsreload.php?s='.$s1);
} 
// 启动DNS
if($_GET['op']=='start'){ 
	checkac('应用');
	//exec( $namedcmd, &$ping );
	// exec('/ximolog/startnamed.sh');
	exec($named);
	// echo "DNS服务将在一分钟内启动完成,请稍候！";
	writelog($db,'DNS启动操作','启动DNS解析服务');
	$rowmail=$db->fetchAssoc($db->query("select * from setmail"));
	if($rowmail['dnShape']==1){
		$subject='DNS服务变更';
		$body=$time.'时，您的DNS服务已经被启动一次，特发此邮件通知。';
		$sendName=split('@',$rowmail['recMail']);
		sendMail($rowmail['recSmtp'],$sendName[0],$rowmail['recPWD'],$rowmail['recMail'],$subject,$body,$rowmail['sendMail']);	  		
	}
	showmessage("DNS服务启动完成！",'dnsreload.php');
}
// 停止DNS
if($_GET['op']=='stop'){  
	checkac('应用');
	$rowmail=$db->fetchAssoc($db->query("select * from setmail"));
	if($rowmail['dnShape']==1){
		$subject='DNS服务变更';
		$body=$time.'时，您的DNS服务已经被停止一次，特发此邮件通知。';
		$sendName=split('@',$rowmail['recMail']);
		sendMail($rowmail['recSmtp'],$sendName[0],$rowmail['recPWD'],$rowmail['recMail'],$subject,$body,$rowmail['sendMail']);	  		
	}
	exec( $rndccmd." stop", &$ping );
	$ping = join( "<br>", $ping );	
	exec( $killallcmd." named" );
	writelog($db,'DNS停止操作','停止DNS解析服务');
	showmessage("DNS服务停止完成！",'dnsreload.php?s=DNS服务停止完成！');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="refresh" content="40" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="cache-control" content="no-cache" />
<title>DNS工具使用</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.redtext{ color:red;}
<!--
body {
	background-color: #FFFFFF;
}
.STYLE1 {font-size:12px; color:#420505; margin-left:30px; font: "宋体";}
-->
</style>
</head>

<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; DNS管理工具</div>
      <div class="content"><table width="768"  class="s s_form">
        <tr>
          <td class="caption">DNS管理工具使用</td>
        </tr>
        <tr >
          <td>当前DNS服务器状态：<span class="redtext"><?echo $mydns?></span> 
          <?if($dns==1){?><a href="dnsreload.php?op=reload" onclick="javascript:return   confirm('请确认是否重载DNS配置？');"><img src="../images/bt_01.gif" width="91" height="31" border="0" align="absmiddle" /></a> <a href="dnsreload.php?op=stop" onclick="javascript:return   confirm('请确认是否停止DNS解析服务？');"><img src="../images/bt_02.gif" width="98" height="31" border="0" align="absmiddle" /></a><?}else{?> <a href="dnsreload.php?op=start" onclick="javascript:return   confirm('请确认是否启动DNS解析服务？');"><img src="../images/bt_03.gif" width="92" height="31" border="0" align="absmiddle" /></a><?}?> </td>
        </tr>
        <tr>
          <td class="t_c"><?
          ?>
           <?if($_GET['s']=='DNS服务将在一分钟内启动完成，请稍候!'&&$dns==1){?><img src="../images/dnsstatus1.jpg" width="218" height="211" /><?}
          if($_GET['s']=='DNS服务重载完成！'&&$dns==1){?><img src="../images/dnsstatus3.jpg" width="218" height="211" /><?}
          if($_GET['s']=='DNS服务停止完成！'&&$dns==0){?><img src="../images/dnsstatus4.jpg" width="218" height="211" /><?}
          if($_GET['s']=='DNS服务将在一分钟内启动完成，请稍候!'&&$dns==0){?><img src="../images/dnsstatus2.jpg" width="218" height="211" /><?}
		  if($_GET['s']==''&&$dns==1){?> <img src="../images/dnsstatus1.jpg" width="218" height="211" /><?}?> 
		 <? if($_GET['s']==''&&$dns==0){?> <img src="../images/dnsstatus4.jpg" width="218" height="211" /><?}?>         
            </td>
          </tr>
      </table></div>
  
<?$db->close();?></div>
<? include "../copyright.php";?>
</body>
</html>
