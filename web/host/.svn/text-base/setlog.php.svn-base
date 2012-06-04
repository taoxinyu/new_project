<?
include ('../include/comm.php');
checklogin();
checkac();
checkac('应用');
if(isset($_POST['Submit'])){
	$sql="update logset set logquery='".$_POST['logquery']."',logsafe='".$_POST['logsafe'];
	$sql=$sql."',logdate=".$_POST['logdate'].",logremote='".$_POST['logremote']."',logremoteip='".$_POST['logremoteip']."',logremoteuser='".$_POST['logremoteuser']."',logremotepwd='".$_POST['logremotepwd']."',logremoteport='".$_POST['logremoteport']."',logupdate=datetime('now','localtime') where logid=1";
	$db->query($sql);
	createdns($db,$binddir);
	exec($rndc." stop");
	exec($named);
	$ftpsh='';
	if ($_POST['logremote']) {	
		//将配置写入配置文件
		//$today = date('Ymd');
		//$ftpsh .= "#!/bin/sh\n";
		$ftpsh .= "F=\"$ftp\"\n";
		$ftpsh .= "TD=`date -d \"-1 day\" +%y%m%d`\n";
		$ftpsh .= "echo \"open ".$_POST['logremoteip']." ".$_POST['logremoteport']."\" > \$F\n";
		$ftpsh .= "echo \"user ".$_POST['logremoteuser']." ".$_POST['logremotepwd']."\" >> \$F\n";
		$ftpsh .= "echo \"bin\" >> \$F\n";
		$ftpsh .= "echo \"put \$TD\" >> \$F\n";
		$ftpsh .= "echo \"put op\$TD\" >> \$F\n";
		$ftpsh .= "echo \"put lg\$TD\" >> \$F\n";
		$ftpsh .= "echo \"bye\" >> \$F\n";
		$ftpsh .= "cd $logback\n";
		$ftpsh .= "ftp -i -in < \$F\n";
		$ftpsh .= "rm \$F";
	}
	writeShell($ftpshs,$ftpsh);
	writelog($db,'设置日志',"设置日志内容");
	//写入rc.conf文件
	writercconf($db,$rcfile);
	$db->close();
	showmessage('日志设置成功','setlog.php');
}
else {//读取信息
	$query=$db->query("select * from logset where logid=1");

	$row = $db->num_rows($query);
	
		$query=$db->query("select * from logset where logid=1");
		$row=$db->fetchAssoc($query);
		
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>日志设置</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<script language="javascript">

function checklogin(){
	
	if(document.logset.logremoteip.value == '')
	{
		alert("请输入远程日志IP");
		document.logset.logremoteip.select();
		return false;
	}
	else
	{
		if(!checkip(document.logset.logremoteip.value)){
		
		alert("IP输入有误");
		document.logset.logremoteip.select();
		return false;
		}
	}
	

	if(document.logset.logdate.value ==''){	
			alert("请输入日志保存时间");
			document.logset.logdate.select();
			return false;
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

</script>
</head>

<body>
<div class="wrap">
 <div class="nav">&nbsp;当前位置:&gt;&gt; 日志设置 </div>
 <div class="content">
<form id="logset" name="logset" method="post" action="setlog.php" onsubmit="return checklogin();">
      <table width="700" class="s s_form">
        <tr>
          <td colspan="2" class="caption">日志设置</td>
        </tr>
         <!--tr>
           <td height="25" align="right" bgcolor="#e7f4ff" class="graytext">是否开启本地日志：</td>
           <td height="25" align="left" bgcolor="#FFFFFF"><label>
             <input name="loglocal" type="radio" value="1" <?if($row['loglocal']=="1"){echo "checked='checked'";}?>/>
             开启 
             <input type="radio" name="loglocal" value="0" <?if($row['loglocal']=="0"){echo "checked='checked'";}?> />
             关闭 
           </label></td>
         </tr-->
         <tr>
          <td width="30%">是否开启DNS解析日志：</td>
          <td>
            <input name="logquery" type="radio" value="1" <?if($row['logquery']=="1"){echo "checked='checked'";}?> />
开启
<input type="radio" name="logquery" value="0" <?if($row['logquery']=="0"){echo "checked='checked'";}?> />
关闭 </td>
        </tr>
        <tr>
          <td>是否开启DNS状态日志：</td>
          <td><input name="logsafe" type="radio" value="1" <?if($row['logsafe']=="1"){echo "checked='checked'";}?> />
开启
  <input type="radio" name="logsafe" value="0" <?if($row['logsafe']=="0"){echo "checked='checked'";}?> />
关闭 </td>
        </tr>
        <!--tr>
          <td height="25" align="right" bgcolor="#e7f4ff" class="graytext">是否开启防火墙日志：</td>
          <td height="25" align="left" bgcolor="#FFFFFF"><label>
            <input name="logfirewall" type="radio" value="1"  <?//if($row['logfirewall']=="1"){echo "checked='checked'";}?> />
开启
<input type="radio" name="logfirewall" value="0" <?//if($row['logfirewall']=="0"){echo "checked='checked'";}?> />
关闭 </label></td>
        </tr-->
        <tr>
          <td>是否开启远程日志：</td>
          <td><input name="logremote" type="radio" value="1" <?if($row['logremote']=="1"){echo "checked='checked'";}?> />
开启
  <input type="radio" name="logremote" value="0" <?if($row['logremote']=="0"){echo "checked='checked'";}?> />
关闭 </td>
        </tr>
        <tr>
          <td>远程日志IP：</td>
          <td>
            <input name="logremoteip" type="text" id="logremoteip" value="<?echo $row['logremoteip']?>" />
          </td>
        </tr>
        <tr>
          <td>远程用户名：</td>
          <td>
            <input name="logremoteuser" type="text" id="logremoteuser" value="<?echo $row['logremoteuser']?>" /></td>
        </tr>
         <tr>
          <td>远程密码：</td>
          <td>
          <input name="logremotepwd" type="password" id="logremotepwd" value="<?echo $row['logremotepwd']?>" />
          </td>
        </tr>
         <tr>
           <td>远程端口：</td>
           <td>
             <input name="logremoteport" type="text" id="logremoteport" size="4" value="<?echo $row['logremoteport'];?>" />
           </td>
         </tr>
         <tr>
           <td>日志保存时间：</td>
           <td>
             <input name="logdate" type="text" id="logdate" size="8" value="<?echo $row['logdate'];?>" />
           天</td>
         </tr>
         <tr>
          <td>上次修改时间：</td>
          <td>
          <input name="logupdate" type="text" id="logupdate" value="<?echo $row['logupdate']?>" disabled />
          </td>
        </tr>      
        <tr>
          <td colspan="2" class="footer">
            <input type="submit" name="Submit" value="保存设置" />&nbsp;每天早上5点30分上传前一天日志
          </td>
        </tr>
      </table></form>
	  </div>
 <div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
