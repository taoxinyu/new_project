<?php
/*
 +-----------------------------------------------------
 * 	2010-2-4
 +-----------------------------------------------------
 *		
 +-----------------------------------------------------
 */


include '../include/comm.php';
checklogin();
checkac();
if (isset($_POST['state'])){
    checkac('应用');
	$mg = $_POST['state'];
	file_put_contents($manager, $mg);
	showmessage('设置成功', 'manager.php');
}
$mg = file_get_contents($manager);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>线路管理</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
</head>

<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; 审批功能管理</div>
 <div class="content">

      	<form method="post" action="manager.php">    
      <table width="400" class="s s_form">

      	<tr>
          <td colspan="2"class="caption">审批功能管理</td>
        </tr>
        <tr>
              <td>审批功能:</td>
              <td>
              	<select id="state" name="state">
              		<option value="1" <?php if ($mg == "1") echo "selected" ;?>>开启</option>
              		<option value="0" <?php if ($mg == "0") echo "selected" ;?>>关闭</option>
              	</select>
              </td>
        </tr>
        <tr>
        	<td class="footer" colspan="2"><input type="submit" value="确定"/> </td>
        </tr>

      </table>
         </form>       
</div></div>
<? include "../copyright.php";?>
</body>
</html>