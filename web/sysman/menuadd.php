<?
include "../include/comm.php";
checklogin();
checkac();
if(isset($_POST['Submit'])){
	$f = $_POST['father'];
	$n = $_POST['menuname'];
	$u = $_POST['url'];
	$p = $_POST['permission'];
	$sql = "insert into module (pid,name,url,[order]) values($f, '$n', '$u',".$_POST['mysort'].")";
	$db->query($sql);
	echo '<script>window.parent.frames.leftFrame.location.reload()</script>';
	echo "<script>self.location='managemenu.php'</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>菜单添加</title>
<link href="../divstyle.css" rel="stylesheet" type="text/css" />

<script language="javascript">

function checklogin(){
	if(document.menuadd.menuname.value == ''){
		alert("请输入菜单名");
		document.menuadd.menuname.select();
		return false;
	}
	return true;
}

</script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="28" align="left" background="../images/bg_topbg.gif">&nbsp;当前位置:&gt;&gt; 菜单添加  <a href="managemenu.php">返回菜单管理</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <table width="500" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#82C4E8">
       <form id="menuadd" name="menuadd" method="post" action="menuadd.php" onsubmit="return checklogin();"> 
       <tr>
          <td height="25" colspan="2" align="center" bgcolor="#D7F5F9" class="greenbg">添加菜单</td>
        </tr>
        <tr>
          <td width="130" height="25" align="right" bgcolor="#e7f4ff" class="graytext">菜单名：</td>
          <td width="300" height="25" align="left" bgcolor="#FFFFFF"><label>
            <input name="menuname" type="text" id="menuname" /> </label>
          </td>
        </tr>      
        <tr>    
        <td width="130" height="25" align="right" bgcolor="#e7f4ff" class="graytext">URL：</td>
          <td width="300" height="25" align="left" bgcolor="#FFFFFF"><label>
            <input name="url" type="text" id="url" /> </label>
          </td>
        </tr>
         <tr>       
        <td width="130" height="25" align="right" bgcolor="#e7f4ff" class="graytext">排序：</td>
          <td width="300" height="25" align="left" bgcolor="#FFFFFF"><label>
            <input name="mysort" type="text" id="mysort" value="1" /> </label>
          </td>
        </tr>
        <tr>
          <td width="130" height="25" align="right" bgcolor="#e7f4ff" class="graytext">权限：</td>
          <td height="25" align="left" bgcolor="#FFFFFF"><label>
            <select name="permission" id="permission">
              <option value="0">超级用户</option>
              <option value="1">流量控制用户</option>
              <option value="2">监控用户</option>
              <option value="3">日志用户</option>
            </select>
          </label>
          </td>
        </tr>         
        
        <tr>
          <td width="130" height="25" align="right" bgcolor="#e7f4ff" class="graytext">父菜单：</td>
          <td height="25" align="left" bgcolor="#FFFFFF"><label>
            <select name="father" id="father">
              <option value=-1>顶级菜</option>
<?php
$sql = "select * from module where pid is null order by [order]";
$rs = $db->query($sql);
while ($row = $db->fetchAssoc($rs)){
	$id = $row['module_id'];
	$name = $row['name'];
	echo "<option value=$id>$name</option>";
}
?>
            </select>
          </label>
          </td>
        </tr>     
        <tr>
          <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="graybg"><label>
            <input type="submit" name="Submit" value="保存设置" />
          </label></td>
        </tr>  </form>
      </table>
      
    </td>
  </tr>
</table>
</body>
</html>
