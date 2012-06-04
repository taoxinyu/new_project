<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();
if (isset($_POST['subcreat']))
{
	checkac('应用');
	
	$sql="update creatsnmpuser set user='".$_POST['username']."',psd='".$_POST['paswd']."',verify='".$_POST['verify']."',state=".$_POST['state']." where csnmpid=1";
	$db->query($sql);
	//设置snmpd
	$rc="com2sec notConfigUser default ".$_POST['username']."\n";
	$rc.=<<<EOT
group otConfigGroup v1 notConfigUser
group otConfigGroup v2c notConfigUser
group tConfigGroup usm notConfigUser
#exec .1.3.6.1.4.1.2021.55 iostat /bin/sh /root/iostat.sh
view systemview included .1.3.6.1.2.1.1
view systemview included .1.3.6.1.2.1.25.1.1
view all included 1.3.6.1.2.1.1.5
view all included 1.3.6.1.2.1.1.3.0
view all included 1.3.6.1.4.1.2021.4.5.0
view all included 1.3.6.1.4.1.2021.4.6.0
view all included 1.3.6.1.4.1.2021.4.14
view all included 1.3.6.1.4.1.2021.10.1.3.1
view all included 1.3.6.1.4.1.2021.10.1.3.2
view all included 1.3.6.1.4.1.2021.10.1.3.3
view all included 1.3.6.1.4.1.2021.11.11.0
view all included 1.3.6.1.4.1.2021.11.9
view all included 1.3.6.1.4.1.2021.11.10
view all included 1.3.6.1.2.1.2.2.1.8
view all included 1.3.6.1.2.1.2.2.1.6 
view all included 1.3.6.1.2.1.4.20.1.1
view all included 1.3.6.1.2.1.2.2.1.10
view all included 1.3.6.1.2.1.2.2.1.16
access notConfigGroup "" any noauth exact all none none

EOT;

	//$rc .="createUser notConfigGroup MD5 \"".$_POST['verify']."\" DES ".$_POST['paswd']."\n";
	//$rc .="rouser ".$_POST['username']."\n";
	writeFile($snmpfile,$rc."\n");
	$a="#!/bin/bash\n";
	$a.="killall snmpd\n";
	if($_POST['state']==1)
	{
		$a.="snmpd -c $snmpdconf -p $snmpdpid\n";

	}
	writeFile($setsnmp,$a);
	chmod($setsnmp,0755);
	exec($setsnmp);
	writelog($db,'创建SNMP',"创建SNMP用户");
	$db->close();
	if($_POST['state']==1){
		showmessage('SNMP设置启用成功','setsnmp.php');
	}else{
		showmessage('SNMP设置关闭成功','setsnmp.php');
	}
}else 
{//读取信息
	
		$query=$db->query("select * from creatsnmpuser where csnmpid=1");
		$row2=$db->fetchAssoc($query);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>SNMP设置</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>

<script language="javascript">

function checklogin2(){
	if(document.createuser.username.value==''){	
			alert("用户名不能为空");
			document.createuser.username.select();
			return false;
	}else{
		if(!checkSpace(document.createuser.username.value)){
			alert("用户名不能输入特殊字符");
			document.createuser.username.select();
			return false;
		}
	}
/*
	if(document.createuser.paswd.value==''){	
			alert("密码不能为空");
			document.createuser.paswd.select();
			return false;
	}else{
		if(!checkSpace(document.createuser.paswd.value) || document.createuser.paswd.value.length < 8){	
			alert("密码长度必须大于8,且不能含有特殊字符");
			document.createuser.paswd.select();
			return false;
		}
	}
	
	if(!checkSpace(document.createuser.verify.value) || document.createuser.verify.value.length < 8){	
			alert("验证码长度必须大于8,且不能含有特殊字符");
			document.createuser.verify.select();
			return false;
	}
*/	
	return true;
}

</script>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; SNMP设置</div>
<div class="content">
<form id="createuser" name="createuser" method="post" action="setsnmp.php" onsubmit="return checklogin2();">
  <table width="768"  class="s s_form">
        <tr>
          <td colspan="2"  class="caption">SNMP V2设置</td>
        </tr>
         <tr>
           <td>用户名：</td>
           <td><label>
             <input name="username" type="text" id="username" value="<?echo $row2['user']?>" />
           </label></td>
         </tr>
<!--
         <tr>
          <td>密&nbsp;&nbsp;码：</td>
          <td><input name="paswd" type="password" id="paswd" value="<?echo $row2['psd']?>"/>MD5认证密码,初始密码:12345678</td>
        </tr>
        <tr>
          <td>密&nbsp;&nbsp;钥：</td>
          <td><input name="verify" type="text" id="verify" value="<?echo $row2['verify']?>" />DES密钥,用于加密传输</td>
        </tr>
-->
        <tr>
          <td>使用例子：</td>
          <td>查看主机名：snmpwalk -v 2c -c pub 192.168.12.123 1.3.6.1.2.1.1.5
		  <!--snmpwalk -v 3 -u notConfigGroup -l AuthNoPriv -a MD5 -A mmmmrrrrr -x DES -X savlamar 192.168.2.110 1.3.6.1.2.1.1.5-->
          </td>
        </tr>
        <tr>
          <td>状态：</td>
          <td>
			<input name="state" type="radio" value="1"  <?if($row2['state']=="1"){echo "checked";}?> />
                开启
                <input type="radio" name="state" value="0" <?if($row2['state']=="0"){echo "checked";}?> />
关闭</td>
		  </td>
        </tr>
        <tr>
          <td colspan="2" class="footer">
            <input type="submit" name="subcreat" value="保存设置" />
          </td>
        </tr>		
      </table></form>
	  </div>
<div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
