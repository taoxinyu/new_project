<?php
require('../include/comm.php');
checklogin();
checkac();
if(isset($_REQUEST['roleid']))
{
	$roleid=$_REQUEST['roleid'];
}
else
{
	exit("非法操作，没有提供roleid");
}

$getdomain=$_REQUEST['domain'];
$getpri=$_REQUEST['pri'];
$pri=array();
$domain=array();
$sql="select module_id from module;";
$rs=$db->query($sql);
while($moduleid=$db->fetch_array($rs))
{
	$prisql="select privilege_id from privilege;";
	$prirs=$db->query($prisql);
	while($prid=$db->fetch_array($prirs))
	{

		$pri[$moduleid['module_id']][$prid['privilege_id']]=0;
	}
	//$db->free_result($prirs);
}
//$db->free_result($rs);
if(isset($getpri))
{
	foreach($getpri as $moduleid=>$modulepri)
	{
			foreach($modulepri as $prid)
			{
				$pri[$moduleid][$prid]=1;
			}
	}
}

$sql="select * from domain;";
$rs=$db->query($sql);
while($domainid=$db->fetch_array($rs))
{
	$prisql="select privilege_id from privilege;";
	$prirs=$db->query($prisql);
	while($prid=$db->fetch_array($prirs))
	{
		$domain[$domainid['domainid']][$prid['privilege_id']]=0;
	}
}
if(isset($getdomain))
{
	foreach($getdomain as $moduleid=>$modulepri)
	{
			foreach($modulepri as $prid)
			{
				$domain[$moduleid][$prid]=1;
			}
	}
}
$error=0;

foreach($pri as $moduleid=>$modulepri)
{
	foreach($modulepri as $prid=>$status)
	{

		$sql="select count(*) as exist from access where role_id=$roleid and privilege_id=$prid and  (module_id=$moduleid or (module_id is null and $moduleid is null));";
		$rs=$db->query($sql);
		$row=$db->fetch_array($rs);
		if($row['exist']<>0)
		{
			$sqlPrivilege="update access set status=$status where role_id=$roleid and privilege_id=$prid and  (module_id=$moduleid or (module_id is null and $moduleid is null));";
			//echo $sqlPrivilege;
		}
		else 
		{
			$sqlPrivilege="insert into access (role_id,privilege_id,module_id,status) values($roleid,$prid,$moduleid,$status);";
		}
		
		//echo $sqlPrivilege.'<br>';
		if(!($db->query($sqlPrivilege)))
		{
			echo $sqlPrivilege.'<br>';
			$error=1;
		}
	}
}

foreach($domain as $domainid=>$modulepri)
{
	foreach($modulepri as $prid=>$status)
	{

		$sql="select count(*) as exist from do_access where role_id=$roleid and privilege_id=$prid and  (domain_id=$domainid or (domain_id is null and $domainid is null));";
		$rs=$db->query($sql);
		$row=$db->fetch_array($rs);
		if($row['exist']<>0)
		{
			$sqlPrivilege="update do_access set status=$status where role_id=$roleid and privilege_id=$prid and  (domain_id=$domainid or (domain_id is null and $domainid is null));";
			//echo $sqlPrivilege;
		}
		else 
		{
			$sqlPrivilege="insert into do_access (role_id,privilege_id,domain_id,status) values($roleid,$prid,$domainid,$status);";
		}
		
		//echo $sqlPrivilege.'<br>';
		if(!($db->query($sqlPrivilege)))
		{
			echo $sqlPrivilege.'<br>';
			$error=1;
		}
	}
}

if($error==1)
{

	writelog($db,'权限管理',"修改角色权限失败");
	?>
	更新失败 <a href="editprivilege.php?roleid=<?php echo $roleid ?>" >返回</a><br />
	<?php	
}
else 
{

	$oldrole=$db->fetch_array($db->query("select name from role where role_id=$roleid;"));
	writelog($db,'权限管理',"修改角色权限成功");	
	header("Location: editprivilege.php?roleid=$roleid");	
}

?>
