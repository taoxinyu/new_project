<?
include ('../include/comm.php');
if(isset($_POST['doit'])&&$_POST['doit']=="reg")
{
    checkac('应用');
	//上传文件处理
	if(($_FILES["file"]["type"] == "application/octet-stream"||$_FILES["file"]["type"] == "text/plain")&&$file_con=file_get_contents($_FILES['file']['tmp_name']))
	{
		    $licinfo=getlic($file_con);
		    if ($licinfo['product']!='DNS'||$licinfo['devVersion']!=$Devversion){
				showmessage('授权文件格式错误','sqreg.php');
			}elseif(!move_uploaded_file($_FILES['file']['tmp_name'],LICDIR."license.key")){
			    showmessage('上传注册文件失败！','sqreg.php');
			}else {
				showmessage('注册成功！','sqreg.php');
			}
	}else {
		showmessage('所上传文件不是注册文件,请检查！','sqreg.php');
	}
}
$licinfo=getlic();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>系统授权设置</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 系统授权</div>
      <div class="content">
<table width="80%" class="s s_form">
      <tr>
        <td colspan="2"class="caption">系统授权</td>
      </tr>
	  <tr>
      	<td>设备型号：</td>
      	<td><label class="redtext">XIMO-<? echo $licinfo['product'].$licinfo["devVersion"];?><label></td>
      </tr> 
	  <tr>
        <td>序列号：</td>
        <td><label class="redtext"><? echo $licinfo['sn'];?></label></td>
      </tr>
	  <tr>
        <td>硬件信息码：</td>
        <td><label class="redtext"><?=$licinfo['HardwareVer'];?></label></td>
      </tr>
	  <tr>
        <td>注册单位：</td>
        <td>
          <?=iconv("utf8","gbk",$licinfo['org'])?>
        </td>
      </tr>
	  <tr>
        <td>注册邮箱：</td>
        <td><label class="redtext"><? echo $licinfo['email'];?></label></td>
      </tr>
      <tr>
        <td>到期时间：</td>
        <td><label class="redtext"><?=date("Y-m-d H:i:s",$licinfo['expire']);?></label></td>
      </tr>
      <form id="sqreg" name="sqreg" enctype="multipart/form-data" method="post" action="sqreg.php"> <tr>
        <td height="25" align="right" bgcolor="#e7f4ff">授权文件上传：</td>
        <td height="25" align="left" bgcolor="#FFFFFF">
          <label>
          <input name="file" type="file" id="upreg" />
          </label>
          <span class="graybg">
          <input type="hidden" name="doit" id="doit" value="reg" />
          <input type="submit" name="Submit" value="上传注册授权"   />
          </span>
               <label></label></td>
      </tr></form>
      <tr>
        <td colspan="2" class="footer">当前授权情况：<?=$licinfo['status_text']?></td>
      </tr>
    </table></div></div>
<? include "../copyright.php";?>
</body>
</html>
