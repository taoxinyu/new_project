<?
include ('../include/comm.php');
checklogin();
checkac();

//更新代理上网设置
$sql="select * from firewall,timeset,portlist where firewall.fwtime=timeset.tid and firewall.fwprotol=portlist.plid and firewall.fwstate=1 order by fwnumber desc";
$query=$db->query($sql);
$a="#!/bin/sh\n";
$a.="iptables=\"/usr/local/sbin/iptables\"\n";
$a.="\$iptables -F INPUT\n";
$a.="\$iptables -F OUTPUT\n";
while($row=$db->fetch_array($query))
{
	if($row['fwdirect']==0)
	{
		$d="INPUT";
		$c=" -m multiport --dport ".$row['plport'];
	}else 
	{
		$d="OUTPUT";
		$c=" -m multiport --sport ".$row['plport'];
	}
	if($row['fwaction']==1)
	{
		$e="ACCEPT";
	}else 
	{
		$e="DROP";
	}
	if($row['tall']==1)
	{
		$f="";
	}else 
	{
		$f=" -m time --timestart ".$row['tstart']." --timestop ".$row['tstop']." --weekdays ".$row['tday'];
	}
	$b="\$iptables -A ".$d." -p ".$row['plproto']." ".$c." -s ".$row['fwsip']." -d ".$row['fwdip'].$f." -j ";
	if($row['fwlog']==1)
	{
	$a.=$b." LOG --log-prefix \"".$row['fwname']."\"\n";
	}
	$a.=$b.$e."\n";
}

writeFile($firewall,$a);
//更新所有
$db->query("update firewall set fwisapp=1");
$db->query("update isapp set firewall=0");
$db->close();

system($firewall,  $rtnval);
showmessage('系统防火墙应用完毕','dfirewall.php');
?>
