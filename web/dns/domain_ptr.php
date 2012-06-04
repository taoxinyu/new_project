<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
//checkac('应用');
checkac_do(6);
$domainid=$_GET["domainid"];
$query=$db->query("select * from domain where domainid=".$domainid);
$row=$db->fetchAssoc($query);
$domainname=$row['domainname'];

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>域名反解自动生成设置</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 域名设置 </div>
<ul class="tab-menu">
    <li><a href="record.php?domainid=<?echo $domainid?>">记录管理 </a></li>
    <li><a href="record_add.php?domainid=<?echo $domainid?>">记录添加</a></li>
    <li><a href="domain.php">域名管理</a></li>
	<li><a href="domain_ptr.php?domainid=<?echo $domainid?>" onclick="javascript:return   confirm('真的要自动生成本域名的反向解析记录吗？');">自动生成本域名反向解析</a></li>     
</ul>
<div class="content">
		  <table width="95%"  align="center" class="s s_grid">
		  <tr>
          <td  class="caption"><?echo $domainname?>域名反向解析自动生成</td>
        </tr>
            <tr>
              <td>正在进行生成<?echo $domainname?>域名反解：<br>
              <?$sql="select * from drecord where ddomain=".$domainid;
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
              				$sql ="select count(*) as num from drecord where ddomain=$mydomainid and dname='".$rcd."' and dvalue='".$row['dname'].".".$domainname.".' and dacl='".$row['dacl']."'";
              				$q=$db->query($sql);
							$r=$db->fetchAssoc($q);
              				if($r['num']==0){
              					//插进记录
								$sql="insert into drecord (ddomain,dname,dys,dtype,dvalue,dacl,dis,disapp,dupdate)values(".$mydomainid;
								$sql=$sql.",'".$rcd."',0,'PTR','".$row['dname'].".".$domainname.".','".$row['dacl'];
								$sql=$sql."','1','0',datetime('now','localtime'))";
								$db->query($sql);
								$n=$db->query("select count(*) cnt from drecord where ddomain=".$mydomainid)->fetch();
								$sql="update domain set domainnum=".$n['cnt']." where domainid=".$mydomainid;
								$db->query($sql);
								echo "创建".$row['dacl']."线路反解：".$rcd."    IN     PTR     ".$row['dname'].".".$domainname.".<br>";
							}
              			}else 
              			{
              				//反解文件不存在则创建
              				//建域名
              				$sql="select * from setdns where dnsid=1";
              				$q=$db->query($sql);
              				$r=$db->fetchAssoc($q);
              				$mydns=$r['dnsname'].".".$r['dnsdomain'].".";
              				$sql="insert into domain (domainname,domainadmin,domainsoa,domainserial,domainrefresh,domainretry,domainexpire,domainttl,domainis,domainisapp,domainupdate,domainnum)values(";
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
							echo "创建".$myptrname."反解域名<br>";
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
								echo "创建".$aclrow['aclident']."线路记录：@    IN     NS     ".$mydns."<br>";
								$sql="update domain set domainnum=domainnum+1 where domainid=".$mydomainid;
								$db->query($sql);
              				}
              				//通用NS
              				$sql="insert into drecord (ddomain,dname,dys,dtype,dvalue,dacl,dis,disapp,dupdate)values(".$mydomainid;
							$sql=$sql.",'@',0,'NS','".$mydns."','ANY";
							$sql=$sql."','1','0',datetime('now','localtime'))";
							$db->query($sql);
							echo "创建通用线路记录：@    IN     NS     ".$mydns."<br>";
							$sql="update domain set domainnum=domainnum+1 where domainid=".$mydomainid;
							$db->query($sql);
              				//写入反解记录
							$sql="insert into drecord (ddomain,dname,dys,dtype,dvalue,dacl,dis,disapp,dupdate)values(".$mydomainid;
							$sql=$sql.",'".$rcd."',0,'PTR','".$row['dname'].".".$domainname.".','".$row['dacl'];
							$sql=$sql."','1','0',datetime('now','localtime'))";
							$db->query($sql);
							$n=$db->query("select count(*) cnt from drecord where ddomain=".$mydomainid)->fetch();
							$sql="update domain set domainnum=".$n['cnt']." where domainid=".$mydomainid;
							$db->query($sql);
							echo "创建".$row['dacl']."线路反解：".$rcd."    IN     PTR     ".$row['dname'].".".$domainname.".<br>";
              				
              			}
              		}
              	}
              	
              }
              //完成创建
              writelog($db,'域名管理',"自动创建域名：".$domainname."反解!");
			$db->close();
			//showmessage('自动创建域名反解成功!',0);
              ?>
              </td>
            </tr>
		  <tr><td><input type="button" onclick="javascript:history.go(-1)" value="返回"></td></tr>
          </table></div><div class="push"></div></div>

<? $db->close();?>
<? include "../copyright.php";?>
</body>
</html>
