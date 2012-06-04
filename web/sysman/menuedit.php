<?
include "../include/comm.php";
checklogin();
checkac();
if(isset($_POST['Submit'])){
	$f = $_POST['father'];
	$n = $_POST['menuname'];
	$u = $_POST['url'];
	$p = $_POST['permi'];
	$i = $_POST['menuid'];
	$sql="update module set [order]=".$_POST['mysort'].",pid = $f,name = '$n', url = '$u'  where module_id = $i";
	$db->query($sql);
	echo '<script>window.parent.frames.leftFrame.location.reload()</script>';
	echo "<script>self.location='managemenu.php'</script>";
	
}else {
	$query=$db->query("select * from module where module_id=".$_GET['id']);
	$row = $db->fetchAssoc($query);
	
	$father = $row['pid'];
	$name = $row['name'];
	$url = $row['url'];
	$menuid = $row['module_id'];
	$mysort=$row['order'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户修改</title>
<link href="../divstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="28" align="left" background="../images/bg_topbg.gif">&nbsp;当前位置:&gt;&gt; 菜单修改  <a href="managemenu.php">>>返回菜单管理</a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td>
      <table width="500" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#82C4E8">
       <form id="menuadd" name="menuadd" method="post" action="menuedit.php" onsubmit="return checklogin();"> 
       <tr>
          <td height="25" colspan="2" align="center" bgcolor="#D7F5F9" class="greenbg">添加菜单</td>
        </tr>
        <tr>
          <td width="130" height="25" align="right" bgcolor="#e7f4ff" class="graytext">菜单名：</td>
          <td width="300" height="25" align="left" bgcolor="#FFFFFF"><label>
            <input name="menuname" type="text" id="menuname" value="<?php echo $name;?>"/> 
           <span><input name="menuid" type="hidden" id="menuid" value="<?php echo $menuid; ?>" /></span></label>
          </td>
        </tr>
        <tr>         
        <td width="130" height="25" align="right" bgcolor="#e7f4ff" class="graytext">URL：</td>
          <td width="300" height="25" align="left" bgcolor="#FFFFFF"><label>
            <input name="url" type="text" id="url" value="<?php echo $url;?>"/> </label>
          </td>
        </tr>
         <tr>         
        <td width="130" height="25" align="right" bgcolor="#e7f4ff" class="graytext">排序：</td>
          <td width="300" height="25" align="left" bgcolor="#FFFFFF"><label>
            <input name="mysort" type="text" id="mysort" value="<?php echo $mysort;?>"/> </label>
          </td>
        </tr>
        <tr>
          <td width="130" height="25" align="right" bgcolor="#e7f4ff" class="graytext">权限：</td>
          <td height="25" align="left" bgcolor="#FFFFFF"><label>
            <select name="permi" id="permi">
              <option value="0"<?php if($permi==0){echo "selected";}?> >超级用户</option>
              <option value="1"<?php if($permi==1){echo "selected";}?> >流量控制用户</option>
              <option value="2"<?php if($permi==2){echo "selected";}?> >监控用户</option>
              <option value="3"<?php if($permi==3){echo "selected";}?> >日志用户</option>
            </select>
          </label>
          </td>
        </tr>         
        <tr>
          <td width="130" height="25" align="right" bgcolor="#e7f4ff" class="graytext">父菜单：</td>
          <td height="25" align="left" bgcolor="#FFFFFF"><label>
            <select name="father" id="father">
              <option value=-1></option>
<?php
$sql = "select * from module where  pid is null order by [order]";
$rs = $db->query($sql);
while ($row = $db->fetchAssoc($rs)){
	$id = $row['module_id'];
	$name = $row['name'];
	if ($father == $id)
		echo "<option value=$id selected>$name</option>";
	else	
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
        
    </td>
  </tr>
</table>
</body>
</html>
