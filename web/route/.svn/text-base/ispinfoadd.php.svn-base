<?php
require_once '../include/comm.php';
checklogin();
checkac();
$action='newispinfo';
if(isset($_REQUEST['action']))
	$action=$_REQUEST['action'];
if($action=='modispinfo')
{
	$rs=$db->query("select * from ispinfo where ispinfoid=$_REQUEST[ispinfoid];");
	$row=$db->fetch_array($rs);
	$name=$row['name'];
	$desc=$row['desc'];
	$ipaddr=$row['ipaddr'];
	$state[$row['state']]='selected';
	$caption='编辑';
	$nav='编辑ISP信息';
}
else
{
	$nav='添加ISP信息';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js" charset="utf-8"></script>
<script src="../js/jquery.validate.js" charset="utf-8" ></script>
<script src="../js/jquery.validate.ext.js"  charset="utf-8"></script>
<script type="text/javascript" src="../js/messages_cn.js"  charset="utf-8"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<script language="javascript">
function checklogin(){
	
	if(document.ispadd.name.value == ''){
		alert("请输入标识");
		document.ispadd.name.select();
		return false;
	}
	
	if(document.ispadd.desc.value == ''){
		alert("请输入描述");
		document.ispadd.desc.select();
		return false;
	}
	
	if(document.ispadd.ipaddr.value == ''){
		alert("请输入地址段");
		document.ispadd.ipaddr.select();
		return false;
	}
	else
	{
		var inputs=document.getElementById('ipaddr').value;		
		var tel_ip =/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/; 
		var tel_ipd =/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\/(\d|1\d|2\d|3[0-2])$/; 
		if(inputs.indexOf("\r")=="-1"){
			var ips = inputs.split("\n");
		}else{			
			var ips = inputs.split("\r\n");
		}
		
		for(var i = 0; i < ips.length; i++) {		
			if(!tel_ip.test(ips[i]) && !tel_ipd.test(ips[i])){
				
				alert("IP段格式有误");
				document.ispadd.ipaddr.select();
				return false;
			}
		}
		
	}
	return true;
}
function checkips(ip)
{
	var tel_ip = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
	var tel_ipd = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\/(\d|1\d|2\d|3[0-2])$/;
	var ips = ip.split("\n");
	
	for(var i = 0; i < ips.length; i++) {		
		if(!tel_ip.test(ips[i]) && !tel_ipd.test(ips[i])){
			return false;
			alert(ips[i]);
		}
	}
	return true;
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=GB18030">
<title>Insert title here</title>
</head>
<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; ISP信息&gt;&gt; <?=isset($caption)?$caption:'添加'?>ISP信息</div>
 <ul class="tab-menu">
    <li><a href="ispinfo.php">ISP信息 </a> </li>
    <li  class="on"><span><?=isset($caption)?$caption:'添加'?>ISP信息</span></li>
</ul>
<div class="content">
<form action="ispaction.php" method="post" name="ispadd" id="ispadd" onsubmit="return checklogin();">
<input type="hidden" name="action" value="<?=@$action?>" ></input>
<input type="hidden" name="ispinfoid" value="<?=@$_REQUEST[ispinfoid]?>" ></input>
  
    <table class="s s_form" width="60%">
	 <tr>
    <td class="caption" colspan="2">
   	<?=isset($caption)?$caption:'添加'?>ISP信息
   	</td> 
   
    </tr>
    <tr>
    <td  >
   	标识(名字)：
   	</td> 
   	<td  >
   	<input class="required mark" name="name" id="name" value="<?=@$name?>"></input>
   	</td>
    </tr>
	<tr>
    <td  >
   描述：
   	</td> 
   	<td >
   	<input name="desc" id="desc" value="<?=@$desc?>" ></input>
   	</td>
    </tr>    
    <tr>
    <td  >
   	地址段：
   	</td> 
   	<td  >
   	<textarea name="ipaddr" id="ipaddr" rows="20" cols="20"><?=@$ipaddr?></textarea>
   	</td>
    </tr>
    
    <tr>
    <td >
   	启用状态：
   	</td>
   	<td >
   	<select name="state" id="state" >
   	<option value="1" <?=$state[1]?> >启用</option>
   	<option value="0" <?=$state[0]?> >禁用</option>
   	
   	</select>
   	</td>
    </tr>
    <tr >
    <td colspan="2"  class="footer"><input type="submit" name="Submit" value="保存设置" /></td>
    </tr>
 
    </table> 
</form>     
</div>
<div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>