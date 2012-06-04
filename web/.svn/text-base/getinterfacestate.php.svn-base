<?php
require_once 'include/comm.php';
$state=array();
foreach ($netface as $if )
{
    //接口名称
	$s=trim(`ethtool $if|grep 'Link detected'|cut -d: -f2`);	//接口启用状态
	$s2=$s;
	$s=$s=='yes'?'1':'0';
	$ip=trim(`ifconfig $if|grep -i 'inet addr'|cut -d: -f2|cut -d ' ' -f1`);//ip
	$ip=$ip!=''?$ip:iconv('GBK','UTF-8','无');
	$port=trim(`ethtool $if|grep -i  'Port:'|cut -d: -f2`);		//接口介质类型
	$port=$port=='FIBRE'?'光纤':'双绞';
	$port=iconv('GBK','UTF-8',$port);
	$speed=trim(`ethtool $if|grep -i 'speed'|cut -d: -f 2|grep -i -v 'Unknown'`);
	$speed=$speed!=''?$speed:iconv('GBK','UTF-8','未知');
	$duplex=strtolower(trim(`ethtool $if|grep -i 'Duplex'|cut -d: -f2`));
	if($duplex=='full')
		$duplex='全双工';
	elseif($duplex=='half')
		$duplex='半双工';
	else 
		$duplex='未知';
	$rx=trim(`ifconfig $if|grep 'RX bytes'|cut -d: -f 2| awk '{ print $1}'`);
	$tx=trim(`ifconfig $if|grep 'RX bytes'|cut -d: -f 3| awk '{ print $1}'`);
	$duplex=iconv('GBK','UTF-8',$duplex);
	$state[]=array('name'=>$if,'ip'=>$ip,'state'=>$s,'port'=>$port,'speed'=>$speed,'duplex'=>$duplex,'state2'=>$s2
	,'rx'=>$rx,'tx'=>$tx
	);
}
echo json_encode($state);
?>
