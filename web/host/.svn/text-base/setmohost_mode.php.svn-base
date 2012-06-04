<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
//checkaccess($pageaccess,$_SESSION['role']);
checkac('修改');
if(isset($_POST['Submit'])){
	if ($_POST['mtype'] == 'port')
		$url = $_POST['pt']." ".$_POST['tu']; //当类型是port时， url存放   ‘ 端口+空格+T或U ’ ; T:tcp , U:udp
	else if ($_POST['mtype'] == 'server')
		$url = $_POST['fw']." T";
	else 
		$url = $_POST['murl'];
		
	$sql="update mhost set mname='".$_POST['mname']."',mip='".$_POST['mip']."',mdate=".$_POST['mdate'].",mis='".$_POST['mis']."',mtype='".$_POST['mtype']."',murl='".$url."' where mid=".$_POST['mid'];
	$db->query($sql);
	writelog($db,'监控主机管理',"修改监控主机:".$_POST['mname'].$_POST['mip']);
		$db->close();
		showmessage('修改监控主机成功','setmohost.php');
}else 
{
	$sql="select * from mhost where mid=".$_GET['id'];
	$query=$db->query($sql);
	$row=$db->fetchAssoc($query);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>监控主机设置</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style>
.title{background:#e7f4ff; width:20%; text-align:right;}
</style>
<script src="/js/jquery.js"  type="text/javascript"charset="utf-8" ></script>
<script src="/js/ximo_dns.js"  type="text/javascript" charset="utf-8"></script>
<script language="javascript">

function checklogin(){

	if(document.mhost.mname.value == ''){	
		alert("请输入监控名称");
		document.mhost.mname.select();
		return false;
	}
	else
	{
		if(!checkSpace(document.mhost.mname.value))
		{
			alert("只能输入英文字母,数字和下划线");
			document.mhost.mname.select();
			return false;
		}
	}
	if(document.mhost.mtype[1].checked && document.mhost.murl.value != ''){	
		if(document.mhost.mip.value != ''){
			if(!checkip(document.mhost.mip.value) && !checkipv6(document.mhost.mip.value))
			{
				alert("输入的IP格式有误");
				document.mhost.mip.select();
				return false;
			}
		}
		if(!checkurl(document.mhost.murl.value ))
		{
			alert("输入的url格式有误");
			document.mhost.murl.select();
			return false;
		}	
	}
	if(document.mhost.mtype[1].checked && document.mhost.murl.value == ''){	
		alert("请输入URL监控方式URL地址");
		document.mhost.murl.select();
		return false;
	}
	if(!document.mhost.mtype[1].checked){
		if(document.mhost.mip.value == ''){	
			alert("请输入监控主机IP");
			document.mhost.mip.select();
			return false;
		}
		else
		{
			if(!checkip(document.mhost.mip.value) && !checkipv6(document.mhost.mip.value))
			{
				alert("输入的IP格式有误");
				document.mhost.mip.select();
				return false;
			}
		}
	}
	
	if(document.mhost.mtype[3].checked && document.mhost.pt.value == ''){	
		alert("请输入端口检测方式端口号");
		document.mhost.pt.select();
		return false;
	}
	else if(document.mhost.mtype[3].checked && !isPort(document.mhost.pt.value))
	{
			alert("请填写有效端口号");
			document.mhost.pt.select();
			return false;
	}
	
		
	return true;
}
</script>
</head>

<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; 监控主机设置:&gt;&gt; 监控主机修改</div>
<div class="content">
<form id="mhost" name="mhost" method="post" action="setmohost_mode.php" onsubmit="return checklogin();"> 
      <table width="768" class="s s_form">       
         <tr>
          <td colspan="4" class="caption">监控主机修改</td>
        </tr>
         <tr>
           <td>监控名称：</td>
           <td>
             <input name="mname" type="text" id="mname" value="<?echo $row['mname']?>" />
           </td>
           <td class="title">监控主机IP：</td>
           <td  >
             <input name="mip" type="text" id="mip" value="<?echo $row['mip']?>" />
           </td>
         </tr>
         <tr>
          <td>ping检测方式：</td>
          <td>
            <input name="mtype" type="radio" value="ping" <?if($row['mtype']=='ping'){?>checked="checked"<?}?> />
            启用PING检测方式
          </td>
          <td class="title">检测时间间隔：</td>
          <td>
            <select name="mdate" id="mdate">
              <option value="5" <?if($row['mdate']==5){?>selected<?}?> >5分钟</option>
              <option value="10" <?if($row['mdate']==10){?>selected<?}?>>10分钟</option>
              <option value="30" <?if($row['mdate']==30){?>selected<?}?>>30分钟</option>
              <option value="60" <?if($row['mdate']==60){?>selected<?}?>>60分钟</option>
            </select>
          <input type="hidden" name="mid" id="mid" value="<?echo $_GET['id']?>" /></td>
         </tr>
        <tr>
          <td>URL检测方式：</td>
          <td>
            <input type="radio" name="mtype" value="url" <?if($row['mtype']=='url'){?>checked="checked"<?}?> />
          启用URL方式:
          <input name="murl" type="text" id="murl" size="36"  value="<? if ($row['mtype'] == 'url') echo $row['murl']?>" />
          </td>
          <td class="title">是否开启：</td>
          <td align="left" bgcolor="#FFFFFF">
            <input name="mis" type="radio" value="1" <?if($row['mis']=='1'){?>checked="checked"<?}?> />
          开启
          <input name="mis" type="radio" value="0" <?if($row['mis']=='0'){?>checked="checked"<?}?> /> 
          关闭
</td>
        </tr>
        
        <tr>
          <td class="title">服务检测方式：</td>
          <td >
		  <input type="radio" name="mtype" value="server" <?if($row['mtype']=='server'){?>checked="checked"<?}?> />
          启用服务检测方式:
            <select name="fw" id="fw">
           	<?php $sp = "";if ($row['mtype'] == 'server') {$u = explode(" ", $row['murl']); $sp = $u[0]; }?>
              <option value="25" <?php if ($sp == "25") echo 'selected';?>>smtp</option>
              <option value="53" <?php if ($sp == "53") echo 'selected';?>>dns server</option>
			  <option value="80" <?php if ($sp == "80") echo 'selected';?>>http</option>
              <option value="109" <?php if ($sp == "109") echo 'selected';?>>pop2</option>
              <option value="110" <?php if ($sp == "110") echo 'selected';?>>pop3</option>
			  <option value="161" <?php if ($sp == "161") echo 'selected';?>>snmp</option>
			  
            </select>
          </td>
          <td></td>
          <td></td>
        </tr>
               <tr>
          <td>端口检测方式：</td>
          <td>
            <input type="radio" name="mtype" value="port" <? if($row['mtype']=='port'){?>checked="checked"<?}?> />
          启用端口检测方式:<?php list($pp,$pt)= explode(" ",$row['murl']);?>
          <input name="pt" type="text" id="pt" size="6" value="<?php if($row['mtype']=='port'){echo $pp;}?>" />
		  <select name="tu" id="tu">
              <option value="T" <?php if ($pt == 'T') echo "selected";?>>tcp</option>
              <option value="U" <?php if ($pt == 'U') echo "selected";?>>udp</option>
            </select>
          </td>
          <td></td>
          <td></td>
        </tr>
 
       
        <tr>
          <td colspan="4" class="footer">
            <input type="submit" name="Submit" value="保存设置" /> <input type="button" value="返回" onclick="history.go(-1)">
          </td>
        </tr>
      </table> </form>
	  </div><div class="push"></div> 
<? $db->close();?></div>
<? include "../copyright.php";?>
</body>
</html>
