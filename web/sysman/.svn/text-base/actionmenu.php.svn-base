<?php
require_once '../include/comm.php';
checklogin();
if(isset($_REQUEST['action']))
{
	$action=$_REQUEST['action'];
}
else
{
	exit("没有指明action,操作非法");
}
switch($action)
{
	case 'add':
		if(!isset($_REQUEST['name'])||$_REQUEST['name']=='')
		{
			exit('请输入模块名字');
		}
		if(!isset($_REQUEST['url']))
		{
			$_REQUEST['url']='';
			//exit('请输入URL地址');
			
		}
		if(!isset($_REQUEST['moduleid'])||$_REQUEST['moduleid']=='')
		{

			exit('缺少模块id,非法操作');
		}
		switch($_REQUEST['pos'])
		{
			case 'last':
				$addsql="insert into module(name,url,`order`,pid) select '$_REQUEST[name]','$_REQUEST[url]'
				,max(`order`)+1,$_REQUEST[moduleid] from module where coalesce(pid,0)!=coalesce($_REQUEST[moduleid],0);";
				
				break; 
			case 'first':
				$addsql="update module set `order`=`order`+1 where pid!=coalesce($_REQUEST[moduleid],0) ; insert module(name,url,`order`,pid) values('$_REQUEST[name]','$_REQUEST[url]'
				,1,$_REQUEST[moduleid]);";				
				break;
			case 'no':
				if(!isset($_REQUEST['posno'])||$_REQUEST['posno']=='')
				{
					exit('请选择插入位置');
				}
				$db->query("update module set `order`=`order`+1 where coalesce(pid,0)!=coalesce($_REQUEST[moduleid],0) and `order`>$_REQUEST[posno];");
				$addsql="insert into module(name,url,`order`,pid) values('$_REQUEST[name]','$_REQUEST[url]',$_REQUEST[posno]+1,$_REQUEST[moduleid]);";				
				break;
		}
		$db->query($addsql);
		break;
	case 'modiurl':
		if(!isset($_REQUEST['url']))
		{
			$_REQUEST['url']='';
			//exit('请输入URL地址');
		}
		if(!isset($_REQUEST['moduleid'])||$_REQUEST['moduleid']=='')
		{
			exit('缺少模块id,非法操作');
		}
		$modsql="update module set url='$_REQUEST[url]' where module_id=$_REQUEST[moduleid];";
		$db->query($modsql);				
		break;
	case 'modiname':
		if(!isset($_REQUEST['name'])||$_REQUEST['name']=='')
		{
			exit('请输入模块名字');
		}
		if(!isset($_REQUEST['moduleid'])||$_REQUEST['moduleid']=='')
		{
			exit('缺少模块id,非法操作');
		}
		$modsql="update module set name='$_REQUEST[name]' where module_id=$_REQUEST[moduleid];";		

		$db->query($modsql);
		break;
	case 'del':
		if(!isset($_REQUEST['moduleid'])||$_REQUEST['moduleid']=='')
		{
			exit('缺少模块id,非法操作');
		}
		$delsql="delete from module where module_id=$_REQUEST[moduleid];";
		$db->query($delsql);
		break;
	case 'up':
		if(!isset($_REQUEST['moduleid'])||$_REQUEST['moduleid']=='')
		{
			exit('缺少模块id,非法操作');
		}
		if(!isset($_REQUEST['orderno'])||$_REQUEST['orderno']=='')
		{
			exit('缺少序号,非法操作');
		}		
		$upsql="select module_id,`order` from module where `order`=
		(select max(`order`) from module where coalesce(pid,0)=coalesce((select pid from module where module_id=$_REQUEST[moduleid]),0) and `order`<$_REQUEST[orderno]);";
		
		$uprs=$db->query($upsql);
		if($uprow=$db->fetch_array($uprs))
		{
			$tmid=$uprow['module_id'];
			$torder=$uprow['order'];
			$upsql2="update module set `order`=$_REQUEST[orderno] where module_id=$tmid;";
			$db->query($upsql2);
			$upsql3="update module set `order`=$torder where module_id=$_REQUEST[moduleid];";
			$db->query($upsql3);
		}
		else
		{
			//echo $upsql;
			exit("出现异常");
		}
		break;
	case 'down':
		if(!isset($_REQUEST['moduleid'])||$_REQUEST['moduleid']=='')
		{
			exit('缺少模块id,非法操作');
		}
		if(!isset($_REQUEST['orderno'])||$_REQUEST['orderno']=='')
		{
			exit('缺少序号,非法操作');
		}	
		$downsql="select module_id,`order` from module where `order`=
		(select min(`order`) from module where coalesce(pid,0)=coalesce((select pid from module where module_id=$_REQUEST[moduleid]),0)  and `order`>$_REQUEST[orderno]);";
		//echo $downsql;
		$downrs=$db->query($downsql);
		if($downrow=$db->fetch_array($downrs))
		{
			$tmid=$downrow['module_id'];
			$torder=$downrow['order'];
			$downsql2="update module set `order`=$_REQUEST[orderno] where module_id=$tmid;";
			$db->query($downsql2);
			$downsql3="update module set `order`=$torder where module_id=$_REQUEST[moduleid];";
			$db->query($downsql3);
		}
		else
		{
			exit("出现异常");
		}
		break;
}
header("Location: menuman.php?posno=$_REQUEST[posno]#$_REQUEST[posno]");
?>
