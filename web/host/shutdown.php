<? include ('../include/comm.php');
$pageaccess=2;
checklogin();
//checkaccess($pageaccess,$_SESSION['role']);
checkac();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>关闭系统</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
.STYLE1 {font-size:12px; color:#420505; margin-left:30px; font: "宋体";}
-->
</style></head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 关闭系统 </div>
<div class="content">
<form id="reboot" name="reboot" method="post" action="shutdown.php?reboot=yes">
     <table width="768"align="center" class="s s_grid ">
        <tr>
          <td  class="caption">关闭系统</td>
        </tr>
        <tr>
          <td><label>
<?if($_GET['reboot']=='yes')
{$my="正在关闭系统，请稍候!";}  
else
{$my="是否确定关闭系统?";}    ?>   
<input type="submit" name="Submit" value="<?echo $my?>" onclick="javascript:return   confirm('请确认是否关闭系统？');" <?if($_GET['d']=='1'){echo "disabled";}?>  />
          </label>  <?php
if($_POST[Submit]!="")
{
    if($_GET['reboot']=="yes")
    {
        checkac('应用');
        writelog($db,'关闭系统','关闭系统');
        //echo "请稍候，系统正在关闭系统！";
        
        exec("$shutdown -h now");
    }
}

?></td>
          </tr>
      </table>
    </form>
   </div>
<div class="push"></div>   
<?$db->close();?></div>
<? include "../copyright.php";?>
</body>
</html>
 