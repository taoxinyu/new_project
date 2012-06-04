<?php
include ('../include/comm.php');
checklogin();
checkac();
$mes="";
if($_POST['Submit'])
{
	checkac('修改');
	$dnShape=($_POST['dnShape'])?1:0;
	$dnsTime=$_POST['mdns'];
	$twoHost=($_POST['twoHost'])?1:0;
	$twoTime=$_POST['mtwo'];
	$checkLine=($_POST['checkLine'])?1:0;
	$sql="update setmail set dnShape='".$dnShape."',dnsTime='".$dnsTime."',twoHost='".$twoHost."',twoTime='".$twoTime."',checkLine='".$checkLine."',recMail='".$_POST['recMail']."',recSmtp='".$_POST['recSmtp']."',recPWD='".$_POST['recPWD']."',sendMail='".$_POST['sendMail']."'";
	//echo $sql;
	if ($db->query($sql)) {
		$mes.="邮件发送设置成功！";
	}
	else {
		$mes.="邮件发送设置失败，请重试！";
	}
	writelog($db,'邮件发送设置',$mes);
	showmessage($mes,"setmail.php");
}

$sql="select * from setmail";
$queryOld=$db->query($sql);
$rowOld=$db->fetchAssoc($queryOld);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>邮件设置</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<script language="javascript">
var xmlHttp;
function getXHR()
{
	if(window.ActiveXObject)
	{
		xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	else if(window.XMLHttpRequest)
	{
		xmlHttp = new XMLHttpRequest();
	}
}

function useMail()
{
	getXHR();
	xmlHttp.open("GET","checkrec.php?mail="+document.setMail.recMail.value,true);
	xmlHttp.onreadystatechange = resultMail;
	xmlHttp.send(null);
}

function resultMail()
{
	var resMail = xmlHttp.responseText;
	document.getElementById('checkrec').innerHTML = resMail;
}



function checkMails(){
	if(document.setMail.recMail.value == ''){	
		alert('请输入发件箱地址！');
		document.setMail.recMail.select();
		return false;		
	}
	else
	{
		if(!checkMail(document.setMail.recMail.value))
		{
			alert('发件箱地址有误！');
			document.setMail.recMail.select();
			return false;
		}
	}
	
	if(document.setMail.recSmtp.value == ''){	
		alert('请输入SMTP地址！');
		document.setMail.recSmtp.select();
		return false;		
	}else{
		if(!checkip(document.setMail.recSmtp.value) && !checkurl(document.setMail.recSmtp.value))
		{
			alert('SMTP地址输入有误！');
			document.setMail.recSmtp.select();
			return false;
		}
	}
	if(document.setMail.recPWD.value == ''){	
		alert('请输入密码！');
		document.setMail.recPWD.select();
		return false;		
	}else{
		if(!checkSpace(document.setMail.recPWD.value))
		{
			alert('密码不能输入特殊字符！');
			document.setMail.recPWD.select();
			return false;
		}
	}
	
	if(document.setMail.sendMail.value == ''){	
		alert('请输入收件箱地址！');
		document.setMail.sendMail.select();
		return false;		
	}
	else
	{
		if(!checkMail(document.setMail.sendMail.value))
		{
			alert('收件箱地址有误！');
			document.setMail.sendMail.select();
			return false;
		}
	}
	return true;
}
</script>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 邮件设置</div>
<div class="content">
<form id="setMail" name="setMail" method="post" action="setmail.php" onsubmit="return checkMails()">
      <table width="768" class="s s_form">
        <tr>
          <td colspan="2" class="caption">发送邮件设置</td>
        </tr>
         <tr>
           <td>需要发送的内容：</td>
           <td>
           <input type="checkbox" name="dnShape" id="dnShape" <?php if($rowOld['dnShape']==1) echo "checked" ?> />dns运行状态
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;dns检测时间间隔：<select name="mdns" id="mdns">
              <option value="5" <?php if($rowOld['dnsTime']==5) echo "selected" ?> >5分钟</option>
              <option value="10" <?php if($rowOld['dnsTime']==10) echo "selected" ?> >10分钟</option>
              <option value="30" <?php if($rowOld['dnsTime']==30) echo "selected" ?> >30分钟</option>
              <option value="60" <?php if($rowOld['dnsTime']==60) echo "selected" ?> >60分钟</option>
            </select><br>
           <input type="checkbox" name="twoHost" id="twoHost" <?php if($rowOld['twoHost']==1) echo "checked" ?> />双机热备
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 双机热备检测时间间隔：<select name="mtwo" id="mtwo">
              <option value="5" <?php if($rowOld['twoTime']==5) echo "selected" ?> >5分钟</option>
              <option value="10" <?php if($rowOld['twoTime']==10) echo "selected" ?> >10分钟</option>
              <option value="30" <?php if($rowOld['twoTime']==30) echo "selected" ?> >30分钟</option>
              <option value="60" <?php if($rowOld['twoTime']==60) echo "selected" ?> >60分钟</option>
            </select><br>
           <input type="checkbox" name="checkLine" id="checkLine" <?php if($rowOld['checkLine']==1) echo "checked" ?> />线路监控<br>
           </td>
         </tr>
         <tr>
           <td>发件箱相关设置：</td>
           <td>
           <input name="recMail" type="text" id="recMail" onblur="javascript:useMail()" value="<? echo $rowOld['recMail']; ?>" size="30" /><span id="checkrec">发件箱地址</span><br>
           <input name="recSmtp" type="text" id="recSmtp" value="<? echo $rowOld['recSmtp']; ?>" size="30" />SMTP服务器<br>
           <input name="recPWD" type="password" id="recPWD" value="<? echo $rowOld['recPWD']; ?>" size="30" />发件箱密码
           
</td>
         </tr>
         <tr>
           <td>收件箱：</td>
           <td>
           <input name="sendMail" type="text" id="sendMail" value="<? echo $rowOld['sendMail']; ?>" size="30" />
</td>
         </tr>
        <tr>
          <td  colspan="2"class="footer">
            <input type="submit" name="Submit" value="保存设置" />
          </td>
        </tr>
      </table>
	 </form>
	</div>
<div class="push"></div>
<? $db->close();?></div>
<? include "../copyright.php";?>
</body>
</html>
