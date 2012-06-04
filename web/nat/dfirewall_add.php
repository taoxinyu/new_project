<?
include ('../include/comm.php');
checklogin();
checkac();
if(isset($_POST['fwname']))
{
	$sql="insert into firewall (fwname,fwnumber,fwaction,fwprotol,fwport,fwsip,fwwk,fwdip,fwstate,fwisapp,checkall)values('".$_POST['fwname']."',";
	$sql=$sql.$_POST['fwnumber'].",".$_POST['fwaction'].",".$_POST['fwprotol'].",'".$_POST['protol']."','".$_POST['fwsip']."','".$_POST['fwwk']."','";
	$sql=$sql.$_POST['fwdip']."',".$_POST['fwstate'].",0,1)";

	$db->query($sql);
	$db->query("update isapp set firewall=1");
	writelog($db,'网络设置','添加防火墙规则');
	showmessage("添加成功", "dfirewall.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><? echo $system['xmtactype'];?></title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<script  type="text/javascript"  src="../js/jquery.js" ></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<script language="javascript">
function checklogin(){
	if(document.rule.fwname.value == ''){	
		alert("请输入规则名称");
		document.rule.fwname.select();
		return false;
	}
	else
	{
		if(!isName(document.rule.fwname.value))
		{
			alert("规则名称只能是汉字，数字，字母，下划线！");
			document.rule.fwname.select();
			return false;
		}
	}
	
	if(document.rule.fwnumber.value == ''){	
		alert("请输入规则编号");
		document.rule.fwnumber.select();
		return false;
	}
	else
	{
		if(!checkInt(document.rule.fwnumber.value)|| document.rule.fwnumber.value<=0 ){
			alert("规则编号是大于零的数字");
			document.rule.fwnumber.select();
			return false;
		}
		
	}
	
	if(document.rule.fwsip.value == '')
	{
		alert("请输入源IP组");
		document.rule.fwsip.select();
		return false;
	}else{
		if(!isIpOrIpd(document.rule.fwsip.value))
		{
			alert("输入的IP组格式不正确！");
		    document.rule.fwsip.select();
			return false;
		}		
	}
	
	if(document.rule.fwdip.value == '')
	{
		alert("请输入目的IP组");
		document.rule.fwdip.select();
		return false;
	}else{
		if(!isIpOrIpd(document.rule.fwdip.value))
		{
			alert("输入的IP组格式不正确！");
		    document.rule.fwdip.select();
			return false;
		}		
	}

	if(document.rule.fwprotol.value == "0" || document.rule.fwprotol.value == "-1")
	{
		if(document.rule.protol.value == ""){
			alert("请输入端口号");
			document.rule.protol.select();
			return false;
		}else{
			var ports = document.rule.protol.value.split(",");
			for(var i = 0; i < ports.length; i++) {
				if(!isPort(ports[i])){
					alert("输入的端口号格式不正确");
					document.rule.protol.select();
					return false;
				}
			}
		}
	}
	return true;
}
function change()
{
	if(document.rule.fwprotol.value == "0" || document.rule.fwprotol.value == "-1")
	{
		$("#protol").show();
	}else{
		$("#protol").hide();
	}
}
 
</script>
</head>

<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; 端口防火墙&gt;&gt; 添加防火墙规则</div>
<ul class="tab-menu">
    <li><a href="dfirewall.php">防火墙规则</a></li>
    <li class="on"><span>添加防火墙规则</span></li>	  
</ul>
<div class="content">
<form id="rule" name="rule" method="post" action="dfirewall_add.php" onsubmit="return checklogin();">
      <table width="500" class="s s_form">
        <tr>
          <td colspan="2" class="caption">添加防火墙规则</td>
        </tr>
        <tr>
          <td>规则名称：</td>
          <td>
            <input name="fwname" type="text" id="fwname" size="20" />
          </td>
        </tr>
        
        <tr>
          <td>规则序号：</td>
          <td><input name="fwnumber" type="text" id="fwnumber" size="20" />&nbsp;--请输入大于零的数字</td>
        </tr>
        <tr>
          <td>动作：</td>
          <td><select name="fwaction" id="fwaction">
            <option value="1">允许</option>
            <option value="0">拒绝</option>
                      </select>          </td>
        </tr>
		<tr>
          <td height="22" align="right" bgcolor="#e7f4ff">网口：</td>
          <td align="left" bgcolor="#FFFFFF">
			<select name="fwwk" id="fwwk">
				<option value='所有'>所有</option>
				<?
				$query=$db->query("select * from netface");		
				while($row1 = $db->fetch_array($query))
				{
				echo"<option value='".$row1['facename']."'>".$row1['facename']."</option>";
				}
				?>
            </select>
		  </td>
        </tr>
        <tr>
          <td>协议服务：</td>
          <td><select name="fwprotol" id="select" onchange="change()">
          <? $query=$db->query("select * from portlist where plfather=0 order by plsort asc");

           while($row=$db->fetch_array($query)){?>
			 <optgroup label="<? echo $row['plname'];?>"></optgroup>
			<? 
				$q=$db->query("select * from portlist where plfather=".$row['plid']." order by plsort asc");
				while($r=$db->fetch_array($q)){?>
					<option value="<?echo $r['plid']?>" >&nbsp;&nbsp;<?echo $r['plname']. "  (".$r['plproto']." ".$r['plport'].")";?></option>
				<? }?>
			
			<?}?>
			<option value="0" >其他(TCP)</option>
			<option value="-1" >其他(UDP)</option>
          </select>
			<input style="display:none" name="protol" type="text" id="protol" size="15" />端口
		  </td>
        </tr>
        <tr>
          <td>源IP组：</td>
          <td><input name="fwsip" type="text" id="fwsip" size="15" />
          如:192.168.0.32/32 所有的为0.0.0.0/0</td>
        </tr>
        <tr>
          <td>目的IP组：</td>
          <td><input name="fwdip" type="text" id="fwdip" size="15" />
            如:192.168.0.32/32 所有的为0.0.0.0/0</td>
        </tr>
        <tr>
          <td>规则状态：</td>
          <td><select name="fwstate" id="fwstate">
             <option value="1">开启</option>
			  <option value="0">关闭</option>
              
          </select></td>
        </tr>
        <tr>
          <td colspan="2" class="footer">
			<input type="submit" value="保存设置" />
          </td>
        </tr>
      </table>
        </form>
</div>
</div>

<? include "../copyright.php";?>
</body>
</html>
