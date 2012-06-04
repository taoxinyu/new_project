<?
include ('../include/comm.php');
$pageaccess=2;
checklogin();
checkac();
/*
 *线路存在setacl数据表中
 *type 为 1 表示是添加的线路
 *type 为 0 表示是默认的线路
 *
 *在/etc/namedb/acl 目录下
 *默认线路IP存放在 XXX_M 文件中
 *用户添加IP存放在 XXX_ADD 文件中
 *两个文件中IP合起来存 XXX 文件中
 */

/*以前的代码，有问题
if(isset($_POST['Submit'])){
	if ($_POST['type'] == 0){ //默认线路
		$def = file($binddir."acl/".$_POST['aclident']."_M");
		//$rc="acl \"".$_POST['aclident']."\" {\n";
		$rc=$rc.preg_replace("/\\r\\n/","\n",$_POST['aclip']);
		
		$rcc=preg_replace("/\\r\\n/","\n",$_POST['aclcip']);
		
		$rc=$rc.$rcc;
		$rc=$rc."\n};\n";
		writeFile($binddir."acl/".$_POST['aclident'],$rc);
		writeFile($binddir."acl/".$_POST['aclident']."_ADD",$rcc);
	    showmessage('线路IP区域修改成功','acl.php');
	} else {	//自添加线路
		$rc="acl \"".$_POST['aclident']."\" {\n";
		$rc=$rc.preg_replace("/\\r\\n/","\n",$_POST['aclip']);
		$rc=$rc."\n};\n";
		writeFile($binddir."acl/".$_POST['aclident'],$rc);
	    showmessage('线路IP区域修改成功','acl.php');		
	}
	
}else 
{//读取信息
	
	$areaflag=$_GET['aclname'];
	if ($_GET['type'] == 0)
		$max=file($binddir."acl/".$areaflag."_M");
	else 
		$max=file($binddir."acl/".$areaflag);
	$newfp="";
	for($i=1;$i<count($max)-1;$i++)
	{   
	    if(trim($max[$i]) != "")  //删除文件中的所有空行
	    {   
	        $newfp.=$max[$i];    //重新整理后的数据
	    }   
	}
	if ( file_exists($binddir."acl/".$areaflag."_ADD") && ($_GET['type'] == 0) ){
		$max2=file($binddir."acl/".$areaflag."_ADD");	
		$newfp2="";		   
		for($i=0;$i<count($max2);$i++)
		{   
		    if(trim($max2[$i]) != "")  //删除文件中的所有空行
		    {   
		        $newfp2.=$max2[$i];    //重新整理后的数据
		    }   
		} 
	}  
}
*/

if(isset($_POST['Submit'])){
	checkac('修改');
	$acl = "";
	if ($_POST['type'] == 0){ //默认线路
		$def = file($binddir."acl/".$_POST['aclident']."_M");
		$n = count($def); //$def的行数
		unset($def[0]);
		unset($def[$n-1]);
		$defs = implode("", $def);
		$acls = explode("\r\n",$_POST['aclcip']);
		for($i=0;$i<count($acls);$i++){
			if(!empty($acls[$i])){
				$acls[$i] = str_replace(";",'',$acls[$i]);
				$acls[$i] = str_replace("；",'',$acls[$i]);
				$acl.=$acls[$i].";\n";
			}
		}
		$rcc = $acl;		
		$rc = "acl \"".$_POST['aclident']."\" {\n";
		$rc .= $defs;
		$rc .= $rcc;
		$rc .= "\n};\n";
		$sql="update setacl set aclisapp='0' where aclid=".$_POST['id'];
		$db->query($sql);
		writeFile($binddir."acl/".$_POST['aclident'],$rc);
		writeFile($binddir."acl/".$_POST['aclident']."_ADD",$rcc);
	    showmessage('线路IP区域修改成功','acl.php');
	} else {	//自添加线路
		$rc="acl \"".$_POST['aclident']."\" {\n";

		$acls = explode("\r\n",$_POST['aclcip']);
		for($i=0;$i<count($acls);$i++){
			if($acls[$i]!=""){
				$acls[$i] = str_replace(";",'',$acls[$i]);
				$acls[$i] = str_replace("；",'',$acls[$i]);
				$acl.=$acls[$i].";\n";
			}
		}
		$rc=$rc.$acl;
		$rc=$rc."\n};\n";
		$sql="update setacl set aclisapp='0' where aclid=".$_POST['id'];
		$db->query($sql);
		writeFile($binddir."acl/".$_POST['aclident'],$rc);
	    showmessage('线路IP区域修改成功','acl.php');		
	}
	
}else 
{//读取信息
	
	$areaflag=$_GET['aclname'];
	$newfp="";
	if ($_GET['type'] == 0){ //默认线路
		$max=file($binddir."acl/".$areaflag."_ADD");
		for($i=0;$i<count($max);$i++)
		{
		    if(trim($max[$i]) != "")  //删除文件中的所有空行
		    {  $max[$i] = str_replace(";",'',$max[$i]);
				$max[$i] = str_replace("；",'',$max[$i]);
		        $newfp.=$max[$i];    //重新整理后的数据
		    }   
		}
	}else {
		$max=file($binddir."acl/".$areaflag);
		for($i=1;$i<count($max)-1;$i++)
		{
		    if(trim($max[$i]) != "")  //删除文件中的所有空行
		    {   $max[$i] = str_replace(";",'',$max[$i]);
				$max[$i] = str_replace("；",'',$max[$i]);
		        $newfp.=$max[$i];    //重新整理后的数据
		    }   
		}				
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>线路IP设置</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<script type="text/javascript">

function formatIP()
{
var ip = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
 var ipd = /^((\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.){0,3}(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\/(\d|1\d|2\d|3[0-2])$/;
	var newStr="";
	var inputs=document.getElementById('aclcip').value;
	
	if(inputs!=""){
		var arrIP=inputs.split("\n");
		for(var i=0;i<arrIP.length;i++)
		{
			arrIP[i] = arrIP[i].replace(";","");
			arrIP[i] = arrIP[i].replace("；","");
			if(arrIP[i]!="")
			{
				if(!ip.test(arrIP[i].replace("\r","")) && !ipd.test(arrIP[i].replace("\r","")))
				{
					alert("您有不正确的输入");
					document.getElementById('aclcip').select();
					return false;
				}
			}
			
	  }
  }
	return true;
	
}
</script>
</head>

<body>
<div class="wrap">
<ul class="tab-menu">
    <li><a href="acl.php">线路管理</a></li>
    <li  class="on"><span>修改线路IP区域</span></li>
</ul>

<div class="content">
<form id="setacl" name="setacl" method="post" action="acl_ip.php" onsubmit="return formatIP();" >
<table width="98%" class="s s_form">
        <tr>
        <td colspan="2" class="caption"><image src="/img/grid.gif"> 修改线路IP区域</td>
      </tr>
      <tr>
        <td>线路标识：</td>
        <td><?echo $areaflag?>
              <input name="aclident" type="hidden" id="aclident" value="<?echo $areaflag?>" />
			  <input name="id" type="hidden" id="id" value="<?echo $_GET['id'];?>" />
        </td>
      </tr>
      
<?php
	if ($_GET['type'] != 0){
?>
      <tr>
        <td><? echo "IP区域表";?></td>
        <td>
        	<textarea name="aclcip"  cols="60" rows="15" id="aclcip"><? echo $newfp?></textarea>
        </td>
      </tr>

      
<?}
 if ($_GET['type'] == 0){
?>
      <tr>
        <td>自定义IP区域表：</td>
        <td>
        	<textarea name="aclcip" cols="60" rows="10" id="aclcip"><? echo $newfp?></textarea>
        </td>
      </tr>
<? } ?>
      <tr>
        <td colspan="2" class="footer">
	        
	          <input type="hidden" id="typy" name="type" value="<? echo $_GET['type'];?>" />
	          <input type="submit" name="Submit" value="保存设置" onsubmit="return formatIP();"/>
	        
        </td>
      </tr>
    </table></form></div>
 <?$db->close();?></div>
<? include "../copyright.php";?>
</body>
</html>
