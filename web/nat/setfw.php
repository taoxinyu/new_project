<?
include ('../include/comm.php');
$pageaccess=0;
checklogin();
//checkaccess($pageaccess,$_SESSION['role']);
checkac();
//更新代理上网设置

if ($_POST['theseport']) {
	$osports=$_POST['osport'];
	//echo $osports;
	$sqlport="update firewall set osport='".$osports."'";
	$db->query($sqlport);
	//echo $db->error();
}

$sql="select * from firewall,timeset,portlist where firewall.fwtime=timeset.tid and firewall.fwprotol=portlist.plid and firewall.fwstate=1 order by fwnumber desc";
$query=$db->query($sql);
//$a="#!/bin/sh\n";
$a.="iptables=\"".$iptables."\"\n";
$a.="\$iptables -F\n";
$a.="\$iptables -A INPUT -p TCP -m state --state ESTABLISHED,RELATED -j ACCEPT\n";
$a.="\$iptables -A INPUT -p UDP -m state --state ESTABLISHED,RELATED -j ACCEPT\n";

while($row=$db->fetch_array($query))
{
	if ($row['plname']=='ICMP') {
		$ass=($row['fwaction']=='1')?'ACCEPT':'DROP';
		
	if($row['fwwk']=="所有"){
		$wk="";
	}else{
		$wk="-i ".$row['fwwk'];
	}



		$a.="\$iptables -A INPUT ".$wk." -p icmp -s ".$row['fwsip']." -d ".$row['fwdip']." -j ".$ass."\n";
	}
	else {
if ($row['checkall'] == 1){ //端口
	if($row['fwdirect']==0)
	{
		$d="PREROUTING";
		if($row['fwprotol']==0 || $row['fwprotol']==-1){
			$c=" -m multiport --dport ".$row['fwport'];
		}else{
			$c=" -m multiport --dport ".$row['plport'];
		}
	}else 
	{
		$d="POSTROUTING";
		if($row['fwprotol']==0 || $row['fwprotol']==-1){
			$c=" -m multiport --sport ".$row['fwport']; 
		}else{
			$c=" -m multiport --sport ".$row['plport']; 
		}
	}
	if($row['fwaction']==1)
	{ 
		$e="ACCEPT";
	}else
	{
		$e="DROP";
	}
	if($row['fwwk']=="所有"){
		$wk="";
	}else{
		$wk="-i ".$row['fwwk'];
	}
	if($row['tall']==1)
	{
		$f="";
	}else 
	{
		$f=" -m time --timestart ".$row['tstart']." --timestop ".$row['tstop']." --weekdays ".$row['tday'];
		$f="";
	}
	$b="\$iptables -A INPUT ".$wk." -p ".$row['plproto']." ".$c." -s ".$row['fwsip']." -d ".$row['fwdip'].$f." -j ";
	/*
	if($row['fwlog']==1 && $osports==0)
	{
	$a.=$b." LOG --log-prefix \"".$row['fwname']."\"\n";
	
	}*/
	$a.=$b.$e."\n";
	}
}
/*
else {	//MAC
	$a=$a."\$iptables -t mangle -A PREROUTING -p ".$row['plproto']." -m multiport --dport ".$row['plport']." -m mac --mac-source ".$row['fwmac']." -j DROP\n";
}
*/
}

//MAC
/*
$sql="select * from firewall where fwstate=1";
$query=$db->query($sql);
while($row=$db->fetch_array($query))
{
 $a=$a."\$iptables -A FORWARD -m mac --mac-source ".$row['fwmac']." -j DROP\n";
}
*/
if($osports==0)
$a.="\$iptables -A INPUT -j DROP";
writeShell($firewall,$a);

//更新所有
$db->query("update firewall set fwisapp=1");
$db->query("update isapp set firewall=0");
$db->close();

system($firewall,  $rtnval);
showmessage('系统防火墙应用完毕','dfirewall.php');
?>
