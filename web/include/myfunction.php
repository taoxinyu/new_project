<?
//网页截取
function cut($string,$start,$end){
$message = explode($start,$string);
$message = explode($end,$message[1]);
return $message[0];
} 
//检查根目录下面是否登陆
function checkadmin(){
if(!isset($_SESSION['islogin']) || $_SESSION['islogin']!='1'){		
		Header ("Location:index.php");
	
		return false;
	}
}
//检查是否登陆
function checklogin(){

    if(!isset($_SESSION['islogin']) || $_SESSION['islogin']!='1'){		
		Header ("Location:../index.php");
		
		return false;
	}
	else {
		$_SESSION['islogin']=$_SESSION['islogin'];
		$_SESSION['loginanme']=$_SESSION['loginname'];
		$_SESSION['loginip']=$_SESSION['loginip'];
		return true;
	}
}
//检查操作权限
function checkaccess($pageaccess,$role)
{
	$acc=5;
	if($role=='超级管理员')
	{
		$acc=1;
	}
	if($role=='域名管理员')
	{
		$acc=2;
	}
	if($role=='日志管理员')
	{
		$acc=3;
	}
	if($role=='监控管理员')
	{
		$acc=4;
	}
	if($acc>$pageaccess)
	{
		Header ("Location:../noaccess.php");
		return false;
	}else 
	{
		return true;
	}
}
//写入操作日志
function writelog($db,$dotype,$param)
{
	$sql="insert into dorecord (username,dotype,param,addtime)values('".$_SESSION['loginname']."','".$dotype."','".$param."',datetime('now','localtime'))";
	$db->query($sql);
	return true;
}
function writercconf($db,$rcfile)
{
	//写入rc.conf文件
	$rc="ipv6_enable=\"YES\"\n";
	$rc=$rc."keymap=\"us.iso\"\n";
	$rc=$rc."sshd_enable=\"YES\"\n";
	$rc=$rc."fsck_y_enable=\"YES\"\n";
	
	$rc=$rc."snmpd_enable=\"YES\"\n";
	$rc=$rc."snmpd_conffile=\"/xmdns/etc/snmpd.conf\"\n";
	$rc=$rc."mrtg_daemon_enable=\"YES\"\n";
	$rc=$rc."cron_enable=\"YES\"\n";
	$rc=$rc."sendmail_enable=\"NO\"\n";
	$rc=$rc."sendmail_submit_enable=\"NO\"\n";
	$rc=$rc."sendmail_outbound_enable=\"NO\"\n";
	$rc=$rc."sendmail_msp_queue_enable=\"NO\"\n";
	$rc=$rc."lighttpd_enable=\"YES\"\n";
	$rc=$rc."lighttpd_conf=\"/xmdns/xmetc/lighttpd.conf\"\n";
	$rc=$rc."bindgraph_enable=\"YES\"\n";
	//是否开启防火墙日志
	$query=$db->query("select * from logset where logid=1");
	$row=$db->fetchAssoc($query);
	if($row['logfirewall']=='1')
	{
		$openfirewall="YES";
	}else 
	{
		$openfirewall="NO";
	}
	$query=$db->query("select * from sethost where hostid=1");
	$row=$db->fetchAssoc($query);
	if($row['firewall']=="1")
	{
		$rc=$rc."firewall_enable=\"YES\"\n";
		$rc=$rc."firewall_logging_enable=\"".$openfirewall."\"\n";
		$rc=$rc."log_in_vain=\"YES\"\n";
		$rc=$rc."firewall_script=\"/xmdns/etc/rc.firewall\"\n";
		$rc=$rc."firewall_quiet=\"NO\"\n";
		$rc=$rc."firewall_logging=\"".$openfirewall."\"\n";
	}
	
	//配置主机与路由
	$rc=$rc."hostname=\"".$row['hostname'].".".$row['hostdomain']."\"\n";
	if($row['gateway']!='')
	{
		$rc=$rc."defaultrouter=\"".$row['gateway']."\"\n";
	}
	if($row['gatewayipv6']!='')
	{
		$rc=$rc."ipv6_defaultrouter=\"".$row['gatewayipv6']."\"\n";
	}
	//配置IP地址
	$query=$db->query("select * from setip where netstate='1'");
	while($row=$db->fetchAssoc($query)){
	if($row['ipv4']!='')
	{
		$rc=$rc."ifconfig_".$row['ipname']."=\"inet ".$row['ipv4']." netmask ".$row['netmask']."\"\n";
		
	}	
	if($row['ipv6']!='')
	{
		$rc=$rc."ipv6_ifconfig_".$row['ipname']."=\"".$row['ipv6']."\"\n";
		
	}	
	}
	
	$query = $db->query("select ipname from setip where netstate =1");
	while ($row = $db->fetchAssoc($query)){
		$n=0;
		$query2 = $db->query("select * from ipalias where ipname='".$row['ipname']."'");
		while($row2=$db->fetchAssoc($query2)){
			if ($row2['ipv4'] != ''){
				$rc=$rc."ifconfig_".$row2['ipname']."_alias$n=\"inet ".$row2['ipv4']." netmask ".$row2['netmask']."\"\n";
				$n++;
			}
			if ($row2['ipv6'] != ''){
				$rc=$rc."ipv6_ifconfig_".$row2['ipname']."=\"".$row2['ipv6']."\"\n";
			}
		}
		
	}
	
	//配置IPV4静态路由
	$query=$db->query("select * from setrouter where rstate='1' and rtype='ipv4'");
	$rou="static_routes=\"";
	$routlist="";
	while($row=$db->fetchAssoc($query)){
	$rou=$rou.$row['ripname']." ";
	$routlist=$routlist."route_".$row['ripname']."=\"-net ".$row['rip']."/".$row['rmask']." ".$row['rgateway']."\"\n";
	
	}
	$rc=$rc.$rou."\"\n";
	$rc=$rc.$routlist;
	//配置IPV6静态路由
	$query=$db->query("select * from setrouter where rstate='1' and rtype='ipv6'");
	$rou="ipv6_static_routes=\"";
	$routlist="";
	while($row=$db->fetchAssoc($query)){
	$rou=$rou.$row['ripname']." ";
	$routlist=$routlist."ipv6_route_".$row['ripname']."=\"-net ".$row['rip']."/".$row['rmask']." ".$row['rgateway']."\"\n";
	
	}
	$rc=$rc.$rou."\"\n";
	$rc=$rc.$routlist;
	writeFile($rcfile,$rc);
	
}
function setport($conf,$newport,$web)
{//设置web
	$a=read_file($conf);
	$a=preg_replace("/server.port=\d{1,4}/","server.port=".$newport,$a);
	if($web==0){
		$a=preg_replace("/ssl.engine=\"enable\"/","#ssl.engine=\"enable\"",$a);
		$a=preg_replace("/ssl.pemfile=\"\/etc\/lighttpd\/xmnac.pem\"/","#ssl.pemfile=\"/etc/lighttpd/xmnac.pem\"",$a);
	}
	if($web==1){
		$a=preg_replace("/#ssl.engine=\"enable\"/","\nssl.engine=\"enable\"\n",$a);
		$a=preg_replace("/#ssl.pemfile=\"\/etc\/lighttpd\/xmnac.pem\"/","ssl.pemfile=\"/etc/lighttpd/xmnac.pem\"",$a);
	}
	if(writeFile($conf,$a)){
		return true;
	}else{
		return false;
	}
}
function writeipfw($firefile,$db)
{
	$rc="#!/bin/sh\n";
	$rc=$rc."add='/sbin/ipfw -q add'\n";
	$rc=$rc."/sbin/ipfw -q -f flush\n";
	$rc=$rc."\${add} 00001 allow all from me 53 to any  out\n";
	$rc=$rc."\${add} 00002 allow all from any to me 53 in\n";
	$rc=$rc."\${add} 00003 allow all from me 22 to any  out\n";
	$rc=$rc."\${add} 00004 allow all from any to me 22 in\n";
	$rc=$rc."\${add} 00005 allow all from me 953 to any  out\n";
	$rc=$rc."\${add} 00006 allow all from any to me 953 in\n";
	$rc=$rc."\${add} 00007 allow all from me 443 to any  out\n";
	$rc=$rc."\${add} 00008 allow all from any to me 443 in\n";
	$rc=$rc."\${add} 00009 allow all from any to me 1024-65535 in\n";
	$rc=$rc."\${add} 00010 allow all from any to me 1024-65535 out\n";
	//选择数据库
	$query=$db->query("select * from setfirewall where fireis='1' order by firenum asc");
	while($row=$db->fetchAssoc($query)){
	$rc=$rc."\${add} ".$row['firenum']." ".$row['fireaction']." ".$row['firepro']." from ";
	if($row['firesource']=='me'||$row['firesource']=='any')
	{
		$rc=$rc.$row['firesource'];
	}else 
	{
		$rc=$rc.$row['firesip']."/".$row['firesbit'];
	}
	if($row['firesport1']=='')
	{
		$rc=$rc." ".$row['firesport'];
	}else 
	{
		$rc=$rc." ".$row['firesport1'];
	}
	$rc=$rc." to ";
	if($row['firedest']=='me'||$row['firedest']=='any')
	{
		$rc=$rc.$row['firedest'];
	}else 
	{
		$rc=$rc.$row['firedip']."/".$row['firedbit'];
	}
	if($row['firedport1']=='')
	{
		$rc=$rc." ".$row['firedport'];
	}else 
	{
		$rc=$rc." ".$row['firedport1'];
	}
	$rc=$rc." ".$row['firedire']."\n";
	}
	writeFile($firefile,$rc);
	
}
function getnet($cardname)
{
	exec("ethtool ".$cardname,$ipconfig,$rc);
	$a="";
	$b="";


	if($rc==0)
        {
                for($i=0,$max=sizeof($ipconfig);$i<$max;$i++)
                {

                        if(preg_match('/Speed:.*.M.*/',$ipconfig[$i]))
                        {
                                $a.=$ipconfig[$i];
                        }


                        if(preg_match('/Link detected: yes/',$ipconfig[$i]))
                        {
                                $b="<img src='../images/up.gif' align='absmiddle'>";
                        }else
                        {
                                $b="<img src='../images/down.gif' align='absmiddle'>";
                        }

                }

        }
        if ($a != ''){
        	$a = str_replace('Speed: ', '速率：', $a);
        }
        return $b.' '.$a;
}

function createdns($db,$binddir)
{
	
	$query=$db->query("select * from logset where logid=1");
	$row=$db->fetchAssoc($query);
	$logquery=$row['logquery'];
	$logsafe=$row['logsafe'];
	//$loglocal=$row['loglocal'];
	$query=$db->query("select * from setdns where dnsid=1");
	$row=$db->fetchAssoc($query);
	//生成rndc.conf
	$rc="key \"rndc-key\" {\n algorithm hmac-md5;\n secret \"".$row['dnskey']."\";\n};\n";
	$rc=$rc."options {\n default-key \"rndc-key\";\n default-server 127.0.0.1;\n default-port 953;\n};\n";
	writeFile($binddir."rndc.conf",$rc);
	//写通用named.conf
	if($row['dnssecip']=='')
	{
		$allowuse="any;";
	}else 
	{
		$allowuse=$row['dnssecip'];
	}
	if($row['dnsthirdip']=='')
	{
		$allowdg="any;";
	}else 
	{
		$allowdg=$row['dnsthirdip'];
	}
	$rc="key \"rndc-key\" {\n algorithm hmac-md5;\n secret \"".$row['dnskey']."\";\n};\n";
	$rc=$rc."controls {\n inet 127.0.0.1 port 953\n allow { 127.0.0.1; } keys { \"rndc-key\";};\n};\n";
	$rc=$rc."options {\n listen-on-v6 { any; };\n directory \"/etc/namedb\";\npid-file \"/var/run/named/pid\";\n";
	$rc=$rc."dump-file \"/var/dump/named_dump.db\";\n statistics-file \"/xmdns/run/named.stats\";\n";
	$rc=$rc."version \"ximo dns 2009\";\n";
	$rc=$rc."auth-nxdomain no;\nzone-statistics yes;\n";
	$rc=$rc."allow-query { ".$allowuse." };\n";
	$rc=$rc."allow-query-cache { ".$allowuse." };\n";
	//转发服务器设置
	if($row['dnstype']=='转发缓存服务器')
	{
		$rc=$rc."datasize ".$row['dnsdatebase']."M;\n";
		$rc=$rc."forwarders { \n".$row['dnsforward']."\n};\nforward first;\n";
		$rc=$rc."allow-recursion { ".$allowdg." };\nrecursion yes;\n";
	}else 
	{
		$rc=$rc."datasize ".$row['dnsdatebase']."M;\n";		
		$rc=$rc."allow-recursion { ".$allowdg." };\nrecursion yes;\n";
	}
	$rc=$rc."};\n";
	//日志引入
	$rc=$rc."logging {\n channel dns_state {\n";
	$rc=$rc."file \"/xmdns/var/log/logquery/dns_state.log\";\n";
	/*
	if($loglocal=="1")
	{
		$rc=$rc."file \"/xmdns/var/log/logquery/dns_state.log\";\n";
	}else 
	{
		$rc=$rc." syslog (syslog);\n";
	}*/
	$rc=$rc."severity info;\nprint-category yes;\nprint-severity yes;\nprint-time yes;\n};\n";
	$rc=$rc."channel dns_log {\n";
	
	$rc=$rc."file \"/xmdns/var/log/logquery/dns_query_ten.log\";\n";
	/*
	if($loglocal=="1")
	{
		$rc=$rc."file \"/xmdns/var/log/logquery/dns_query_ten.log\";\n";
	}else 
	{
		$rc=$rc." syslog (syslog);\n";
	}*/
	$rc=$rc."severity info;\nprint-category yes;\nprint-severity yes;\nprint-time yes;\n};\n";
	if($logsafe=='1')
	{
		$rc=$rc."category general { dns_state; };\n";
	}
	if($logquery=='1')
	{
		$rc=$rc."category queries { dns_log; };\n";
	}
	$rc=$rc."};\n";
	//引入区域文件
	$rc=$rc."include \"ximoacl.conf\";\n";
	$rc=$rc."include \"ximozone.conf\";\n";
	$rc=$rc."include \"ximokey.conf\";\n"; //主辅同步的key配置文件
	
	
	/*
	$rc=$rc."};\n";
	if($row['dnstype']=='转发缓存服务器')
	{
		$rc=$rc."zone \".\" {\ntype hint;\nfile \"named.root\";\n};\n";
		$rc=$rc."zone \"0.0.127.IN-ADDR.ARPA\" {\ntype master;\nfile \"master/localhost-reverse.db\";\n};\n";
		$rc=$rc."zone \"1.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.IP6.ARPA\"{\n";
        $rc=$rc."type master;\nfile \"master/localhost-localhost-reverse.db\";\n};\n";
        $rc=$rc."zone \"localhost\" {\ntype master;\nfile \"master/localhost-forward.db\";\n};\n";
        $rc=$rc."zone \"ximotech.com\" {\ntype master;\nfile \"master/ximotech.com\";\n};\n";
        $rc=$rc."zone \"0.168.192.in-addr.arpa\" {\ntype master;\nfile \"master/0.168.192.in-addr.arpa\";\n};\n";
	}*/
	writeFile("/etc/named.conf",$rc);
	
	
}

/**
 * 
 * @param $binddir 
 * @param string $aclident 线路标识
 * @param object $db 数据库对象
 * @return string $ac 生成的配置内容
 */

function createaclzone($binddir,$aclident,$db)
{
	$sql="select * from setacl where aclident='".$aclident."'";
	$query=$db->query($sql);
	$row=$db->fetchAssoc($query);
	$acldg=$row['acldg'];
	$aclsafe=$row['aclsafe'];
	$aclcs=$row['aclcs'];
	$aclfor=$row['aclfor'];    //转发状态
	$aclforip=$row['aclforip']; //转发到DNS的IP
	
	/* 主辅同步，主 辅DNS在ximozone.conf文件中的设置
	 * match-clients { EDU; };    修改为：   match-clients { key edu_key ;EDU; };
	 * allow-transfer { any; };              allow-transfer { key edu_key; };
	 * 添加一行：server 192.168.0.167 { keys edu_key;};   注：此IP为要通信DNS的IP. 
	 */
	
	
	//来同步的辅DNS IP 类型为 主DNS
	$s = "select tbzip from tongbu where tbtype=1 and tbstate=1 group by tbzip";
	$res = $db->query($s);
	$rmv = '';
	while ($r2 = $db->fetchAssoc($res)){
		$tbzip = $r2['tbzip'];
		if ($tbzip != '' && strpos($tbzip, ';') ){
			$ips = explode(';', $tbzip);
			foreach ($ips as $ip){
				if ($ip != ''){
					$rmv .= '! '.$ip.';';
				}
			}
		}
		else if ($tbzip != ''){
			$rmv .= '! '.$tbzip.';'; 
		}
	}
	
	$keyfile = strtolower(($row['aclident'])).'_key';
	
	$rc="view \"view_".$row['aclident']."\" {\nmatch-clients { key ".$keyfile.'; '.$rmv.$row['aclident']."; };\n"; //1
	
	$query=$db->query("select * from setdns where dnsid=1");
	$row=$db->fetchAssoc($query);
	if($row['dnssecip']=='')
	{
		$allowuse="any;";
	}else 
	{
		$allowuse=$row['dnssecip'];
	}
	if($row['dnsthirdip']=='')
	{
		$allowdg="any;";
	}else 
	{
		$allowdg=$row['dnsthirdip'];
	}
	$rc=$rc." allow-query { ".$allowuse." };\n";  //2
	$rc=$rc." allow-recursion { ".$allowdg." };\n"; //3
	if($aclcs=='1')
	{
		$rc=$rc."allow-transfer { key ".$keyfile."; };\n"; //4
	}
	if($acldg=='1')
	{
		$rc=$rc."recursion  yes;\n";
	}else 
	{
		$rc=$rc."recursion  no;\n";
	}
	
	//通信主辅DNS的IP
	$s = "select tbzip from tongbu where tbstate=1 group by tbzip";
	$res = $db->query($s);
	while ($r2 = $db->fetchAssoc($res)){
		$tbip = $r2['tbzip'];
		if ($tbip != '' && strpos($tbip, ';')){
			$ips = explode(';', $tbip);
			foreach($ips as $ip){
				if ($ip != '')
				$rc .= "server $ip { keys $keyfile ;};\n";
			}
		}
		else if ($tbip != ''){
			$rc .= "server $tbip { keys $keyfile ;};\n";
		}
	}
	
	
	
	//转发
	if ($aclfor&&$aclforip<>""){
	    $rc=$rc."forwarders{\n".$aclforip.";\n};\n";
	}
	
	if($row['dnstype']=='辅服务器'&&$row['dnsmainip']!='')
	{
		$rc=$rc."allow-update { ".$row['dnsmainip']." };\n";
	}
	//开始默认区域
	$rc=$rc."zone \".\" {\ntype hint;\nfile \"named.root\";\n};\n";
	$rc=$rc."zone \"0.0.127.IN-ADDR.ARPA\" {\ntype master;\nfile \"master/localhost-reverse.db\";\n};\n";
	$rc=$rc."zone \"1.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.IP6.ARPA\"{\n";
    $rc=$rc."type master;\nfile \"master/localhost-v6.rev\";\n};\n";
    $rc=$rc."zone \"localhost\" {\ntype master;\nfile \"master/localhost-forward.db\";\n};\n";
  
	$rc=$rc."include \"zone/".$aclident."_zone.conf\";\n";
	$rc=$rc."};\n";
	return $rc;
}
function createanyzone($binddir,$db)
{
	//建立通用域
	$sql="select * from setacl where aclisdefault='1'";
	$query=$db->query($sql);
	$row=$db->fetchAssoc($query);
	$aclident=$row['aclident'];
	if($aclident=='')
	{
		//如果没有缺省线路
		
		$rc="view \"view_ANY\" {\nmatch-clients { key any_key; ANY; };\n";
		
		$query=$db->query("select * from setdns where dnsid=1");
		$row=$db->fetchAssoc($query);
		if($row['dnssecip']=='')
		{
			$allowuse="any;";
		}else 
		{
			$allowuse=$row['dnssecip'];
		}
		if($row['dnsthirdip']=='')
		{
			$allowdg="any;";
		}else 
		{
			$allowdg=$row['dnsthirdip'];
		}
		$rc=$rc." allow-query { ".$allowuse." };\n";
		$rc=$rc." allow-recursion { ".$allowdg." };\n";
		
		$rc=$rc."allow-transfer { key any_key; };\n";
		
		
			$rc=$rc."recursion  yes;\n";
		
		if($row['dnstype']=='辅服务器'&&$row['dnsmainip']!='')
		{
			$rc=$rc."allow-update { ".$row['dnsmainip']." };\n";
		}
		//通信主辅DNS的IP
		$s = "select tbzip from tongbu where tbstate=1 group by tbzip";
		$res = $db->query($s);
		while ($r2 = $db->fetchAssoc($res)){
			$tbip = $r2['tbzip'];
			if ($tbip != '' && strpos($tbip, ';')){
				$ips = explode(';', $tbip);
				foreach($ips as $ip){
					if ($ip != '')
					$rc .= "server $ip { keys any_key ;};\n";
				}
			}
			else if ($tbip != ''){
				$rc .= "server $tbip { keys any_key ;};\n";
			}
		}
		
		//开始默认区域
		$rc=$rc."zone \".\" {\ntype hint;\nfile \"named.root\";\n};\n";
		$rc=$rc."zone \"0.0.127.IN-ADDR.ARPA\" {\ntype master;\nfile \"master/localhost-reverse.db\";\n};\n";
		$rc=$rc."zone \"1.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.IP6.ARPA\"{\n";
	    $rc=$rc."type master;\nfile \"master/localhost-v6.rev\";\n};\n";
	    $rc=$rc."zone \"localhost\" {\ntype master;\nfile \"master/localhost-forward.db\";\n};\n";
		$rc=$rc."include \"zone/ANY_zone.conf\";\n";
		$rc=$rc."};\n";
		return $rc;
	
	}else 
	{//有缺省线路
	$sql="select * from setacl where aclident='".$aclident."'";
	$query=$db->query($sql);
	$row=$db->fetchAssoc($query);
	$acldg=$row['acldg'];
	$aclsafe=$row['aclsafe'];
	$aclcs=$row['aclcs'];
	$rc="view \"view_ANY\" {\nmatch-clients { any; };\n";
	$query=$db->query("select * from setdns where dnsid=1");
	$row=$db->fetchAssoc($query);
	if($row['dnssecip']=='')
	{
		$allowuse="any;";
	}else 
	{
		$allowuse=$row['dnssecip'];
	}
	if($row['dnsthirdip']=='')
	{
		$allowdg="any;";
	}else 
	{
		$allowdg=$row['dnsthirdip'];
	}
	$rc=$rc." allow-query { ".$allowuse." };\n";
	$rc=$rc." allow-recursion { ".$allowdg." };\n";
	if($aclcs=='1')
	{
		$rc=$rc."allow-transfer { any; };\n";
	}
	if($acldg=='1')
	{
		$rc=$rc."recursion  yes;\n";
	}else 
	{
		$rc=$rc."recursion  no;\n";
	}
	if($row['dnstype']=='辅服务器'&&$row['dnsmainip']!='')
	{
		$rc=$rc."allow-update { ".$row['dnsmainip']." };\n";
	}
	//开始默认区域
	$rc=$rc."zone \".\" {\ntype hint;\nfile \"named.root\";\n};\n";
	$rc=$rc."zone \"0.0.127.in-addr.arpa\" {\ntype master;\nfile \"master/localhost-reverse.db\";\n};\n";
	$rc=$rc."zone \"1.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.IP6.arpa\"{\n";
    $rc=$rc."type master;\nfile \"master/localhost-reverse.db\";\n};\n";
    $rc=$rc."zone \"localhost\" {\ntype master;\nfile \"master/localhost-forward.db\";\n};\n";
    //$rc=$rc."zone \"ximotech.com\" {\ntype master;\nfile \"master/ximotech.com\";\n};\n";
    //$rc=$rc."zone \"0.168.192.in-addr.arpa\" {\ntype master;\nfile \"master/0.168.192.in-addr.arpa\";\n};\n";
	$rc=$rc."include \"zone/".$aclident."_zone.conf\";\n";
	$rc=$rc."};\n";
	return $rc;
	}
}

function createdomain($db,$binddir)
{
	//线路
	//$acl[0]='';
	
	$acl = array();
	$sql="select * from setacl where aclis='1'";
	$query=$db->query($sql);
	$i=0;
	while($row=$db->fetchAssoc($query))
	{
		$acl[$i]=$row['aclident'];
		$i++;
	}
	//转发线路
	$sql = "select * from forwarder where state = 1";
	$query = $db->query($sql);
	while ($row = $db->fetchAssoc($query)){
		$acl[$i]=$row['ident'];
		$i++;
	}
	
	$acl[$i]='ANY';
	//DNS设置
	$sql="select * from setdns where dnsid=1";
	$query=$db->query($sql);
	$row=$db->fetchAssoc($query);
	$mainip="";
	if($row['dnstype']!='辅服务器')
	{
		$dnstype=1;
	}else 
	{
		$dnstype=0;
		$mainip=$row['dnsmainip'];
	}
	
	//选择域名
	$sql="select * from domain where domainis='1'";
	$query=$db->query($sql);
	$file[0]='';
	
	/*
	 * 域名类型有三类：主，辅，转发
	 * 字段domaintype 0：默认	1：主	2：辅	3：转发
	 * 默认：	 不处理
	 * 主：		 在myfunciton.php createaclzone()函数中处理;
	 * 辅：		 在下面处理。myfunction.php createdomain()函数中处理
	 * 转发：	 在下面处理。myfunction.php createdomain()函数中处理
	 */
	while($row=$db->fetchAssoc($query))
	{
	    if ($row['domaintype'] == 2){ //辅域
	    
    	    $s = "select * from tongbu where domainid=".$row['domainid'];
    	    $res = $db->query($s);
    	    $r = $db->fetchAssoc($res);
    	    $rst = array(); //存放同步时线路IP
            $ac = explode('|', $r['tbips']);
            foreach($ac as $a){
                $cl = explode('_', $a);
                $rst[$cl[0]] = $cl[1];
            }
            
    	    for($i=0;$i<sizeof($acl);$i++){
    			//写入每个区域每个域名
    			createrecord($dnstype,$binddir,$db,$row['domainid'],$acl[$i],$row['domainsoa'],$row['domainadmin'],$row['domainname'],createserial($row['domainserial']),$row['domainrefresh'],$row['domainretry'],$row['domainttl'],$row['domainexpire']);
    			$file[$i]=$file[$i]."zone \"".$row['domainname']."\" {\ntype slave;\nmasters{".$r['tbzip'].";};\nfile \"slave/".$row['domainname']."_".$acl[$i]."\";\ncheck-names ignore;\nallow-transfer{ none; };\nnotify yes;\n};\n";
    		}
    		
	    } else if ($row['domaintype'] == 3){//转发域
	         $s = "select * from yzf where domainid=".$row['domainid'];
	         $res = $db->query($s);
	         $r = $db->fetchAssoc($res);
	         $ip = $r['ip'];
	         for($i=0;$i<sizeof($acl);$i++){
    			//写入每个区域每个域名
    			createrecord($dnstype,$binddir,$db,$row['domainid'],$acl[$i],$row['domainsoa'],$row['domainadmin'],$row['domainname'],createserial($row['domainserial']),$row['domainrefresh'],$row['domainretry'],$row['domainttl'],$row['domainexpire']);
    			$file[$i]=$file[$i]."zone \"".$row['domainname']."\" {\ntype forward;\nforward only;\nforwarders{".$ip.";};\n};\n";
    		}
	    } else { //默认 ，主域
	        
    		for($i=0;$i<sizeof($acl);$i++)
    		{
    			//写入每个区域每个域名
    			createrecord($dnstype,$binddir,$db,$row['domainid'],$acl[$i],$row['domainsoa'],$row['domainadmin'],$row['domainname'],createserial($row['domainserial']),$row['domainrefresh'],$row['domainretry'],$row['domainttl'],$row['domainexpire']);
    			if($dnstype==1)
    			{//主
    				$file[$i]=$file[$i]."zone \"".$row['domainname']."\" {\ntype master;\nfile \"master/".$row['domainname']."_".$acl[$i]."\";\ncheck-names ignore;\nallow-transfer{ any; };\nnotify yes;\n};\n";
    			}else 
    			{//辅
    				$file[$i]=$file[$i]."zone \"".$row['domainname']."\" {\ntype slave;\nfile \"slave/".$row['domainname']."_".$acl[$i]."\";\nmasters {\n".$mainip."};\ncheck-names ignore;\n};\n";
    			}
    		}
	    }
	}
	//定入区域文件
	//批量转发
	$domaingroup_conf="/xmdns/var/domain_group";
	$domaingroup_sh="#domain_group_forward start\n";
    $group_domain_rows =unserialize(file_get_contents($domaingroup_conf)); 
	foreach($group_domain_rows as $row){
		if(!$row[2])continue;
	    $row_domains=explode(";",$row[0]);
		foreach($row_domains as $domain){
            $domaingroup_sh.="zone \"".$domain."\" {\ntype forward;\nforward only;\nforwarders{".$row[1].";};\n};\n";
		}
	}
	$domaingroup_sh.="#domain_group_forward end\n";
	//批量转发end
	for($i=0;$i<sizeof($acl);$i++)
	{
//实现网站黑名单时用到的
//顶级域
$djy = <<< EOF
zone "aaaaaa" {
type master;
file "master/www.aaa_ANY";
check-names ignore;
allow-transfer{ any; };
notify yes;
};
zone "aaaa" {   
type master;
file "master/www.aaa_ANY";
check-names ignore;
allow-transfer{ any; };
notify yes;
};
zone "aaa" {   
type master;
file "master/www.aaa_ANY";
check-names ignore;
allow-transfer{ any; };
notify yes;
};
zone "aa" {   
type master;
file "master/www.aaa_ANY";
check-names ignore;
allow-transfer{ any; };
notify yes;
};
EOF;
            //删除$djy中的^M
            $djy = str_replace("\r\n", "\n", $djy);
			writeFile($binddir."zone/".$acl[$i]."_zone.conf",$domaingroup_sh.$file[$i].$djy);
		}
}
function createrecord($dnstype,$binddir,$db,$domainid,$aclident,$domainsoa,$domainadmin,$domainname,$serial,$refresh,$retry,$ttl,$expire)
{
	$rc="\$TTL ".$ttl."\n";
	$rc=$rc."@	IN	SOA	".$domainsoa.".	".$domainadmin.". (\n".createserial($serial).";Serial\n".$refresh.";Refresh\n".$retry.";Retry\n".$expire.";Expire\n".$ttl.");ttl\n";
	$sql="select * from drecord where dacl='".$aclident."' and ddomain=".$domainid." and dis='1'";
	$query=$db->query($sql);
	while($row=$db->fetchAssoc($query))
	{
		if($row['dtype']=="MX")
		{
			$rc=$rc.$row['dname']."   IN	".$row['dtype']."	".$row['dys']."		".$row['dvalue']."\n";
		}else if($row['dtype']=="A6")
    	{
    			$rc=$rc.$row['dname']."   IN	".$row['dtype']."	0	".$row['dvalue']."\n";
    	}else if($row['dtype']=="TXT"){
		        
		    $rc=$rc.$row['dname']."   IN	".$row['dtype']."	\"".$row['dvalue']."\"\n";
		
		}else
		{
    		
			$rc=$rc.$row['dname']."   IN	".$row['dtype']."	".$row['dvalue']."\n";
		}
		
	}
	if($dnstype==1){
		writeFile($binddir."/master/".$domainname."_".$aclident,$rc);
	}else 
	{
		writeFile($binddir."/slave/".$domainname."_".$aclident,$rc);
	}
	$db->query("update domain set domainserial=".createserial($serial)." where domainid=".$domainid);
}
function str2hex($s)    
{        
    $r = "";    
    $hexes = array ("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");    
    for ($i=0; $i<strlen($s); $i++)    
        $r .= ($hexes [(ord($s{$i}) >> 4)] . $hexes [(ord($s{$i}) & 0xf)]);    
    return $r;    
}    
   
//解密    
function hex2str($s)    
{    
    $r = "";    
    for ( $i = 0; $i<strlen($s); $i += 2)    
    {    
        $x1 = ord($s{$i});    
        $x1 = ($x1>=48 && $x1<58) ? $x1-48 : $x1-97+10;    
        $x2 = ord($s{$i+1});    
        $x2 = ($x2>=48 && $x2<58) ? $x2-48 : $x2-97+10;    
        $r .= chr((($x1 << 4) & 0xf0) | ($x2 & 0x0f));    
    }    
    return $r;    
}   
function getmac(){
exec("ifconfig ",$ipconfig,$rc);
$a="";
if($rc==0)
	{//先获取网卡			
		for($i=0,$max=sizeof($ipconfig);$i<$max;$i++)
		{		
			
			if(preg_match('/ether.*/',$ipconfig[$i]))
			{//如果活动
				preg_match_all('/\d{2}.*/',$ipconfig[$i],$a1);
				$a= $a1[0][0];
				return $a;
				exit;
			}

		}
}
return 0;
}  

function convertip($ip) {
    //IP数据文件路径
    $dat_path = '/ximorun/ximodb/CoralWry.dat'; 

    //检查IP地址
    /*if(!preg_match("/d{1,3}.d{1,3}.d{1,3}.d{1,3}$/", $ip)) {
        return 'IP Address Error';
    }*/
    //打开IP数据文件
    if(!$fd = @fopen($dat_path, 'rb')){
        return 'IP date file not exists or access denied';
    }

    //分解IP进行运算，得出整形数
    $ip = explode('.', $ip);
    $ipNum = $ip[0] * 16777216 + $ip[1] * 65536 + $ip[2] * 256 + $ip[3];

    //获取IP数据索引开始和结束位置
    $DataBegin = fread($fd, 4); //第一条索引的绝对偏移
    $DataEnd = fread($fd, 4);	//最后一条索引的绝对偏移
    $ipbegin = implode('', unpack('L', $DataBegin));
    if($ipbegin < 0) $ipbegin += pow(2, 32);
    $ipend = implode('', unpack('L', $DataEnd));
    if($ipend < 0) $ipend += pow(2, 32);
    $ipAllNum = ($ipend - $ipbegin) / 7 + 1;
    
    $BeginNum = 0;
    $EndNum = $ipAllNum;

    //使用二分查找法从索引记录中搜索匹配的IP记录
    while($ip1num>$ipNum || $ip2num<$ipNum) {
        $Middle= intval(($EndNum + $BeginNum) / 2);

        //偏移指针到索引位置读取4个字节
        fseek($fd, $ipbegin + 7 * $Middle);
        $ipData1 = fread($fd, 4);
        if(strlen($ipData1) < 4) {
            fclose($fd);
            return 'System Error';
        }
        //提取出来的数据转换成长整形，如果数据是负数则加上2的32次幂
        $ip1num = implode('', unpack('L', $ipData1));
        if($ip1num < 0) $ip1num += pow(2, 32);
        
        //提取的长整型数大于我们IP地址则修改结束位置进行下一次循环
        if($ip1num > $ipNum) {
            $EndNum = $Middle;
            continue;
        }
        
        //取完上一个索引后取下一个索引
        $DataSeek = fread($fd, 3);
        if(strlen($DataSeek) < 3) {
            fclose($fd);
            return 'System Error';
        }
        $DataSeek = implode('', unpack('L', $DataSeek.chr(0)));
        fseek($fd, $DataSeek);
        $ipData2 = fread($fd, 4);
        if(strlen($ipData2) < 4) {
            fclose($fd);
            return 'System Error';
        }
        $ip2num = implode('', unpack('L', $ipData2));
        if($ip2num < 0) $ip2num += pow(2, 32);

        //没找到提示未知
        if($ip2num < $ipNum) {
            if($Middle == $BeginNum) {
                fclose($fd);
                return 'Unknown';
            }
            $BeginNum = $Middle;
        }
    }

    //下面的代码读晕了，没读明白，有兴趣的慢慢读
    $ipFlag = fread($fd, 1);
    if($ipFlag == chr(1)) {
        $ipSeek = fread($fd, 3);
        if(strlen($ipSeek) < 3) {
            fclose($fd);
            return 'System Error';
        }
        $ipSeek = implode('', unpack('L', $ipSeek.chr(0)));
        fseek($fd, $ipSeek);
        $ipFlag = fread($fd, 1);
    }

    if($ipFlag == chr(2)) {
        $AddrSeek = fread($fd, 3);
        if(strlen($AddrSeek) < 3) {
            fclose($fd);
            return 'System Error';
        }
        $ipFlag = fread($fd, 1);
        if($ipFlag == chr(2)) {
            $AddrSeek2 = fread($fd, 3);
            if(strlen($AddrSeek2) < 3) {
                fclose($fd);
                return 'System Error';
            }
            $AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
            fseek($fd, $AddrSeek2);
        } else {
            fseek($fd, -1, SEEK_CUR);
        }

        while(($char = fread($fd, 1)) != chr(0))
            $ipAddr2 .= $char;

        $AddrSeek = implode('', unpack('L', $AddrSeek.chr(0)));
        fseek($fd, $AddrSeek);

        while(($char = fread($fd, 1)) != chr(0))
            $ipAddr1 .= $char;
    } else {
        fseek($fd, -1, SEEK_CUR);
        while(($char = fread($fd, 1)) != chr(0))
            $ipAddr1 .= $char;

        $ipFlag = fread($fd, 1);
        if($ipFlag == chr(2)) {
            $AddrSeek2 = fread($fd, 3);
            if(strlen($AddrSeek2) < 3) {
                fclose($fd);
                return 'System Error';
            }
            $AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
            fseek($fd, $AddrSeek2);
        } else {
            fseek($fd, -1, SEEK_CUR);
        }
        while(($char = fread($fd, 1)) != chr(0)){
            $ipAddr2 .= $char;
        }
    }
    fclose($fd);

    //最后做相应的替换操作后返回结果
    if(preg_match('/http/i', $ipAddr2)) {
        $ipAddr2 = '';
    }
    //$ipaddr = "$ipAddr1 $ipAddr2";
    $ipaddr = "$ipAddr1";
    $ipaddr = preg_replace('/CZ88.Net/is', '', $ipaddr);
    $ipaddr = preg_replace('/^s*/is', '', $ipaddr);
    $ipaddr = preg_replace('/s*$/is', '', $ipaddr);
    if(preg_match('/http/i', $ipaddr) || $ipaddr == '') {
        $ipaddr = 'Unknown';
    }

    return $ipaddr;
}

/**
 * 获得同步key
 * 
 * @return string $key
 */
function getkey(){
	$keydir = '/etc/namedb/key/';
	$key = '';
	chdir($keydir);
	$a = 'temp';
	$cmd = "/usr/sbin/dnssec-keygen -a hmac-md5 -b 128 -n HOST ".$a."_key";
	exec($cmd);
	$files = scandir($keydir);
	foreach($files as $file){//文件名循环
		if ( strpos($file, 'private') ){ //文件名中有private的
			$acllower = $a;  //线路名小写
			if ( strpos( $file, $acllower) ){
				$con = file($keydir.$file); //文件内容
				$kcon = explode(' ',$con[2]); 
				$size = sizeof($kcon);  
				$key = str_replace("\n","", $kcon[$size-1]); //key内容
				//unlink($keydir.$file);
			}
		}
	}
	chdir('/xmdns/web/dns/');
	return $key;
}

/**
 * 生成ximokey.conf配置文件
 * 
 * @param mixed $db 数据库对象 
 * @param string $keydir Key文件目录
 * @return string ximokey.conf文件内容
 */
function createkeyconf($db, $keydir=''){
	$keyconf = '';
	$sql = 'select * from setacl';
	$res = $db->query($sql);
	while ($row = $db->fetchAssoc($res)){
		$acllower = strtolower($row['aclident']);
		$key = $row['aclkey'];
		
		$keyconf .= "key \"".$acllower."_key\" {\n";
		$keyconf .= "algorithm hmac-md5;\n";
		$keyconf .= "secret \"".$key."\";\n";
		$keyconf .= "};\n";
	}
	
	$anykey = 'etB3FPMf5rAtXXWG4jXbjw==';
	$keyconf .= "key \"any_key\" {\n";
	$keyconf .= "algorithm hmac-md5;\n";
	$keyconf .= "secret \"".$anykey."\";\n";
	$keyconf .= "};\n";
	
	return $keyconf;
}
?>
