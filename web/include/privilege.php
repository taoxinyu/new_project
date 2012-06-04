<?php
/*********************************************
*
* 程序名： 权限管理模块
* 作 者： 何涛
* Email： haohetao@gmail.com
* 版本： v1.0
*
*********************************************/

/********************************************
 * 功能：根据权限名，用户名，模块名返回权限
 * 参数：
 * $pri		权限名字
 * $user	用户名
 * $mod		模块名
 * 说明：
 * 如果参数个数不对，参数中包含null,''等空值,权限未授权返回false
 * 其它情况返回true
 * 例子：getPriByUser('access','admin','系统设置')
 * getPriByUser('修改','admin','开关机设置')
 *******************************************/

function getPriByUser($pri,$user,$mod)
{
	if(!$pri or !$user or !$mod)
	{
		return false;
	}
	global $db;
	$sql="select access.status as status from access
	 where role_id=(select role_id from user where username='$user')
	  and privilege_id=(select privilege_id from  privilege where name='$pri')
	  and module_id=(select module_id from module where name='$mod');";
	$rs=$db->query($sql);
	//echo $sql;
	if($row=$db->fetch_array($rs))
	{
		if($row['status']==1)
		{
			return true;
		}
	}
	return false;
}

/********************************************
 * 功能：根据权限名，用户名，模块名返回权限
 * 参数：
 * $pri		权限名字
 * $user	角色名
 * $mod		模块名
 * 说明：
 * 如果参数个数不对，参数中包含null,''等空值,权限未授权返回false
 * 其它情况返回true
 * 例子：getPri('查看');
 *******************************************/
function getPriByRole($pri,$role,$mod)
{
	if(!$pri or !$role or !$mod)
	{
		return false;
	}
	global $db;
	$sql="select access.status as status from access
	 where role_id=(select role_id from role where name='$role')
	  and privilege_id=(select privilege_id from privilege where name='$pri')
	  and module_id=(select module_id from module where name='$mod');";
	//echo $sql;
	$rs=$db->query($sql);
	if($row=$db->fetch_array($rs))
	{
		if($row['status']==1)
		{
			return true;
		}
	}
	return false;	
}


/********************************************
 * 功能：根据权限名返回权限
 * 参数：
 * $pri		权限名字
 * 说明：
 * 如果参数个数不对，参数中包含null,''等空值,权限未授权返回false
 * 其它情况返回true
 * 用户名从session中读取，不必在参数中给出，模块名从网页上下文读取
 * 当打开一个模块时同时把模块id传给页面，这样getPri()就能获得当前
 * 模块信息了
 * 具体可参考函数源代码
 *******************************************/
function getPri($pri)
{
	if(!isset($_SESSION['moduleid']))
	{
		//echo '没有提供所属模块信息,无权访问';
		//return false;
		return true;			
	}
	if(!isset($_SESSION['loginanme']))
	{
		//echo '没有提供用户信息,无权访问';
		return false;
		//exit();			
	}
	$user=$_SESSION['loginanme'];
	$modid=$_SESSION['moduleid'];
	if(!$pri or !$user or !$modid)
	{
		return false;
	}
	global $db;
	$sql="select access.status as status
	 from access
	 where role_id=(select role_id 
	 from user where username='$user')
	  and privilege_id=(select privilege_id
	   from privilege where name='$pri')
	  and module_id=$modid;";
	$rs=$db->query($sql);

	if($row=$db->fetch_array($rs))
	{
		if($row['status']==1)
		{
			return true;
		}
	}
	return false;
}
//检查模块权限
function checkac($pri=NULL)
{
	if($pri==null)
	{
		$pri='access';	
	}
	if($pri=='access')
	{
		if(isset($_REQUEST['moduleid']))
		{
			$_SESSION['moduleid']=$_REQUEST['moduleid'];
		}		
	}
	if(!getPri($pri))
	{
		echo <<<EOT
			<script type="text/javascript" >
				self.location.href='../../../../noaccess.php';
			</script>
EOT;
		exit;
		//header("Content-Type: text/html; charset=GB2312");
		//exit('权限不足');
	}
	return true;
}
function checkac_do($pri)
{
	global $db;
	$sql = "select status from do_access where role_id=$_SESSION[role] and domain_id=$_REQUEST[domainid] and privilege_id=$pri";
	$rs=$db->query($sql);
	$row=$db->fetchAssoc($rs);
	//echo $sql;die();
	if($row['status']==0)
	{
		echo <<<EOT
			<script type="text/javascript" >
				self.location.href='../../../../noaccess.php';
			</script>
EOT;
		exit;
	}
	return true;
}