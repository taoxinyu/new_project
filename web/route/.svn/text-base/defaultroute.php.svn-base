<?
include ('../include/comm.php');
checklogin();
checkac();
if(isset($_REQUEST['Submit']))
{
		checkac('修改');
		$gw=$_REQUEST['gw'];
		$metric=$_REQUEST['metric_weight'];
		$blance=$_REQUEST['blance'];
		for($i=0;$i<5;$i++)
		{
			if(!empty($gw[$i]))
			{
				if($blance==1)
				{
					$str_weight=empty($metric[$i])?'':" weight $metric[$i]";
					$sh_con.=" nexthop via $gw[$i] $str_weight ";
					$sh_del_con=$sh_con;
				}
				else 
				{
					$str_metric=empty($metric[$i])?'':" metric $metric[$i]";
					$sh_con.="ip route add default via $gw[$i] $str_metric\n";
					$sh_del_con.="ip route del default via $gw[$i] $str_metric\n";
				}
			}
		}
		if(!empty($sh_con))
		{
			$sh_con=$blance==1?"ip route add default  $sh_con\n":$sh_con;
			$sh_del_con=$blance==1?"ip route del default  $sh_del_con\n":$sh_del_con;
		}
		exec($fdefault_route_del);
		$route = file_get_contents($fdefault_route);
		writeShell($fdefault_route, $sh_con);
		system($fdefault_route,$rs);
		if($rs==0){
			for($i=0;$i<5;$i++)
			{
				$m=empty($metric[$i])?'null':(int)$metric[$i];
				$gwip=empty($gw[$i])?'null':"'$gw[$i]'";
				$dtid=$i+1;
				if($db->fetch_array($db->query("select 1 from defaultroute where dtid=$dtid")))
				{
					
					$db->query("update defaultroute set gw=$gwip,metric=$m,blance=$blance where dtid=$dtid");
				}
				else 
				{
					$db->query("insert into defaultroute(dtid,gw,metric,blance) values ($dtid,$gwip,$m,$blance)");
				}
			}
			writeShell($fdefault_route_del, $sh_del_con);
			showmessage("设置成功", "defaultroute.php");
		}else{
			writeShell($fdefault_route, $route);
			exec($fdefault_route);
			showmessage("设置失败", "defaultroute.php");
		}
		//echo $sh_del_con;
		
		
		exit();
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><? echo $system['xmtactype'];?></title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<style type="text/css">
table.thin
{
	margin:2px auto;
	border-collapse:collapse;
	border:0px none #F9F9F9;	
}
table.thin td
{
	border:1px solid #82C4E8;
}
table.thin .title td
{
	border:0px none #F9F9F9;
	background:#F9F9F9;
}
</style>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="../js/jquery.validate.ext.js"></script>
<script language="javascript">
function checklogin(){
	for(var i=1;i<=5;i++){
	  if($(".gw"+i).val()!= ''){
		if ( !checkip($(".gw"+i).val()))
		{ 
			alert("请输入正确的网关"+i);
		    $(".gw"+i).focus();
		  return false;
		 }
	}
	var exp=/^(0|([1-9]\d*))(\.\d+)?$/ ;
	if($(".metric"+i).val()!= ''){	
		if(!checkdigits($(".metric"+i).val())){
            $(".metric"+i).focus();
			return false;
		}else{
	    if($("#blance").val()==0){
		  if($(".metric"+i).val()<0 || $(".metric"+i).val()>2147483647)
		 { 
			 alert("网关"+i+"的优先级范围是0到2147483647");
		     $(".metric"+i).focus();
		   return false;
		 }
	   }else{
		 if($(".metric"+i).val()<1 || $(".metric"+i).val()>256)
		{ 
			alert("网关"+i+"的权重范围是1到256");
		    $(".metric"+i).focus();
		  return false;
		}
	  }
	}
  }	
}
return true;
}
function checkip(obj)
{
	var exp=/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
	var reg = obj.match(exp);
	if(reg==null)
		return false;
	return true;
} 
function checkdigits(obj){
	var exp=/^(-|\d)+$/;
	var reg = obj.match(exp);
	if(reg==null){
	  alert('优先级/权重必须是数字！');
	  return false;
	}		
	return true;
}
</script>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 默认路由</div>
<div class="content">
<form  method="post" id="defaulte" name="defaulte" onsubmit="return checklogin();">
      <table class="s s_form" width="500" >        
        <tr>
          <td colspan="3" class="caption">默认路由</td>
		</tr>
		<?php 
		for($i=1;$i<6;$i++)
		{
			$default_q=$db->query("select * from defaultroute where dtid=$i");
			if($row=$db->fetch_array($default_q))
			{
				$gw=$row['gw'];
				$metric=$row['metric'];
				$blance=$row['blance'];
			}
			else 
			{
				$gw='';
				$metric='';
				$blance=0;
			}

		?>
			<tr>
			<td>网关<?php echo $i?>：</td>
			<td>
			<input  name="gw[]" class="gw<?php echo $i?>" type="text" value="<?=$gw?>" /> 
			</td>
			<td width="38%">
			例如 192.168.1.1
			</td>
			</tr>
			<tr>
			<td>优先级/权重：</td>
			<td>
			<input  name="metric_weight[]" class="metric<?php echo $i?>" type="text" value="<?=$metric?>" /> 
			</td>
			<td>			
			负载均衡关闭时表示路由优先级，开启时表示负载权重(比重)。优先级范围是0到2147483647，权重范围是1到256
			</td>
			</tr>
		<?php 
		}
		?>

        <tr>
          <td>负载均衡：</td>
          <td>
          <select name="blance" id="blance">
              <option value="1" <?=$blance==1?'selected':'' ?> >开启</option>
              <option value="0" <?=$blance==0?'selected':''?> >关闭</option>
          </select></td>
          <td>
          </td>
        </tr>
        <tr>
          <td  class="footer" colspan="3">
		  <input type="submit" name="Submit" value="保存设置" /></td>
        </tr>
      </table>
    </form>
   </div>
 <div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
