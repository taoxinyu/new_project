<?php
include ('../include/comm.php');
include ('../mail/sendmail.php');
checklogin();
checkac();
$mes="";
$queryOld=$db->query("select * from twohosts");
$rowOld=$db->fetchAssoc($queryOld);
$isapp="";
exec("service keepalived status",$isapp);
if(strstr($isapp[0], "pid")){
	$autoNew=0;
}else{
	$autoNew=1;
}
if ($_POST['Submit']) {
	$ripname1=$_POST['ripname1'];
	$ripname2=$_POST['ripname2'];
	$autport1=$_POST['autport1'];
	$autport2=$_POST['autport2'];
	$hostype1=$_POST['hostype1'];
	$hostype2=$_POST['hostype2'];
	$vIP1=$_POST['vIP1'];
	$vIP2=$_POST['vIP2'];
	$vroute1=$_POST['vroute1'];
	$vroute2=$_POST['vroute2'];
	$heartTime1=$_POST['heartTime1'];
	$heartTime2=$_POST['heartTime2'];
	$getapp=$_POST['autoNew'];
	if($getapp==0){
		$keepconf="";
	
			if($hostype1==0){
				$htye="MASTER";
				$priority=100;
			}else {
				$htye="BACKUP";
				$priority=99;
			}
			$keepconf.="vrrp_instance VI_1 {\n";
			$keepconf.="    state ".$htye."\n";
			$keepconf.="    interface ".$ripname1."\n";
			$keepconf.="    virtual_router_id ".$vroute1."\n";
			$keepconf.="    priority ".$priority."\n";
			$keepconf.="    advert_int ".$heartTime1."\n"; 
			$keepconf.="    authentication {\n";
			$keepconf.="        auth_type PASS\n";
			$keepconf.="        auth_pass 1111\n";
			$keepconf.="    }\n";
			$keepconf.="     virtual_ipaddress {\n";
			$keepconf.="        ".$vIP1."\n";
			$keepconf.="    }\n ";	
			$keepconf.="     notify_master /xmdns/sh/master.sh\n";
			$keepconf.="} \n";	
		if(writeFile("/etc/keepalived/keepalived.conf",$keepconf)){
			$mes.="设置成功！";
		}else{
			$mes.="设置失败!";
		}
		exec("service keepalived restart");
		exec("service keepalived status",$isa);
		if(strstr($isa[0], "pid")){
			$mes.="服务已开启";
		}else{
			$mes.="但是无法启动服务";
		}
	}else{
		exec("service keepalived stop");
		$mes="设置成功，服务已经关闭！";
	}
	$sql="update twohosts set ripname1='".$ripname1."',hostype1=".$hostype1.",vIP1='".$vIP1."',vroute1=".$vroute1.",heartTime1=".$heartTime1;
	$db->query($sql);

	showmessage($mes,"twohosts.php");
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>双机热备</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<script src="/js/jquery.js"  type="text/javascript"charset="utf-8" ></script>
<script src="/js/ximo_dns.js"  type="text/javascript" charset="utf-8"></script>
<script language="javascript">
function checkTwohost(){

			if(document.twohost.vIP1.value == ''){
			alert("请输入虚拟IP");
			document.twohost.vIP1.select();
			return false;
		}
		else
		{
			if(!checkip(document.twohost.vIP1.value)  && !checkipv6(document.twohost.vIP1.value))
			{
				alert("输入虚拟IP有误！");
				document.twohost.vIP1.select();
				return false;
			}
		}
			if(document.twohost.vroute1.value == ''){
			alert("请输入虚拟路由ID");
			document.twohost.vroute1.select();
			return false;
		}
		else
		{
			if(!checkInt(document.twohost.vroute1.value)||document.twohost.vroute1.value<=0)
			{
				alert("请输入大于零的数字");
				document.twohost.vroute1.select();
				return false;
				
			}
		}
		if(document.twohost.heartTime1.value == ''){
			alert("请输入心跳时间");
			document.twohost.heartTime1.select();
			return false;
		}
		else
		{
			if(!checkInt(document.twohost.heartTime1.value)||document.twohost.heartTime1.value<=0)
			{
				alert("请输入大于零的数字");
				document.twohost.heartTime1.select();
				return false;
			}
		}
	
	return true;
}


</script>
</head>

<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; 双机热备</div>
<div class="content">
 <form id="twohost" name="twohost" method="post" action="twohosts.php" onsubmit="return checkTwohost()">
      <table  width="778"    class="s s_form" >
       <tr>
          <td  colspan="4"  class="caption" >双机热备</td>
        </tr>
        
         <tr>
          <td class="title">监控端口：</td>
          <td>
             <select name="ripname1" id="ripname1">
			<!--<option value="0"> </option>-->
			<? $s = "select * from netface";
		   $res = $db->query($s);
		   while ($r = $db->fetchAssoc($res))
		{ 
        ?>
             <option value="<?echo $r['facename']?>" <?php if($rowOld['ripname1']==$r['facename']) echo "selected"; ?> ><?echo $r['facename']?></option>
             <?php } ?>
             </select>
           	</td>
     

        
         <tr>
           <td class="title">本机端口状态：</td>
           <td>         
           <select name="hostype1" id="hostype1">
           <option value="0" <?php if($rowOld['hostype1']==0) echo "selected"; ?> >主机方式</option>
           <option value="1" <?php if($rowOld['hostype1']==1) echo "selected"; ?> >备用方式</option>
           </select>
           </td>
         </tr>
         <tr>
          <td class="title">虚拟IP：</td>
          <td>
          <input name="vIP1" type="text" id="vIP1" value="<? echo $rowOld['vIP1']; ?>" />
</td>
        </tr>

        <tr>
          <td class="title">虚拟路由ID：</td>
          <td><input name="vroute1" type="text" id="vroute1" value="<? echo $rowOld['vroute1']; ?>" />
          
</td>

        </tr>         
        

        <tr>
          <td class="title">心跳时间：</td>
          <td><input name="heartTime1" type="text" id="heartTime1" value="<? echo $rowOld['heartTime1']; ?>" />
          秒&nbsp;&nbsp;
</td>
        </tr> 

                      <tr>
        <td>（<?php if ($autoNew==1) echo "服务已关闭";else echo "服务已开启" ?>）</td>
          <td colspan="3">
          <input type="radio" name="autoNew" id="yautoNew" value="0" <?php if($autoNew==0) echo "checked"; ?> />开启
          <input type="radio" name="autoNew" id="nautoNew" value="1" <?php if($autoNew==1) echo "checked"; ?> />关闭
          </td>
        </tr>
        <tr>
          <td  colspan="4"  class="footer" >
            <input type="submit" name="Submit" value="保存设置" />
          </td>
        </tr>

      </table>
      <br>
      
      
      
      
      </form>
</div><div class="push"></div>
<? $db->close();?>
</div>
<? include "../copyright.php";?>
</body>
</html>
