<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();
if(isset($_POST['Submit'])){
	$mycmd=$mycmd."$setdate ".$_POST['mydate']."\n";
	//写入once文件
	writeShell($onerunfile,$mycmd);
	exec("$setdate -s \"".$_POST['mydate']."\"");
	exec("$cleandate");
	writelog($db,'设置主机时间',"设置主机时间");
	$db->close();
	showmessage('设置主机时间成功','sethost.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>日期设置</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<script language="javascript">

function checklogin(){
	if(document.setdate.mydate.value == ''){	
			alert("请输入日期时间");
			document.setdate.mydate.select();
			return false;
	}else if(!checkdate(document.setdate.mydate.value)){
			alert("请输入正确的时间格式");
			document.setdate.mydate.select();
			return false;
        }
	
	return true;
}


</script>
</head>

<body>
<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 主机时间设置 </div>
<div class="content">
<form id="setdate" name="setdate" method="post" action="setdate.php" onsubmit="return checklogin();">
      <table width="768" class="s s_form">
        <tr>
          <td colspan="2" class="caption">主机时间设置</td>
        </tr>
         <tr>
          <td>当前系统时间：</td>
          <td><label class="greentext">
          <?=date("Y年n月j日 H:i:s")?>	&nbsp;&nbsp;&nbsp;</label></td>
        </tr>
         <tr>
           <td>时间设置：            </td>
           <td>
             <input name="mydate" type="text" id="mydate" />
            </td>
         </tr>
         <tr>
           <td>&nbsp;</td>
           <td>时间格式如：2009-06-13 14:23:00(设置生效为一分钟内设置生效)! </td>
         </tr>        
        <tr>
          <td colspan="2" class="footer">
            <input type="submit" name="Submit" value="保存设置" />
          </td>
        </tr>
      </table>
	  </form></div>
<? $db->close();?>
<div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
