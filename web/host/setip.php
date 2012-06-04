<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();

function create_net_netdel($db){
	global $network,$networkdel,$setgateway;
	$net = "#!/bin/bash\n\n";  //设置 IP
	$netdel = "#!/bin/bash\n\n"; //清除上次配置IP
	
	//从netface提取 接口
	$sql = "select * from netface where faceuse=1";
	$res = $db->query($sql);
	while ($row = $db->fetchAssoc($res)){
		
		//接口的ipv4地址
		$sql = "select * from netip where type=4 and ipname='".$row['facename']."'";
		$res4 = $db->query($sql);
		$i4 = 0;
		while ($r4 = $db->fetchAssoc($res4)){
			if ($i4 == 0){
				$net .= "ifconfig ".$r4['ipname']." ".$r4['ip']." netmask ".$r4['netmask']."\n";
				$netdel .= "ifconfig ".$r4['ipname']." 0.0.0.0\n";
			} else { 
				$net .= "ifconfig ".$r4['ipname'].":$i4 ".$r4['ip']." netmask ".$r4['netmask']."\n";
				$netdel .= "ifconfig ".$r4['ipname'].":$i4 down\n";
			}
				
			$i4++;
		}
		
		//接口的ipv6地址
		$sql = "select * from netip where type=6 and ipname='".$row['facename']."'";
	 	$res6 = $db->query($sql);
	 	while ($r6 = $db->fetchAssoc($res6)){
			$net .= "ifconfig ".$r6['ipname']." inet6 add ".$r6['ip']."/".$r6['netmask']." up\n";
			$netdel .= "ifconfig ".$r6['ipname']." inet6 del ".$r6['ip']."/".$r6['netmask']."\n";
		}
	}
	$net .= "$setgateway\n";  //加上网关。因为 清空ip后网关会自动清除
	//$net .= "/xmdns/network/setmac\n";  //MAC 双机热备
	file_put_contents($network, $net);
	chmod($network, 0755);
	
	file_put_contents($networkdel, $netdel);
	chmod($networkdel, 0755);
	/*
	$net = str_replace("\n", "<br>", $net);
	echo $net;
	echo '<p>';
	$netdel = str_replace("\n", "<br>", $netdel);
	echo $netdel;
	*/
}


if(isset($_POST['hid'])){
	checkac('应用');
	//1. 运行netdel
	exec($networkdel);
	
	//2. 生成network, 生成networkdel
	create_net_netdel($db);
	
	//3. 运行network
	exec($network);
	exec("service keepalived restart");
	writelog($db,'接口设置',"网口设置应用成功!");
	showmessage("网口设置应用成功","setip.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>接口设置</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 网络接口状态 </div>
<div class="content">
<form id="newstart" method="post" action="setip.php" > 
      <table width="768"align="center" class="s s_form">
      
        <tr>
          <td colspan="2"class="caption">网络接口状态</td>
        </tr>
		<? $s = "select * from netface";
		   $res = $db->query($s);
		   while ($r = $db->fetchAssoc($res))
		{ 
          $net=getnet($r['facename']);
        ?>
       	 <tr>
           <td><?echo $r['facename']?> 接口状态：</td>
           <td>&nbsp;<?echo $net;?> &nbsp;状态：<? if($r['faceuse']=='1') echo "开启"; else echo "停用"; ?>&nbsp;&nbsp;&nbsp; <a href="setips.php?if=<? echo $r['facename'];?>" ><font color="Red">设置</font></a></td>
         </tr>
         
        <? 
			$sql = "select * from netip where type=4 and ipname='".$r['facename']."'";
			$rs4=$db->query($sql);
			while($ip4=$db->fetchAssoc($rs4)) {
		?>
        <tr>
		  <td></td>
          <td>IPV4:&nbsp;<? echo $ip4['ip'];?>&nbsp;&nbsp;&nbsp;子网掩码：&nbsp;<? echo $ip4['netmask'];?> </td>
        </tr>
        <?  }
			$sql = "select * from netip where type=6 and ipname='".$r['facename']."'";
			$rs6=$db->query($sql);
			while($ip6=$db->fetchAssoc($rs6)){
		?>
        
        <tr>
		  <td></td>
          <td>IPV6: <? echo $ip6['ip']?>	/	<? echo $ip6['netmask']?></td> 
        </tr>
        <? 
		   }
		}
		?>
		
		<tr>
			<td colspan="2" class="footer">
				<input type="submit" value="应用设置" />&nbsp;应用后立即生效
				<input type="hidden" id="hid" name="hid" value="hid" />
			</td>
		</tr>
      </table></form>
  </div>
  <div class="push"></div>
<?$db->close();?></div>
<? include "../copyright.php";?>
</body>
</html>
