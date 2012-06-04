<?
include ('../include/comm.php');
//$pageaccess=0;
checklogin();
checkac();
if($_GET['clear']=='all')
	{
		$a="";
		 writeFile($dhcpuserfile,$a);	
	}
//checkaccess($pageaccess,$_SESSION['role']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>DHCP用户列表</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
</head>
<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; DHCP设置 </div>
<ul class="tab-menu">    
    <li><a href="dhcp.php">DHCP设置列表</a></li>
	<li><a href="dhcp_add.php">添加DHCP设置</a></li>
	<li class="on"><span>DHCP用户列表</span></li>  
</ul>
<div class="content"><table width="90%"  class="s s_grid" >
      <tr >
        <td colspan="10" class="caption">DHCP用户列表  <a href="?clear=all" onclick="javascript:return confirm('真的要清空全部记录吗？');">清空全部</a></td>
      </tr>
      <tr>
        <th width="21%">IP地址</th>
        <th width="23%">计算机名</th>
        <th width="20%">MAC地址</th>
        <th width="18%">起始时间</th>
        <th width="18%">到期时间</th>
      </tr>
	  <?
	  $str=file_get_contents($dhcpuserfile);
	  $str1=trim(substr($str,strpos($str,"isc-dhcp-4.1.0p1")+16));
	  $str2=strrev(substr(strrev($str1),strpos(strrev($str1),"}")));
	  $user_count=substr_count($str2,"}");
	  for($i=0;$i<$user_count;$i++){
		 $user=trim(substr($str2,0,strpos($str2,"}")+1));
		 if(strpos($user,"active")){
			  if(strpos("-".$user,"server-duid")){				  
                 $user=trim(substr($user,strpos($user,";")+1));
			  }
		      $ip=substr($user,6,strpos($user,"{")-6);
			  if(strlen($ip)>20){
			  $abc=explode("\n",$ip);
			  $de=explode(" ",$abc[3]);
			  $ip=$de[1];			  
			  }
		      $str3=substr($user,strpos($user,"starts"));
		      $startt=substr($str3,9,strpos($str3,";")-9);
			  $startt1=strtotime($startt)+28800;
			  $start=date('Y-m-d H:i:s',$startt1);
		      $str4=substr($str3,strpos($str3,"ends"));
		      $endss=strtotime(substr($str4,7,strpos($str4,";")-7))+28800;
			  $ends=date('Y-m-d H:i:s',$endss);
		      $str5=substr($str4,strpos($str4,"ethernet"));
		      $mac=substr($str5,9,strpos($str5,";")-9);  
		      if(strpos($str5,"client-hostname")){	
			      $str6=substr($str5,strpos($str5,"client-hostname"));
			      $hostname=trim(substr($str6,16,strpos($str6,";")-16),"\"");			  	  
		      }else{
			      $hostname="";			  
		      }
		  ?>
		  <tr align="center">
		  <td><?php echo $ip;?></td>
          <td><?php echo $hostname;?></td>
		  <td><?php echo $mac;?></td>
		  <td><?php echo $start;?></td>
		  <td><?php echo $ends;?></td>
		</tr>
		  <?
		  }
		  $str2=substr($str2,strpos($str2,"}")+1);		 
	  }
	  ?>	      
    </table></div>
<div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
