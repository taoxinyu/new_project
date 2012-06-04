<?
include ('../include/comm.php');
checklogin();
checkac('修改');
if(isset($_POST['userrealname'])){
	$sql="update user set ";
	if($_POST['password']<>'')
	{
		$sql=$sql." password='".md5($_POST['password'])."',";
	}
	$sql=$sql." userrealname='".$_POST['userrealname']."',userdepart='".$_POST['userdepart']."',usermail='".$_POST[useremail]."',";
	$sql=$sql." role_id=$_POST[roleID],";
	$sql=$sql." userstate=".$_POST['userstate'].",usertelphone='".$_POST['usertelphone']."' where user_id=".$_POST['userid'];
	
	$db->query($sql);
	writelog($db,'用户管理',"编辑管理员");
	$db->close();
	showmessage('管理员修改成功','user.php');
}else 
{//读取信息
	//echo "select * from [ user] where user_id=".$_GET['id'];
	$query=$db->query("select * from user where user_id=".$_GET['id']);
	while($row = $db->fetch_array($query))
	{
		$username=$row['username'];
		$userrealname=$row['userrealname'];
		$usergroup=$row['permission'];
		$userstate=$row['userstate'];
		$userdepart=$row['userdepart'];
		$usertelphone=$row['usertelphone'];
		$useremail=$row['usermail'];
		$userid=$row['user_id'];
		$roleID=$row['role_id'];
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>编辑用户</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>

<script language="javascript">
function checklogin(){
	if(document.useradd.username.value == ''){	
			alert("请输入用户名");
			document.useradd.username.select();
			return false;
		}
		if(document.useradd.userrealname.value == ''){	
			alert("请输入真实姓名");
			document.useradd.userrealname.select();
			return false;
		}
		
		if(!document.useradd.password.value == ''){	
			
			if(!checkSpace(document.useradd.password.value) || document.useradd.password.value.length<3||_g("password").value.length>20)
			{
				alert("密码长度在3-20之间，且不能含有特殊字符");
				document.useradd.password.select();
				return false;
			}
		}	

		if(document.useradd.password1.value != document.useradd.password.value){	
			alert("请两次输入密码不正确");
			document.useradd.password1.select();
			return false;
		}		
		if(document.useradd.useremail.value == ''){	
			alert("请输入邮箱");
			document.useradd.useremail.select();
			return false;
		}	
		if(!isEmail(document.useradd.useremail.value )){	
			alert("请输入正确的邮箱格式");
			document.useradd.useremail.select();
			return false;
		}	
		if(document.useradd.userdepart.value == ''){	
			alert("请输入部门");
			document.useradd.userdepart.select();
			return false;
		}else{
			if(!checkname(document.useradd.userdepart.value))
			{
				alert("部门名称不能含有特殊字符！");
				document.useradd.userdepart.select();
				return false;
			}
		}	
		if(document.useradd.usertelphone.value == ''){	
			alert("请输入联系电话");
			document.useradd.usertelphone.select();
			return false;
		}	
		if(!checktelphone(document.useradd.usertelphone.value))
		{
			alert("请输入正确的联系电话");
			document.useradd.usertelphone.select();
			return false;
		}
	return true;
}
function isEmail(str){ 
res = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/; 
var re = new RegExp(res); 
return !(str.match(re) == null); 
} 
function   checktelphone(str){   
  res   =   /^(([0\+]\d{2,3}-)?(0\d{2,3})-)?(\d{7,12})(-(\d{3,}))?$/  ;  
 var re=new RegExp(res);
 return !(str.match(re)==null);
  }
</script>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 用户管理&gt;&gt; 编辑用户 </div>
<ul class="tab-menu">
    <li><a href="user.php">用户管理</a> </li>
    <li class="on"><span>编辑用户</span></li> 
</ul>
<div class="content">
<form id="useradd" name="useradd" method="post" action="useredit.php" onsubmit="return checklogin();">
     <table  width="768" class="s s_form">
        <tr>
          <td colspan="2" class="caption">编辑用户</td>
        </tr>
        <tr>
          <td>用户名：</td>
          <td>
            <input name="username" type="text" readonly=1 id="username" value="<? echo $username?>" />
            <span class="redtext">* 必填字段，可用中文或英文字母 </span></td>
        </tr>
        <tr>
          <td>姓名：</td>
          <td><input name="userrealname" type="text" id="userrealname" value="<? echo $userrealname?>" />
            <span class="redtext">* 必填字段，为管理员的真实姓名 </span></td>
        </tr>
        <tr>
          <td>密码：</td>
          <td>
            <input name="password" type="password" id="password" />
            <span class="redtext">* 如果不修改密码请为空
            <input name="userid" type="hidden" id="userid" value="<? echo $userid?>" />
</span></td>
        </tr>
        <tr>
          <td>重复密码：</td>
          <td><input name="password1" type="password" id="password1" />
            <span class="redtext">*</span></td>
        </tr>
        <tr>
          <td>邮箱：</td>
          <td>
            <input name="useremail" type="text" id="useremail" value="<? echo $useremail?>" />
            <span class="redtext">* 管理员的常用邮箱</span></td>
        </tr>
        <tr>
          <td>部门：</td>
          <td>
            <input name="userdepart" type="text" id="userdepart" value="<? echo $userdepart?>" />
            <span class="redtext">* 管理员所在的部门</span></td>
        </tr>
         <tr>
          <td>联系电话：</td>
          <td>
            <input name="usertelphone" type="text" id="usertelphone" value="<? echo $usertelphone?>" />
            <span class="redtext">* 管理员的联系电话</span></td>
        </tr>
        <tr>
          <td>角色：</td>
          <td>
            <select name="roleID" id="usergroup">
            	<?php
            	$sql="select * from role;";
            	$rs=$db->query($sql);
            	while($row=$db->fetch_array($rs))
            	{
            		?>
            		<option value=<?=$row['role_id']?> <?= $roleID==$row['role_id']?'selected':'' ?> ><?= $row['name'] ?></option>
            		<?php
            	}
            	?>
            <!--
              <option value="0" <? if($usergroup==0){echo "selected";}?>>超级用户</option>
              <option value="1" <? if($usergroup==1){echo "selected";}?>>流量控制用户</option>
              <option value="2" <? if($usergroup==2){echo "selected";}?>>监控用户</option>
  <option value="3" <? if($usergroup==3){echo "selected";}?>>日志用户</option>
              -->
              </select>
          </td>
        </tr>
        <tr>
          <td>状态：</td>
          <td>
            <input name="userstate" type="radio" value="1" <? if($userstate==1){echo "checked=\"checked\"";}?> />
          启用 
          <input type="radio" name="userstate" value="0"  <? if($userstate==0){echo "checked=\"checked\"";}?>  />
          停用
         </td>
        </tr>
        
        <tr>
          <td colspan="2" class="footer">
		  <input type="submit" name="Submit" value="保存设置" /></td>
        </tr>       
      </table>
	 </form>
	</div>
<div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
