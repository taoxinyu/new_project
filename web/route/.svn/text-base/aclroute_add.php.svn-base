<?
/**********************
 * 策略路由添加,查看,修改
 *********************/
include ('../include/comm.php');
checklogin();
checkac();
$add=true;
$action=false;
$view=false;
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
			$q_cnt=$db->fetch_array($db->query("select count(*) cnt from aclroute"));
			if($q_cnt['cnt']>=252)
			{
				showmessage("策略路由最多只能添加252个，已达到了限制", "policyroute.php");
			}
			
			$level=$_REQUEST['level']==''?"null":$_REQUEST['level'];
			$sql="insert into aclroute(arsip,ardip,nexthop,state,level,isapp)values('$_POST[arsip]','$_POST[ardip]','$_REQUEST[nexthop]',$_POST[state],$level,1);";
			$db->query($sql);
			$db->query("update isapp set policyroute=1;");
			showmessage("添加成功", "policyroute.php");
			exit();			
			break;
		case 'mod':
			$row=$db->fetch_array($db->query("select * from aclroute where arid=$_REQUEST[arid];"));			
			$action=false;
			$add=false;
			break;
		case 'modaction':
			checkac('修改');
			$action=true;
			$add=false;
			$level=$_REQUEST['level']==''?"null":$_REQUEST['level'];
			$sql="update aclroute set arsip='$_REQUEST[arsip]',ardip='$_REQUEST[ardip]',nexthop='$_REQUEST[nexthop]'
			,state='$_REQUEST[state]',level=$level,isapp=1 where arid='$_REQUEST[arid]';";
			//echo $sql;
			$db->query($sql);
			$db->query("update isapp set policyroute=1;");
			showmessage("更新成功", "policyroute.php?rtid=$_REQUEST[rtid]");
			exit();
			break;
		case 'view':
			$view=true;
			$add=false;
			break;
	}

}
//判断是否有写到文件
$sql="select policyroute from isapp";
$query=$db->query($sql);
$row_app=$db->fetch_array($query);
$count=$row_app['policyroute'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><? echo $system['xmtactype'];?></title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script src="/js/jquery.js"  type="text/javascript"charset="utf-8" ></script>
<script src="/js/ximo_dns.js"  type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript" src="../js/jquery.validate.ext.js"></script>
<script type="text/javascript" >
function checklogin(){	
	
	if(!document.aclrouter.arsip.value == ''){
		
		if(!checkips(document.aclrouter.arsip.value))
		{
			alert("IP段格式有误");
			document.aclrouter.arsip.select();
			return false;
		}
	}

	if(!document.aclrouter.ardip.value == ''){
		
		if(!checkips(document.aclrouter.ardip.value))
		{
			alert("IP段格式有误");
			document.aclrouter.ardip.select();
			return false;
		}
	}
	
		if(document.aclrouter.nexthop.value == ''){
		alert("请输入下一跳地址");
		document.aclrouter.nexthop.select();
		return false;
	}
	else
	{
		if(!checkip(document.aclrouter.nexthop.value))
		{
			alert("IP格式有误");
			document.aclrouter.nexthop.select();
			return false;
		}
	}

		
	if(document.aclrouter.level.value == ''){
		alert("请输入优先级");
		document.aclrouter.level.select();
		return false;
	}else{
		if(!checkInt(document.aclrouter.level.value) || document.aclrouter.level.value<1 || document.aclrouter.level.value>4294967295 || document.aclrouter.level.value==32766 || document.aclrouter.level.value==32767)
		{
			alert("优先级范围是1到4294967295，除去32766，32767");
			document.aclrouter.level.select();
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
</script>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 策略路由 &gt;&gt; <?=$add?"添加":"修改"?>策略路由</div>
<ul class="tab-menu">

    <li><a href="policyroute.php">策略路由 </a></li>
	<li   class="on"><span><?=$add?"添加":"修改"?>策略路由</span></li>
	<?php if($count==1){?><li><a href="policyroute.php?action=app"> 应用</a> </li>   <?php }?> 
</ul>
<div class="content">
<form id="aclrouter" name="aclrouter" method="post" action="aclroute_add.php" onsubmit="return checklogin()" >
<input type="hidden" name="rtid" value="<?=!$add?$_REQUEST['rtid']:''?>"></input>
<input type="hidden" name="arid" value="<?=$add?'':$_REQUEST['arid']?>"></input>
<input type="hidden" name="action" value="<?=$add?'addaction':'modaction'?>" ></input>
      <table width="600" class="s s_form">
        <tr>
          <td  colspan="3" class="caption" ><?=$add?"添加":"修改"?>策略路由</td>
        </tr>
        <tr>
          <td>源IP：</td>
          <td>
            <input name="arsip" id="arsip" type="text" size="20" value="<?=!$add?$row['arsip']:''?>" />
          </td>
		  <td width="40%">如192.168.1.0/24或192.168.1.10，不填匹配全部IP</td>
        </tr>
        <tr>
          <td>目的IP：</td>
          <td>
          <input  name="ardip" type="text" id="ardip" size="20" value="<?=!$add?$row['ardip']:''?>" />
			</td>
		   <td>如192.168.2.0/24或192.168.2.10，不填匹配全部IP</td>
        </tr>
        <tr>
          <td>下一跳：</td>
          <td>
          <input  name="nexthop" type="text" id="nexthop" size="20" value="<?=!$add?$row['nexthop']:''?>" /> 
			</td>
			<td>如192.168.2.1</td>
        </tr>
        <tr>
          <td>优先级：</td>
          <td>
          <input  name="level" id="level" type="text" size="20" value="<?php 
          if(!$add)
          {
          	$level=$row['level'];
          	echo $level;
          }
          else 
          {
          	$r_minlevel=$db->fetch_array($db->query("select min(level) min from aclroute where level>0  and level<32766"));
          	$level=$r_minlevel['min'];
          	if(empty($level))
          	{
          		$level=32766;
          	}
          	$level-=10;
          	if($level<=0)
          	{
          		$level=1;
          	}
          	echo $level;
          }

          ?>" />
          </td>
		  <td>优先级范围是1到4294967295，除去32766，32767，这两个为优先级对应系统路由（静态路由，默认路由等)。数值小的优先级大</td>
        </tr>

        <tr>
          <td>是否启用：</td>
          <td ><select name="state" id="state">
              <option value="1" <?=$add?'':($row['state']==1?'selected':'')?> >开启</option>
              <option value="0" <?=$add?'':($row['state']==0?'selected':'')?> >关闭</option>
          </select></td>
		  <td></td>
        </tr>
        <tr>
          <td  class="footer" colspan="3">
            <input type="submit" name="Submit" value="保存设置" />
          </td>
        </tr>
      </table>
</form></div>
<div class="push"></div>
<?$db->close();?></div>
<? include "../copyright.php";?>
</body>
</html>