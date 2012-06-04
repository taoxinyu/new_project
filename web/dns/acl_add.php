<?
include ('../include/comm.php');
include ('../mail/sendmail.php');
$pageaccess=1;
checklogin();
checkac();

$rowmail=$db->fetchAssoc($db->query("select * from setmail"));
if(isset($_POST['Submit'])){
	checkac('添加');
	$sql="select * from setacl where aclident='".$_POST['aclident']."'";
	$query=$db->query($sql);
	$num=$db->num_rows($query);
	if($num>0){
		$db->close();
		showmessage('线路标识已存在，请重新添加!','acl_add.php');
	}
	$sql="insert into setacl (aclname,aclident,aclis,acldg,aclcs,aclsafe,aclabout,aclisapp,aclfor,aclforip,aclkey,aclpri)values('".$_POST['aclname']."','";
	$sql=$sql.$_POST['aclident']."','".$_POST['aclis']."','".$_POST['acldg']."','".$_POST['aclcs']."','".$_POST['aclsafe']."','".$_POST['aclabout']."','0',".$_POST['aclfor'].",'".$_POST['aclforip']."','".$_POST['aclkey']."','".$_POST['aclpri']."')";
	$db->query($sql);
	//创建ACL文件
	$rc="acl \"".$_POST['aclident']."\" {\n";
	$rc=$rc."};\n";
	writeFile($binddir."acl/".$_POST['aclident'],$rc);
	writeFile($binddir."zone/".$_POST['aclident']."_zone.conf","");
	$sql="update domain set domainisapp='0'";
	$db->query($sql);
	
	writelog($db,'线路管理',"添加线路".$_POST['aclname']);
	if($rowmail['checkLine']==1)
	{
		$subject='线路监控提醒';
		$body='特发此邮件通知:您在线路管理中进行了线路添加，添加的线路标识为：'.$_POST['aclname'];
		$sendName=split('@',$rowmail['recMail']);
		sendMail($rowmail['recSmtp'],$sendName[0],$rowmail['recPWD'],$rowmail['recMail'],$subject,$body,$rowmail['sendMail']);	  		
	}
	$db->close();
	showmessage('线路添加成功','acl.php');
	
}

$key =`openssl rand -base64 16`;


$selpri=0;
$arrpri=array();
$sqlpri="select aclpri from setacl";
$querypri=$db->query($sqlpri);
while($rowpri=$db->fetchAssoc($querypri)) {
	$selpri++;
	if ($rowpri['aclpri']!=0) {
		array_push($arrpri,$rowpri['aclpri']);
	}
}
//echo $selpri;
//var_dump($arrpri);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>线路设置</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<script language="javascript">
function checklogin(){
		if(document.setacl.aclname.value == ''){	
			alert("请输入线路名称");
			document.setacl.aclname.select();
			return false;
		}else{
			if(!checkname(document.setacl.aclname.value)){
				alert("线路名称只能是汉字，数字，字母，下划线！");
				document.setacl.aclname.select();
				return false;
			}
		
		}
		if(document.setacl.aclident.value == ''){	
			alert("请输入线路标识");
			document.setacl.aclident.select();
			return false;
		}else{
			if(!checkSpace(document.setacl.aclident.value)){
				alert("线路标识只能是数字，字母，下划线！");
				document.setacl.aclident.select();
				return false;
			}
		
		}
			var ips=document.setacl.aclforip.value;
			var chs = new Array;
			chs = ips.split(";");			
		if(ips!=""){
			for(var i=0;i<chs.length;i++){
			if(!isIp(chs[i]))
			{
				alert("输入的IP格式不正确！");
				document.setacl.aclforip.select();
				return false;
			}
			}
		}
		
		if(document.setacl.aclabout.value != ''){	
		
			if(!isName(document.setacl.aclabout.value)){
				alert("线路描述只能是汉字，数字，字母，下划线！");
				document.setacl.aclabout.select();
				return false;
			}
		
		}


	return true;
}
</script>
</head>

<body>
<div class="wrap">

<ul class="tab-menu">
    <li><a href="acl.php">线路管理</a></li>
    <li  class="on"><span>线路添加</span></li>

</ul> 

<div class="content">
<form id="setacl" name="setacl" method="post" action="acl_add.php" onsubmit="return checklogin();">
<table width=98% class="s s_form">       
         <tr>
          <td colspan="2"class="caption"><image src="/img/grid.gif"> 线路设置</td>
        </tr>
      
            <tr>
              <td>线路名称：</td>
              <td>
                <input name="aclname" type="text" id="aclname" />
              </td>
              </tr>
        
            <tr>
              <td>线路标识：</td>
              <td>
                <input name="aclident" type="text" id="aclident" size="10" />
              </td>
              </tr>
              <tr>
              <td>优先级：</td>
              <td>
              <select name="aclpri" id="aclpri">
              <?php
              for ($i=0;$i<=$selpri;$i++)
              {
              	$boolpri=true;
              	foreach ($arrpri as $value)
              	{
              		if ($i==$value) {
              			$boolpri=false;
              		}
              	}
              	if($boolpri) {
              	?>
          <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
              	<?php
              	}
              }
              ?>
              </select>
              </td>
              </tr>
            <tr>
              <td>启用状态：</td>
              <td>
                <input name="aclis" type="radio" value="1" checked="checked" />
                启用
                <input type="radio" name="aclis" value="0" />
停用 </td>
            </tr>
            <tr>
              <td>递归情况：</td>
              <td><input name="acldg" type="radio" value="1" checked="checked" />
启用
  <input type="radio" name="acldg" value="0" />
停用 </td>
            </tr>
            <tr>
              <td>可传输情况：</td>
              <td><input name="aclcs" type="radio" value="1" checked="checked" />
启用
  <input type="radio" name="aclcs" value="0" />
停用 </td>
            </tr>
            <tr>
              <td> 限制设置： </td>
              <td><input name="aclsafe" type="radio" value="1" checked="checked" />
启用
  <input type="radio" name="aclsafe" value="0" />
停用 </td>
            </tr>
<tr>
              <td> 转发情况： </td>
              <td>
              	<input name="aclfor" type="radio" value="1" id="aclfor1"/>
				启用
  				<input name="aclfor" type="radio" value="0" checked="checked" id="aclfor2"/>
				停用 
			  </td>
            </tr>
            
            <tr>
              <td> 转发到DNS： </td>
              <td>
              	<input name="aclforip" type="text"  />如：192.168.0.1
			  </td>
            </tr>
            <tr>
              <td> 同步密钥： </td>
              <td>
              	<input name="aclkey" type="text" size="30" value="<?php echo $key;?>"  />
			  </td>
            </tr>
                        
            <tr>
              <td>描述：</td>
              <td>
                <input name="aclabout" type="text" id="aclabout" size="60" />
              </td>
            </tr>
            <tr>
          <td colspan="2"class="footer">
          <input type="submit" name="Submit" value="保存设置" />
</td>
        </tr>
          </table></form></div>           
      

 <?$db->close();?>
 <div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
