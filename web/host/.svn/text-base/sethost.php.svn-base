<?
include ('../include/comm.php');
checklogin();
checkac();
function get_net(){
	exec("netstat -ln",$rs);
	foreach($rs as $str){
		if(preg_match("/:/",$str)){
			$arr = explode(':',$str);
			$newarray=array();
			foreach ($arr as $value){
				if($value=="")continue;
				$newarray[]=trim($value);
			}
			$arr=$newarray;
			array_pop($arr);
			$port = explode(' ',array_pop($arr));
			$netstat[] = $port[0];
		}
	}
	$netstat=array_unique($netstat);
	return $netstat;
}
function edit_hosts($name,$domain){
	$c = file_get_contents("/etc/hosts");
	$a = explode("\n",$c);
	$b = explode("\t",$a[3]);
	$b[0] = "127.0.0.1";
	$b[1]=$name;
	$b[2]=$name.".".$domain;
	$a[3] = implode("\t",$b);
	$a[4]=isset($a[4])?$a[4]:"";
	$c = implode("\n",$a);
	file_put_contents("/etc/hosts",$c);
}
if(isset($_POST['Submit'])){
    checkac('应用');
	/************数据安全验证************/
	//验证端口
	if($_POST['webport']!=$_POST['webport1']){
		$port_comm=get_net();
		if(array_search($_POST['webport'],$port_comm)!=NULL)
		{
			showmessage("端口".$_POST['webport']."不能被占用，为".$port_comm[$_POST['webport']]."默认端口",2);
		}
	}
	$sql="update sethost set hostname='".$_POST['hostname']."',hostdomain='".$_POST['hostdomain']."',dns1='".$_POST['dns1']."',dns2='".$_POST['dns2']."',dns3='".$_POST['dns3'];
	$sql=$sql."',gateway='".$_POST['gateway']."',gatewayipv6='".$_POST['gatewayipv6']."',https='".$_POST['https']."',webport='".$_POST['webport']."',firewall='".$_POST['firewall']."',updatetime=datetime('now','localtime') where hostid=1";
	$db->query($sql);
	//写入rc.conf文件
	writercconf($db,$rcfile);
	
	//其实修改主机名应该改/etc/sysconfig/network这个文件！(fedora,redhat系统)
	
	//设置主机名
	$c = "NETWORKING=yes\nNETWORKING_IPV6=yes\nHOSTNAME=";
	$c.=$_POST['hostname'].".".$_POST['hostdomain']."\n";
	writeFile($sethostname,$c);
	exec("hostname ".$_POST['hostname']);
	//设置主机域
	$cmd = "domainname ".$_POST['hostdomain']."\n";
	writeShell($sethosts,$cmd);
	exec($cmd);
	edit_hosts($_POST['hostname'],$_POST['hostdomain']);
	//设置缺省网关
	$d="";
	$c="";
	$route = "ip route";
	if($_POST['gateway']!=''){
		$c.="$route append default via ".$_POST['gateway']." table default\n";
		$d.="$route del default via ".$_POST['gateway']." table default\n";
	}
	if ($_POST['gatewayipv6'] != ''){
		$d .= "ip -6 route del default via ".$_POST['gatewayipv6']." table default\n";
		$c .= "ip -6 route append default via ".$_POST['gatewayipv6']." table default\n";
	}
	exec($delgateway);
	writeShell($setgateway,$c);
	exec($setgateway);
	writeShell($delgateway,$d);
	//写入resolv.conf文件
	$reso="";
	if($_POST['dns1']!='')
	{
		$reso=$reso."nameserver ".$_POST['dns1']."\n";
	}
	if($_POST['dns2']!='')
	{
		$reso=$reso."nameserver ".$_POST['dns2']."\n";
	}
	if($_POST['dns3']!='')
	{
		$reso=$reso."nameserver ".$_POST['dns3']."\n";
	}
	writeFile($resolvfile,$reso);
	//写入lighttpd.conf文件
    //判断端口,如果端口被修改,就打开防火墙
	if($_POST["webport"]!=$_POST['webport1'])
	{
		exec("$iptables -F");
		$db->query("update isapp set firewall=1");
	}
	if($_POST['https']=="http")
	{
		setport($lighttpd,$_POST['webport'],0);
	}
	if($_POST['https']=="https")
	{
		setport($lighttpd,$_POST['webport'],1);
	}
	writelog($db,'设置主机信息',"设置主机信息内容");
	$db->close();
	exec("chmod +x *");
	exec("at now -f $setport>/dev/null");
	showmessage('主机信息设置成功','sethost.php');
	
}else
{//读取信息
	$query=$db->query("select * from sethost where hostid=1");
	$row=$db->fetchAssoc($query);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>日志设置</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<link href="host.js" rel="stylesheet" type="text/javascript" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<script language="javascript">
function checklogin(){
	var form=document.sethost;
	var webport=_g('webport');
	if(!regExp.hostname.test($("#hostname").val())){
		alert("请输入正确的主机名");
		document.sethost.hostname.select();
		return false;
	}
	
	if(form.hostdomain.value == ''||!checkzheng(form.hostdomain.value)){
		alert("请输入正确的主机域");
		document.sethost.hostdomain.select();
		return false;
	}
	
	if(document.sethost.dns1.value == ''){
		alert("请输入dns1的IP");
		document.sethost.dns1.select();
		return false;
	}
	else
	{
		if(!checkip(document.sethost.dns1.value) && !checkipv6(document.sethost.dns1.value))
		{
			alert("IP格式有误");
			document.sethost.dns1.select();
			return false;
		}
	}
	
	if(!document.sethost.dns2.value == ''){
	
		if(!checkip(document.sethost.dns2.value) && !checkipv6(document.sethost.dns2.value))
		{
			alert("IP格式有误");
			document.sethost.dns2.select();
			return false;
		}
	}
	
	if(!document.sethost.dns3.value == ''){
	
		if(!checkip(document.sethost.dns3.value)  && !checkipv6(document.sethost.dns3.value))
		{
			alert("IP格式有误");
			document.sethost.dns3.select();
			return false;
		}
	}
	if(document.sethost.gatewayipv6.value!= ''){
		if(!checkipv6(document.sethost.gatewayipv6.value))
		{
			alert("IPV6格式有误");
			document.sethost.gatewayipv6.select();
			return false;
		}
	}
	if(document.sethost.gateway.value != ''){
		if(!checkip(document.sethost.gateway.value))
		{
			alert("IP格式有误");
			document.sethost.gateway.select();
			return false;
		}
	}	
	if(!isPort(webport.value)){
		alert("请输入正确的web访问端口");
		webport.select();
		return false;
	}
	return true;
}
</script>
</head>

<body><div class="wrap">
  <div class="nav">&nbsp;当前位置:&gt;&gt; 主机设置 </div>
    
      <div class="content">
	  <form id="sethost" name="sethost" method="post" action="sethost.php" onsubmit="return checklogin();">
	  <table width="768" class="s s_form">
        <tr>
          <td colspan="2" class="caption">主机设置</td>
        </tr>
         <tr>
           <td    class="title">设置主机名：</td>
           <td   ><label>
           <input name="hostname" type="text" id="hostname" value="<? echo $row['hostname']?>" size="15" />
服务器的名称，如dns</label>
			</td>
         </tr>
         <tr>
           <td    class="title">设置主机域：</td>
           <td   ><input name="hostdomain" type="text" id="hostdomain" value="<? echo $row['hostdomain']?>" />
指定域名，如ximo.com.cn
			</td>
         </tr>
         <tr>
          <td width="200"    class="title">设置主机的DNS用于保证<br>本机的正常互联网连接：</td>
          <td width="557"   >
          <input name="dns1" type="text" id="dns1" value="<? echo $row['dns1']?>" />
          <input name="dns2" type="text" id="dns2" value="<? echo $row['dns2']?>" />
          <input name="dns3" type="text" id="dns3" value="<? echo $row['dns3']?>" /> 保存即生效
</td>
        </tr>
        <tr>
          <td    class="title">设置默认网关：</td>
          <td   ><input name="gateway" type="text" id="gateway" value="<? echo $row['gateway']?>" />
指定网关，如192.168.2.1</td>
        </tr>
        <tr>
          <td    class="title">IPV6网关：</td>
          <td   ><label>
          <input name="gatewayipv6" type="text" id="gatewayipv6" value="<? echo $row['gatewayipv6']?>" size="40" />
指定IPV6的默认网关，没有为空</label></td>
        </tr>
        <tr>
          <td    class="title">WEB协议：</td>
          <td   ><input name="https" type="radio" value="http" <? if($row['https']=='http'){?>checked="checked"<?}?> />
HTTP
  <input name="https" type="radio" value="https" <? if($row['https']=='https'){?>checked="checked"<?}?> />
HTTPS </td>
        </tr>
        <tr>
          <td    class="title">WEB端口：</td>
          <td   ><label>
          <input name="webport" type="text" id="webport" size="10" value="<? echo $row['webport']?>" />
WEB的访问端口</label><span class="error"> 不能将端口设置为８０，修改端口前系统会自动修改防火墙端口状态<span>
			<input name="webport1" type="hidden" id="webport1" size="10" value="<? echo $row['webport']?>" />
		  </td>
        </tr>
        <!--<tr>
          <td    class="title">是否开启防火墙：</td>
          <td   ><label>
            <input name="firewall" type="radio" value="1" <?if($row['firewall']=="1"){echo "checked";}?>/>
开启
<input type="radio" name="firewall" value="0" <?if($row['firewall']=="0"){echo "checked";}?> />
关闭 </label></td>
        </tr>-->
         <tr>
           <td    class="title">最后修改时间：</td>
           <td   ><?echo $row['updatetime']?></td>
         </tr>
         <tr>
          <td    class="title">当前系统时间：</td>
          <td   ><label class="greentext">
          <?=date("Y年n月j日 H:i:s")?>	&nbsp;&nbsp;&nbsp;<a href="setdate.php">点击这里设置系统时间</a></label></td>
        </tr>
        
        
        <tr>
          <td  colspan="2" class="footer">
            <input type="submit" name="Submit" value="保存设置" onclick="return checklogin()" />&nbsp;立即生效
          </td>
        </tr>
      </table></form></div>
        
<? $db->close();?>
<div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
