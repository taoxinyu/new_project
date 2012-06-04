<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
//checkaccess($pageaccess,$_SESSION['role']);
checkac();
if(isset($_POST['Submit']))
{
    checkac('应用');
	$cmd=$rundir."setdefault.sh ".$back_install;
	exec($cmd);
	 showmessage('出厂默认值成功！','setdefault.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>恢复出厂设置</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
</head>
<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 恢复出厂设置 </div>
      <div class="content">
	  <form id="sedefault" name="sedefault" method="post" action="setdefault.php" >
	  <table width="768" class="s s_form">
        <tr>
          <td colspan="2" class="caption">恢复出厂设置</td>
        </tr>
         <tr>
           <td>注意：</td>
           <td>恢复后所有设置恢复到出厂状态，请恢复前确认！</td>
         </tr>
         <tr>
           <td>网络接口默认设置：</td>
           <td>网口0:192.168.2.207 网口1:192.168.0.207 </td>
         </tr>
         <tr>
           <td>主机默认设置：</td>
           <td>主机名：dns.ximo.com.cn 默认网关：192.168.2.1 </td>
         </tr>
         <tr>
           <td> 默认防火墙设置： </td>
           <td>所有端口开放，处于OPEN状态！</td>
         </tr>
         <tr>
           <td>默认超级管理员：</td>
           <td>用户名：xmdns 密码：xmdnsadmin</td>
         </tr>
         <tr>
           <td>日志状态：</td>
           <td >全部日志记录，远程日志关闭！</td>
         </tr>
         <tr>
           <td>DNS状态：</td>
           <td>新联通，电信，教育网，移动四条线路！</td>
         </tr>
        
        
        <tr>
          <td colspan="2" class="footer">
            <input type="submit" name="Submit" value="我要恢复出厂设置" onclick="javascript:return   confirm('请确认是否恢复出厂设置，一恢复出厂设置现数据将清空!,请再次确认？');" />
          </td>
        </tr>
      </table></form></div>
</div>
<? include "../copyright.php";?>
</body>
</html>
