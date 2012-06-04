<?
include ('../include/comm.php');
checklogin();
checkac('添加');
if(isset($_POST['username'])){
    
	//先判断是否存在
	$query=$db->query("select * from user where username='".$_POST['username']."'");
	$num=$db->num_rows($query);
	if($num>=1)
	{
		$db->free_result($query);
		writelog($db,'用户管理',"用户名".$_POST['username']."已存在,添加管理员失败。");
		$db->close();
		showmessage('用户名已存在','2');
	}else {
		$sql="insert into user (username,password,userrealname,userdepart,usermail,userstate,usertelphone,userupdate,role_id) values('".$_POST['username']."','".md5($_POST['password'])."','".$_POST['userrealname']."','".$_POST['userdepart']."','".$_POST['useremail']."',".$_POST['userstate'].",'".$_POST['usertelphone']."',CURRENT_TIMESTAMP,$_REQUEST[roleID]);";
		//echo $sql;
		$db->query($sql);

		writelog($db,'用户管理',"添加".$_POST['username']."管理员");
		showmessage('管理员添加成功','user.php');
		
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>添加用户</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>

<script language="javascript">
//self.parent.frames['navFrame'].location='../nav.php?pos= 系统管理 -> 用户添加';
$(document).ready(function(){
	$("#userrealname").val("");
	$("#password").val("");
});
function checklogin(){
	

	if(document.useradd.username.value == ''){	
			alert("请输入用户名");
			document.useradd.username.select();
			return false;
		}else{
			var exp=/^[\u4E00-\u9FA5A-Za-z]+$/ ;
			var reg = document.useradd.username.value.match(exp);
				if(reg==null){
				alert('用户名必须是字母或汉字！');
				document.useradd.username.select();
				return false;
			}
		
		
		}
		if(document.useradd.userrealname.value == ''){	
			alert("请输入真实姓名");
			document.useradd.userrealname.select();
			return false;
		}else{
			var exp=/^[\u4E00-\u9FA5A-Za-z]+$/ ;
			var reg = document.useradd.userrealname.value.match(exp);
				if(reg==null){
				alert('姓名必须是字母或汉字！');
				document.useradd.userrealname.select();
				return false;
			}
		}
	if(document.useradd.password.value == ''){	
			alert("请输入密码");
			document.useradd.password.select();
			return false;
		}else{
			if(!checkSpace(document.useradd.password.value) || document.useradd.password.value.length<3||_g("password").value.length>20 )
			{
				alert("密码长度在3-20之间，且不能含有特殊字符");
				document.useradd.password.select();
				return false;
			}
		}	
		if(document.useradd.password1.value == ''){	
			alert("请输入重复密码");
			document.useradd.password1.select();
			return false;
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
<div class="nav">&nbsp;当前位置:&gt;&gt; 用户管理&gt;&gt; 添加用户 </div>
<ul class="tab-menu">
    <li><a href="user.php">用户管理</a> </li>
    <li  class="on"><span>添加用户</span></li> 
</ul>
<div class="content">
<form id="useradd" name="useradd" method="post" action="useradd.php" onsubmit="return checklogin();" >
      <table width="768" class="s s_form">       
        <tr>
          <td colspan="2"class="caption">添加用户 </td>
        </tr>
        <tr>
          <td>用户名：</td>
          <td>
            <input name="username" type="text" id="username" />
            <span class="redtext">* 必填字段，可用中文或英文字母 </span></td>
        </tr>
        <tr>
          <td>姓名：</td>
          <td><input name="userrealname" type="text" id="userrealname" />
            <span class="redtext">* 必填字段，为管理员的真实姓名 </span></td>
        </tr>
        <tr>
          <td>密码：</td>
          <td>
            <input name="password" type="password" id="password"/>
            <span class="redtext">* 必填字段，为管理员的登陆密码 </span></td>
        </tr>
        <tr>
          <td>重复密码：</td>
          <td><input name="password1" type="password" id="password1" />
            <span class="redtext">*</span></td>
        </tr>
        <tr>
          <td>邮箱：</td>
          <td>
            <input name="useremail" type="text" id="useremail" />
            <span class="redtext">* 管理员的常用邮箱</span></td>
        </tr>
        <tr>
          <td>部门：</td>
          <td>
            <input name="userdepart" type="text" id="userdepart" />
            <span class="redtext">* 管理员所在的部门</span></td>
        </tr>
         <tr>
          <td>联系电话：</td>
          <td>
            <input name="usertelphone" type="text" id="usertelphone" />
            <span class="redtext">* 管理员的联系电话</span></td>
        </tr>
        <tr>
          <td>角色：</td>
          <td>
            <select name="roleID" id="usergroup">
            	<?php
            	$sql="select * from role ;";
            	$rs=$db->query($sql);
            	while($row=$db->fetch_array($rs))
            	{
            		?>
            		<option value="<?=$row['role_id']?>" ><?= $row['name'] ?></option>
            		<?php
            	}
            	?>
            <!--
              <option value="0">超级用户</option>
              <option value="1">流量控制用户</option>
              <option value="2">监控用户</option>
              <option value="3">日志用户</option>
            -->
            </select>
          </td>
        </tr>
        <tr>
          <td>状态：</td>
          <td>
            <input name="userstate" type="radio" value="1" checked="checked" />
          启用 
          <input type="radio" name="userstate" value="0" />
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
