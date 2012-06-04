<?
include ('../include/comm.php');
checklogin();
checkac();
if(isset($_POST['Submit'])){
	checkac('修改');
	$db->query("delete from netip where ipname='".$_POST['ipname']."'");
	$db->query("update netface set faceuse=".$_POST['netstate']." where facename='".$_POST['ipname']."'");

	$st = $_POST['netstate'];	
	for($i=0;$i<sizeof($_POST['ipv4']);$i++)
	{
		if ($_POST['ipv4'][$i] != '' ){
			$sql="insert into netip (ipname,ip,netmask,type,netstate) values('".$_POST['ipname']."','".$_POST['ipv4'][$i]."','".$_POST['netmask'][$i]."',4,$st)";
			$db->query($sql);
		}
	}
	
	for($i=0;$i<sizeof($_POST['ipv6']);$i++)
	{
		if ($_POST['ipv6'][$i] != '' ){
			$sql="insert into netip (ipname,ip,netmask,type,netstate) values('".$_POST['ipname']."','".$_POST['ipv6'][$i]."','".$_POST['netmask6'][$i]."',6,$st)";
			$db->query($sql);
		}
	}

	$db->close();
	showmessage('设置IP接口信息成功','setip.php');
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
<script language="javascript">

var t=1;
function checklogin(){
var num=0;
var  o=document.getElementsByName('ipname');
var ipv6=document.getElementsByName('ipv6[]');
var netmask6=document.getElementsByName('netmask6[]');
for(var j=0;j<ipv6.length;++j){ 
	if(ipv6[j].value!=''){
		if(!checkipv6(ipv6[j].value)){
			alert("请输入正确的IPV6 IP");
			ipv6[j].select();
			num=1;
			break;
		}
		if(netmask6[j].value!=''){
			if(!checknetmask(netmask6[j].value)){
				alert("请输入正确的IPv6前缀");
				netmask6[j].select();
				num=1;
				break;
			}
		}else{
			alert("请输入IPv6前缀");
			netmask6[j].select();
			num=1;
			break;
		}
	}
}
if(num==1){
	return false;
}
var ipv4=document.getElementsByName('ipv4[]');
var netmask=document.getElementsByName('netmask[]');
for(var i=0;i<ipv4.length;++i){ 
	//查询IPV4地址
	if(ipv4[i].value!=''){	
		t=0;
		if(!checkip(ipv4[i].value)){
			alert("请输入正确的IPV4 IP");
			ipv4[i].select();
			return false;
		}
	}
	//查询子掩码
	if(netmask[i].value!=''){	
		t=0;
		if(!checkip(netmask[i].value)){
			alert("请输入正确的子网掩码IP");
			netmask[i].select();
			return false;
		}
	}
	if(ipv4[i].value!=''&&netmask[i].value==''){
		alert("请输入"+o[i].value+"接口的子网掩码IP");
		netmask[i].select();
		return false;
	}
}   
return true;
}
function addif(ipv){
    if (ipv == 4){
    	var oTr1 = document.getElementById("if").rows[1];
		
    	var newTr1 = oTr1.cloneNode(true);
    	var tbd = document.getElementById("if").getElementsByTagName("tbody")[0];
    	tbd.insertBefore(newTr1,tbd.rows[2]);
	}
    else {
        var t = document.getElementById('if');
        row = t.rows.length - 3;
		
    	var oTr1 = document.getElementById("if").rows[row];
    	var newTr1 = oTr1.cloneNode(true);
    	var tbd = document.getElementById("if").getElementsByTagName("tbody")[0];
    	tbd.insertBefore(newTr1,tbd.rows[row]);
    }
}
function checknetmask(str){
	if(isNaN(str)){
		return false;
	}else{
		if(str>=0 && str<=128){
			return true;
		}else{
			return false;
		}
	}
}
</script>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 网络接口状态 </div>
 <div class="content">
    <form id="setip" name="setip" method="post" action="setips.php" onsubmit="return checklogin();"> 
      <table id="if" width="768" align="center" class="s s_form">
         <tr>
          <td colspan="2" class="caption">网络接口<? echo $_GET['if'];?>设置</td>
        </tr>
        
        <!-- ipv4 -->
        <?php 
        $sql = "select * from netip where ipname='".$_GET['if']."' and type=4";
        
        $res = $db->query($sql);
        $row = $db->fetchAssoc($res);
        ?>
        <tr>
           <td>IPv4:</td>
           <td> 
             IP:
             <input type="text" name="ipv4[]" id="ipv4[]" size="20" value="<? echo $row['ip'];?>" /> 
 			 子网掩码:
             <input type="text" name="netmask[]" id="netmask[]" size="20" value="<? echo $row['netmask'];?>" />
             <a href="javascript:addif('4');">添加IPv4</a>
             </td>
       </tr>
        <?php 
        while ($row = $db->fetchAssoc($res)){
        ?>
       <tr>
           <td>IPv4:</td>
           <td> 
             IP:
             <input type="text" name="ipv4[]" id="ipv4[]" size="20" value="<? echo $row['ip'];?>" /> 
 			 子网掩码:
             <input type="text" name="netmask[]" id="netmask[]" size="20" value="<? echo $row['netmask'];?>" />
             <a href="javascript:addif('4');">添加IPv4</a>
             </td>
       </tr>
       <?php 
        }
       ?>
       
        <!--  ipv6 --> 
       <?php 
        $sql = "select * from netip where ipname='".$_GET['if']."' and type=6";
        $res = $db->query($sql);
        $row = $db->fetchAssoc($res);
        ?>
        <tr>
          <td>IPv6: </td>
          <td >IP:
            <input type="text" name="ipv6[]" id="ipv6[]" size="42" value="<? echo $row['ip'];?>" />	/
			<input type="text" name="netmask6[]" id="netmask6[]" size="5" value="<? echo $row['netmask'];?>" />
            <a href="javascript:addif('6');">添加IPv6</a>
          </td>
        </tr>
        <?php 
        while ($row = $db->fetchAssoc($res)){
        ?>     
        <tr>
          <td>IPv6: </td>
          <td >IP:
            <input type="text" name="ipv6" id="ipv6" size="42" value="<? echo $row['ip'];?>" />	/
			<input type="text" name="netmask6" id="netmask6" size="5" value="<? echo $row['netmask'];?>" />
            <a href="javascript:addif('6');">添加IPv6</a>
          </td>
        </tr>
		<?php 
        }
        
        $sql = "select * from netface where facename='".$_GET['if']."'";
        $row = $db->fetchAssoc($db->query($sql));
		?>
         <tr>
          <td>状态:</td>
          <td> 
          	<select name="netstate" id="netstate">
              <option value="1" <?if($row['faceuse']=='1'){echo "selected";}?>>开启</option>
              <option value="0" <?if($row['faceuse']=='0'){echo "selected";}?>>停用</option>
            </select>
          </td>
        </tr>  
        <tr>
          <td colspan="2" class="footer">
            <input type="hidden" name="ipname" id="ipname"  value="<? echo $_GET['if'];?>"/>
          	<input type="submit" name="Submit" value="保存设置" />          </td>
        </tr>
      </table>
      </form>  
  </div>
<?$db->close();?>
<div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
