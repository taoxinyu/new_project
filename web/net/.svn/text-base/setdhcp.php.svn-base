<?
include ('../include/comm.php');
checklogin();
checkac();
checkac('应用');
//更新网络设置更新


$c="default-lease-time 86400;\n";
$c.="max-lease-time 86400;\n";
$d="DHCPDARGS=\"";
$a="#!/bin/bash\n";
$a=$a.$dhcpdcmd." start";
$sql="select distinct dheth from dhcp where dhstate=1";
$query=$db->query($sql);
while($row=$db->fetch_array($query))
{
	$d.=$row['dheth'] . " ";
}
$sql="select * from dhcp where dhstate=1";
$query=$db->query($sql);
while($row=$db->fetch_array($query))
{
	$c.="subnet ".$row['dhip']." netmask ".$row['dhmask']." {\n";
	$c.="default-lease-time $row[defaultrelease] ;\n";
	$c.="max-lease-time $row[maxrelease] ;\n";
	$c.="option routers ".$row['dhgateway'].";\n";
	$c.="option subnet-mask ".$row['dhmask'].";\n";
	$c.="option domain-name-servers ".$row['dhdns1'];
	if($row['dhdns2']!='')
	{
		$c.=",".$row['dhdns2'].";\n";
	}
	else
	{
		$c.=";\n";
	}
	if($row['dhwig1']!='')
	{
		$c.="option netbios-name-servers ".$row['dhwig1']."";
		if($row['dhwig2']!='')
		{
			$c.=",".$row['dhwig2'].";\n";
		}
		else
		{
			$c.=";\n";
		}
	}
	$c.="range ".$row['dhrange']." ".$row['dhrange1'].";\n";
	$c.="}\n";
}
$d.="\"\n";
writeFile($dhcpdconf,$c);
writeFile($dhcpd,$d);
writeFile($setdhcp,$a);
//更新所有
$db->query("update dhcp set dhisapp=1");
$db->query("update isapp set dhcp=0");
$db->close();
/*
$sql1="select * from dhcp";
$query1=$db->query($sql1);
*/

system($dhcpdcmd." restart > /dev/null");
showmessage('DHCP应用完毕','dhcp.php');
?>