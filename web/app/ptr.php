<?php
/*
 +-----------------------------------------------------
 * 	2010-2-25
 +-----------------------------------------------------
 *		
 +-----------------------------------------------------
 */

/**
 *  将ip地址反向
 *  ipptr($ip)
 *  参数：	ip地址
 *  返回值： 一个数组，ip地址反解的两部分。
 */
function ipptr($ip6){
	$full = "";
	$rst = "";
	if (filter_var($ip6, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)){//ipv6
		if (strpos($ip6, "::") === false){ //没有"::"
			$yus = explode(":", $ip6);
			
			foreach ($yus as $yu){
			
				//恢复省略的前导0
				$zeros = 4 - strlen($yu) ;
				if ($zeros == 1)
					$full .= "0";
				else if ($zeros == 2)
					$full .= "00";
				else if ($zeros == 3)
					$full .= "000";
				
				$full .= $yu;
			}
		}
		else {								//有 "::"
			$yus = explode(":", $ip6);
			
			$num = 8 - count($yus) + 1;
			
			foreach ($yus as $yu){
				if ($yu == ""){ //恢复 "::"
					//第二次 $yu == "" 时, $num 等于 0。说明 "::"  位于首或尾，应加 0000
					if ($num == 0)
						$yu .= "0000";
						
					for ($num; $num > 0; $num--){
						$yu .= "0000";
					}
					$full .= $yu;
				}
				else {//恢复省略的前导0
					$zeros = 4 - strlen($yu) ;
					if ($zeros == 1)
						$full .= "0";
					else if ($zeros == 2)
						$full .= "00";
					else if ($zeros == 3)
						$full .= "000";
					
					$full .= $yu;
				}
			}
		}
		$fx = array_reverse(str_split($full, 1));
		$fx2 = implode(".", $fx);
		$rs[0] = strtolower(substr($fx2, 32).".ip6.arpa");
		$rs[1] = substr($fx2, 0, 31);
		return $rs;
	}
	else{//ipv4
		$ip=preg_split('/\./',$ip6);
        $rs[0]=$ip[2].".".$ip[1].".".$ip[0].".in-addr.arpa";
        $rs[1]=$ip[3];
        return $rs;
	}
}


$domainid=$doid;
$query=$db->query("select * from domain where domainid=".$domainid);
$row=$db->fetchAssoc($query);
$domainname=$row['domainname'];

$sql="select * from drecord where ddomain=".$domainid;
$query=$db->query($sql);
$valid_chars = "1234567890-_.";
while ($row=$db->fetchAssoc($query)) {
	//泛域名不创建反解
	if (!stristr($row['dname'],"*"))
	{
		if ( filter_var($row['dvalue'], FILTER_VALIDATE_IP) )
		{
			//判断若是IP,然后看反解存不存在
			
			//$ip=preg_split('/\./',$row['dvalue']);
			//$myptrname=$ip[2].".".$ip[1].".".$ip[0].".in-addr.arpa";
			
			$rs = ipptr($row['dvalue']); //反解IP
			$myptrname = $rs[0];
			$rcd = $rs[1];
			$q=$db->query("select * from domain where domainname='".$myptrname."'");
			$num=$db->num_rows($q);
			if($num>0)
			{
				//反解文件存在直接添加进去
				$q=$db->query("select * from domain where domainname='".$myptrname."'");
				$r=$db->fetchAssoc($q);
				$mydomainid=$r['domainid'];
				
				//先删除旧记录，重复记录
				$sql ="select * from drecord where ddomain=$mydomainid and dname='".$rcd."' and dvalue='".$row['dname'].".".$domainname.".' and dacl='".$row['dacl']."'";
				$abcd=$db->query($sql);
				$num=$db->num_rows($abcd);
				if($num>0){
				$sql ="delete from drecord where ddomain=$mydomainid and dname='".$rcd."' and dvalue='".$row['dname'].".".$domainname.".' and dacl='".$row['dacl']."'";
				$db->query($sql);
				$sql="update domain set domainnum=domainnum-1 where domainid=".$mydomainid;
				$db->query($sql);				
				}
				//插进记录
				$sql="insert into drecord (ddomain,dname,dys,dtype,dvalue,dacl,dis,disapp,dupdate)values(".$mydomainid;
				$sql=$sql.",'".$rcd."',0,'PTR','".$row['dname'].".".$domainname.".','".$row['dacl'];
				$sql=$sql."','1','0',datetime('now','localtime'))";
				$db->query($sql);
				$sql="update domain set domainnum=domainnum+1 where domainid=".$mydomainid;
				$db->query($sql);
			}
			else 
			{
				//反解文件不存在则创建
				//建域名
				$sql="select * from setdns where dnsid=1";
				$q=$db->query($sql);
				$r=$db->fetchAssoc($q);
				$mydns=$r['dnsname'].".".$r['dnsdomain'].".";
				$sql="insert into domain (domainname, domainadmin, domainsoa, domainserial, domainrefresh, domainretry, domainexpire, domainttl, domainis, domainisapp, domainupdate, domainnum)values(";
				$sql=$sql."'".$myptrname."','".$r["dnsadmin"]."','".$r['dnsname'].".".$r['dnsdomain']."',".createnewserial().",".$r['dnsrefresh'];
				$sql=$sql.",".$r['dnsretry'].",".$r['dnsexpire'].",".$r['dnsttl'].",'1','0',datetime('now','localtime'),0)";
				$db->query($sql);
				$id = $db->fetchAssoc($db->query("SELECT domainid FROM domain ORDER BY domainid DESC LIMIT 1"));
				for($i=2;$i<=6;$i++){
					$sql="insert into do_access (role_id,domain_id,privilege_id,status) values($_SESSION[role],$id[domainid],$i,1)";
					$db->query($sql);
				}
				if($_SESSION['role']!=1){
					for($i=2;$i<=6;$i++){
						$sql="insert into do_access (role_id,domain_id,privilege_id,status) values(1,$id[domainid],$i,1)";
						$db->query($sql);
					}
				}
				//建立NS记录
				$q=$db->query("select * from domain where domainname='".$myptrname."'");
				$r=$db->fetchAssoc($q);
				$mydomainid=$r['domainid'];
				//查找线路
				$acl=$db->query("select * from setacl");
				while($aclrow=$db->fetchAssoc($acl)){
				//每条线路插入一个NS
 				$sql="insert into drecord (ddomain,dname,dys,dtype,dvalue,dacl,dis,disapp,dupdate)values(".$mydomainid;
				$sql=$sql.",'@',0,'NS','".$mydns."','".$aclrow['aclident'];
				$sql=$sql."','1','0',datetime('now','localtime'))";
				$db->query($sql);
				$sql="update domain set domainnum=domainnum+1 where domainid=".$mydomainid;
				$db->query($sql);
				}
				//通用NS
				$sql="insert into drecord (ddomain,dname,dys,dtype,dvalue,dacl,dis,disapp,dupdate)values(".$mydomainid;
				$sql=$sql.",'@',0,'NS','".$mydns."','ANY";
				$sql=$sql."','1','0',datetime('now','localtime'))";
				$db->query($sql);
				$sql="update domain set domainnum=domainnum+1 where domainid=".$mydomainid;
				$db->query($sql);
				//写入反解记录
				$sql="insert into drecord (ddomain,dname,dys,dtype,dvalue,dacl,dis,disapp,dupdate)values(".$mydomainid;
				$sql=$sql.",'".$rcd."',0,'PTR','".$row['dname'].".".$domainname.".','".$row['dacl'];
				$sql=$sql."','1','0',datetime('now','localtime'))";
				$db->query($sql);
				$sql="update domain set domainnum=domainnum+1 where domainid=".$mydomainid;
				$db->query($sql);
				
			}
		}
	}
}
//完成创建
writelog($db,'域名管理',"自动创建域名：".$domainname."反解!");
?>