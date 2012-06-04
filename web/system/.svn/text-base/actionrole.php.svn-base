<?php
require('../include/comm.php');
checklogin();
checkac();
switch($_REQUEST['action'])
{
	case 'add':
	    checkac('添加');
		if(trim($_REQUEST[roleName])<>'')
		{
			$sql0="select * from role where name='$_REQUEST[roleName]'";
			$query=$db->query($sql0);
			$num=$db->num_rows($query);
			if($num>=1){
				echo "<script language='javascript'>";
				echo "alert('该角色名已存在，请更换其他的名字');";
				echo "history.back(-1);";
				echo "</script>";
			}else{
				$sql= "insert into role (name) values('$_REQUEST[roleName]');";
				if($rs=$db->query($sql))
				{
					writelog($db,'角色管理',"添加角色".$_REQUEST['roleName']."成功");
					header("Location: editrole.php");
				}
				else 
				{
					writelog($db,'角色管理',"添加角色".$_REQUEST['roleName']."失败");
					showmessage('添加失败','editrole.php');
				}
			}
		}
		else 
		{
			showmessage('请输入角色名','editrole.php');
		}
		break;
	case 'del':
	    checkac('删除');
			if($_REQUEST[roleID]==1){ 
				showmessage('不能删除"系统管理员"角色','editrole.php');
			}
			$sql="select count(*) as exist from user where role_id=$_REQUEST[roleID];";
			$rs=$db->query($sql);
			$row=$db->fetch_array($rs);
			if($row['exist']==0)
			{
				$oldrole=$db->fetch_array($db->query("select name from role where role_id=$_REQUEST[roleID];"));
				$sql1="delete from role where role_id=$_REQUEST[roleID]";
				$sql2="delete from access where role_id=$_REQUEST[roleID]";
				if($db->query($sql2) && $db->query($sql1))
				{
					writelog($db,'角色管理',"删除角色".$oldrole['name']."成功");
					header("Location: editrole.php");
				}
				else
				{
					writelog($db,'角色管理',"删除角色".$oldrole['name']."失败");
					showmessage('删除失败','editrole.php');
				}
			}
			else 
			{
					writelog($db,'角色管理',"删除角色".$oldrole['name']."失败");
					showmessage('你不能删除此角色，请先删除此角色下的所有用户','editrole.php');
			}
		break;
	case 'rename':
	    checkac('修改');
		if(trim($_REQUEST[roleName])=='')
		{
		    die("{msg:'请输入角色名'}");
		}
		$sql0="select * from role where name='".iconv("utf-8","gbk",$_REQUEST[roleName])."'";
		$query=$db->query($sql0);
		$num=$db->num_rows($query);
		if($num>=1){
			die("{msg:'该角色名已存在'}");
		}else{
		   $sql="update role set name='".iconv("utf-8","gbk",$_REQUEST[roleName])."' where role_id=$_REQUEST[roleID];";
		   if($rs=$db->query($sql))
		   {
			  writelog($db,'角色管理',"修改角色成功");
			  die("{success:true}");
		    }
		    else
		    {
			   writelog($db,'角色管理',"修改角色失败");
			   die("{msg:'重命名失败'}");
		    }
		}
		break;
		
}
?>
