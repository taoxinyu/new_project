<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();

function create_net_netdel($db){
	global $network,$networkdel,$setgateway;
	$net = "#!/bin/bash\n\n";  //���� IP
	$netdel = "#!/bin/bash\n\n"; //����ϴ�����IP
	
	//��netface��ȡ �ӿ�
	$sql = "select * from netface where faceuse=1";
	$res = $db->query($sql);
	while ($row = $db->fetchAssoc($res)){
		
		//�ӿڵ�ipv4��ַ
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
		
		//�ӿڵ�ipv6��ַ
		$sql = "select * from netip where type=6 and ipname='".$row['facename']."'";
	 	$res6 = $db->query($sql);
	 	while ($r6 = $db->fetchAssoc($res6)){
			$net .= "ifconfig ".$r6['ipname']." inet6 add ".$r6['ip']."/".$r6['netmask']." up\n";
			$netdel .= "ifconfig ".$r6['ipname']." inet6 del ".$r6['ip']."/".$r6['netmask']."\n";
		}
	}
	$net .= "$setgateway\n";  //�������ء���Ϊ ���ip�����ػ��Զ����
	//$net .= "/xmdns/network/setmac\n";  //MAC ˫���ȱ�
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
	checkac('Ӧ��');
	//1. ����netdel
	exec($networkdel);
	
	//2. ����network, ����networkdel
	create_net_netdel($db);
	
	//3. ����network
	exec($network);
	exec("service keepalived restart");
	writelog($db,'�ӿ�����',"��������Ӧ�óɹ�!");
	showmessage("��������Ӧ�óɹ�","setip.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>�ӿ�����</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;��ǰλ��:&gt;&gt; ����ӿ�״̬ </div>
<div class="content">
<form id="newstart" method="post" action="setip.php" > 
      <table width="768"align="center" class="s s_form">
      
        <tr>
          <td colspan="2"class="caption">����ӿ�״̬</td>
        </tr>
		<? $s = "select * from netface";
		   $res = $db->query($s);
		   while ($r = $db->fetchAssoc($res))
		{ 
          $net=getnet($r['facename']);
        ?>
       	 <tr>
           <td><?echo $r['facename']?> �ӿ�״̬��</td>
           <td>&nbsp;<?echo $net;?> &nbsp;״̬��<? if($r['faceuse']=='1') echo "����"; else echo "ͣ��"; ?>&nbsp;&nbsp;&nbsp; <a href="setips.php?if=<? echo $r['facename'];?>" ><font color="Red">����</font></a></td>
         </tr>
         
        <? 
			$sql = "select * from netip where type=4 and ipname='".$r['facename']."'";
			$rs4=$db->query($sql);
			while($ip4=$db->fetchAssoc($rs4)) {
		?>
        <tr>
		  <td></td>
          <td>IPV4:&nbsp;<? echo $ip4['ip'];?>&nbsp;&nbsp;&nbsp;�������룺&nbsp;<? echo $ip4['netmask'];?> </td>
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
				<input type="submit" value="Ӧ������" />&nbsp;Ӧ�ú�������Ч
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