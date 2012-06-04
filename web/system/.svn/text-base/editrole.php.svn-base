<?php
require('../include/comm.php');
checklogin();
checkac();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<title>角色管理</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<script>
var editurl="actionrole.php";
$(function(){
$(".rename").click(function(){
var obj=$(this);
var roleName=$(this).prev("input");
if($.trim(roleName.val())==""){
	alert("请输入角色名");
	return;
}else{
	var val=/^[\u4e00-\u9fa5\w]+$/;
	if(!val.test(roleName.val())){
		alert("角色名只能是汉字，数字，字母，下划线！");
		return false;
	}
}
var roleid=$(this).attr("role_id");
obj.attr("disabled",true);
$.post(editurl,{action:'rename',roleName:roleName.val(),roleID:roleid},function(data){
obj.attr("disabled",false);
data=eval("("+data+")");
if(data.success){
obj.parent().parent().find("td:first").html(roleName.val());
alert("修改成功");
roleName.val("");
}else{
alert(data.msg);
}
});
});//rename end
})
</script>
<script>
	function checklogin(){
		if(document.roles.roleName.value == ''){	
			alert("请输入角色名");
			document.roles.roleName.select();
			return false;
		}else{
			if(!checkname(document.roles.roleName.value)){
				alert("角色名只能是汉字，数字，字母，下划线！");
				document.roles.roleName.select();
				return false;
			}
		
		}

	return true;
}
</script>
</head>

<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; 角色管理</div>
<div class="content">

    <?
    if(getPri('添加'))
    {
    	?>
    	
		<form  action="actionrole.php" method="get" name="roles"  onsubmit="return checklogin();">
		<input type="hidden" name="action" value="add" ></input>
			<table width="80%" class="s s_form">
			<tr>
          <td  colspan="2"  class="caption">添加角色</td>
        </tr>
			
			<tr><td> 添加新的角色：</td>
			<td><input style="width:150px;" name="roleName" type="text" size=8 ></input> <input type="submit" value="添加" ></input></td></tr>
			</table>
		</form>
		
		<?
	}
	?>&nbsp;
	  <table class="s s_grid" width="80%" >
		<tr>
          <td  colspan="6"  class="caption">角色管理</td>
        </tr>				
				<tr>
                 <th>角色</th>
                 <th>编辑</th>
                 <th>管理</th>
                 <th>重命名</th>
                </tr>
				<?php
				$sql="select * from role order by role_id";
				$rs=$db->query($sql);
				while($row=$db->fetch_array($rs))
				{
					?>
					<tr  bgcolor="#ffffff" onMouseOver="javascript:this.bgColor='#fdffc5';" onMouseOut="javascript:this.bgColor='#ffffff';" >
					<td><?=$row['name']?></td>
					<td>
				        <?
				        if(getPri('修改'))
				        {
				        	?>    	
					<a href="editprivilege.php?roleid=<?=$row['role_id']?>" >编辑权限</a>
							<?
						}
						?>
					</td>
					<td>
				        <?
				        if(getPri('删除'))
				        {
				        	?> 	
					<a href="actionrole.php?action=del&roleID=<?=$row['role_id']?>" >删除</a>
					
							<?
						}
						?>
					</td>

					<td>
					        <?
					        if(getPri('修改'))
					        {
					        	?>  
							<input name="roleName" type="text" size=10 >
							<input type="submit" class="rename" role_id="<?=$row['role_id']?>" value="重命名" >
								<?
							}
							?>
					 	</form>
					 </td>
						  </tr>
                         
					<?php
				}
				?>
			</table></div>
<div class="push"></div>
</div>
<? include "../copyright.php";?>
</body>
</html>
