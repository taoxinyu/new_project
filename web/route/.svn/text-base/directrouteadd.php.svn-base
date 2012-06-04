<?
include ('../include/comm.php');
$pageaccess=0;
checklogin();
checkac();
$add=true;
$action=false;
if(isset($_REQUEST['action']))
{
	switch ($_REQUEST['action'])
	{
		case 'add':
			$action=false;
			$add=true;
			break;	
		case 'addaction':
			checkac('添加');
			$add=true;
			$action=true;
			$ipr='';
			$obj='';
			if(isset($_REQUEST['ipr']))
			{
				$ipr=$_REQUEST['ipr'];
			}
			if(isset($_REQUEST['obj']))
			{
				$obj=$_REQUEST['obj'];
			}
			$sql="insert into directroute(ipr,obj,type,nexthop,state,isapp,metric)values
			('$ipr','$obj','$_POST[type]','$_REQUEST[nexthop]',$_POST[state],1,'$_REQUEST[metric]');";
			$db->query($sql);
			$db->query("update isapp set staticroute=1");			
			showmessage("添加成功", "directroute.php");
			exit();
			break;
		case 'mod':
			$action=false;
			$add=false;
			$row=$db->fetch_array($db->query("select * from directroute where directid=$_REQUEST[directid];"));
			break;
		case 'modaction':
			checkac('修改');
			$action=true;
			$add=false;
			$ipr='';
			$obj='';
			if(isset($_REQUEST['ipr']))
			{
				$ipr=$_REQUEST['ipr'];
			}
			if(isset($_REQUEST['obj']))
			{
				$obj=$_REQUEST['obj'];
			}
			$sql="update directroute set ipr='$ipr',obj='$obj',type='$_REQUEST[type]',nexthop='$_REQUEST[nexthop]',state='$_REQUEST[state]',isapp=1,metric='$_REQUEST[metric]'
			 where directid='$_REQUEST[directid]';";
			$db->query("update isapp set staticroute=1");
			$db->query($sql);
			showmessage("更新成功", "directroute.php?rtid=$_REQUEST[routetable]");
			exit();
			break;
	}

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><? echo $system['xmtactype'];?></title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script  type="text/javascript"  src="../js/jquery.js" ></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="../js/jquery.validate.ext.js"></script>
<script type="text/javascript" >
function checklogin(){
	if($("input[name='type']").attr("checked")==true)
	{
		if(document.dir.ipr.value == ''){
			alert("请输入IP段");
			document.dir.ipr.select();
			return false;
		}else{
			if(!checkips(document.dir.ipr.value))
			{
				alert("IP段格式有误");
				document.dir.ipr.select();
				return false;
			}
		}
	}
		

	
	
	if(document.dir.nexthop.value == ''){
		alert("请输入下一跳地址");
		document.dir.nexthop.select();
		return false;
	}
	else
	{
		if(!checkip(document.dir.nexthop.value))
		{
			alert("IP格式有误");
			document.dir.nexthop.select();
			return false;
		}
	}
	
	
	if(!document.dir.metric.value == ''){
		
		if(!checkInt(document.dir.metric.value) || document.dir.metric.value<0 ||document.dir.metric.value>2147483647)
		{
			alert("请输入范围在0 到2147483647之间的数字");
			document.dir.metric.select();
			return false;
		}
	}
	

	return true;
}

function checkips(ip){
	var tel_ip = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
	var tel_ipd = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\/(\d|1\d|2\d|3[0-2])$/;
	if (!tel_ip.test(ip) && !tel_ipd.test(ip)) { 
		
	return false; 
	} 
	return true; 
}


$(
  function(){
	  $("input[name='type']").click(
		  function(){ 
			  var swap=$("input[name='ipr']").attr('disabled');
			  $("input[name='ipr']").attr('disabled',$("*[name='obj']").attr('disabled'));
			  $("*[name='obj']").attr('disabled',swap);
		  }
	  );
  }
);
</script>
</head>
<?
//判断是否有写到文件
$sql="select staticroute from isapp";
$query=$db->query($sql);
$row_app=$db->fetch_array($query);
$count=$row_app['staticroute'];
?>
<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 静态路由&gt;&gt; <?=$add?"添加":"修改"?>静态路由</div>
<ul class="tab-menu">

    <li><a href="directroute.php"> 静态路由</a></li>
	<li   class="on"> <span><?=$add?"添加":"修改"?>静态路由</span></li> 
	<?php if($count==1){?><li><a href="directroute.php?action=setstatic"> 应用</a> </li><?php }?>
</ul>
<div class="content">
    <form  method="post" name="dir" id="dir" onsubmit="return checklogin()">
    <input type="hidden" name="action" value="<?=$add?'addaction':'modaction'?>" />
      <table width="500" class="s s_form">
        <tr>
          <td colspan="3" class="caption"><?=$add?"添加":"修改"?>静态路由</td>
        </tr>

			<tr>
			<?
			$type1='checked';
			$type2='';
			$input1='';
			$input2='disabled';
			if(!$add)
			{
				if($row['type']!=1)
				{
					$type1='';
					$type2='checked';
					$input1='disabled';
					$input2='';
				}
			}
			?>
			
			<td rowspan="2"   style="text-align:right" width="20%">IP段：</td><td align="left"  bgcolor="#FFFFFF">
			<input name="type"  type="radio" value="1" <?=$type1?> />IP段&nbsp;&nbsp;&nbsp;
			<input   name="ipr" id="gateway" type="text" size="14" value="<?=!$add?$row['ipr']:''?>" <?=$input1?> />
			</td>
			<td width="38%">如192.168.1.0/24或192.168.1.10</td>
			</tr>
			<tr>
			<td class="11">
			<input name="type"  type="radio" value="2" <?=$type2?>/>ISP线路
			<select name="obj" id="port" <?=$input2?> >
			<?
			$nfrs=$db->query("select * from setacl where aclis=1;");
			$check='';
			while($nfrow=$db->fetch_array($nfrs))
			{
				if(!$add)
				{
					if($nfrow['aclid']==$row['obj'])
					{
						$check='selected';
					}
					else 
					{
						$check='';
					}
				}
				?>
			
				<option value="<?=$nfrow['aclid']?>"  <?=$check ?> ><?=$nfrow['aclident']?></option>
				<?
			}
			?>
			</select>
			</td>
			<td></td>
			</tr>
        <tr>
          <td>下一跳：</td>
          <td>
            <input  name="nexthop" id="ip" type="text"  size="23" value="<?=!$add?$row['nexthop']:''?>" />
          </td>
		  <td>如192.168.1.1</td>
        </tr>
        <tr>
          <td>路由优先级：</td>
          <td>
            <input  name="metric"  type="text"  size="23" value="<?=!$add?$row['metric']:''?>" /></td> 
			<td>范围:0到2147483647,可不填相当于0。数字越小，优先级越大！</td>
        </tr>
        <tr>
          <td>启用状态：</td>
          <td>
          <select name="state" >
              <option value="1" <?=$add?'':($row['state']==1?'selected':'')?> >开启</option>
              <option value="0" <?=$add?'':($row['state']==0?'selected':'')?> >关闭</option>
          </select>
          </td> 
		  <td></td>
        </tr> 
        <tr>
          <td class="footer" colspan="3"> <input type="submit" name="Submit" value="保存设置" />&nbsp;
			</td>
        </tr>
      </table>
     </form>
	</div>
<div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>