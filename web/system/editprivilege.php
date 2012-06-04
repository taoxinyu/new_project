<?php

include ('../include/comm.php');
checklogin();
checkac();
if(isset($_REQUEST['roleid']))
{
	$roleid=$_REQUEST['roleid'];
}
else
{
	$roleid=-1;
}

    $mpsql1="select * from privilege where name='access';";
    $mprs1=$db->query($mpsql1);
    if($mprow=$db->fetch_array($mprs1))
    {
    	$mpid=$mprow['privilege_id'];
    }
    else
    {
    	exit("数据库错误，缺少权限定义");

    }    	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk ">
<title>权限管理</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<style type="text/css" >
a.sel,a.sel:link,a.sel:visited,a.sel:hover
{
	color:red;
	font-weight:bold;
}
.s td.caption{text-align:left}
.s td.left{text-align:left; width:200px;}
</style>
<script src="../js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(
function()
{
	$(".togglesel").click
	(	
		function()
		{
			var checked=$(this).attr("checked");
			$(this).parents("table").find(":checkbox").each(
			function()
			{
				$(this).attr('checked',checked);
			});
			return true;
		}
	);
	$(".unchild").click(function(){
		$(this).parents("table").find(":checkbox:not(.togglesel)").click();
	});
});
</script>
<script type="text/javascript" >
	function s_all(){
		$(".allchild").click(function(){
			$(":checkbox").attr('checked',true);
		});
	}
	function c_all(){
		$(".allnochild").click(function(){
			$(":checkbox").attr('checked',false);
		});
	}
	function u_all(obj){
		$(".unchild").click(function(){
			$("#"+obj).find(":checkbox:not(.togglesel)").click();
		}); 
	}
    function change(obj)
    {
        var selValue=(obj.options[obj.selectedIndex]).value;//获得选中值
  		window.location="editprivilege.php?roleid="+selValue;
    }
</script>
</head>

<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; 权限管理</div>
<div class="content">
<div align="center">
<table align="center" cellpadding="2" cellspacing="1"  border=0  width="90%">
    		<tr>
            <td align="center">
            <select style="width:150px" name="roleid2" onChange="change(this)" >
              <?php
				$rolesql="select role_id,name from  role;";
				$rolers=$db->query($rolesql);
				$flag=false;
				while($rolerow=$db->fetch_array($rolers))
				{
					if($roleid==-1)
					{
						$roleid=$rolerow['role_id'];
					}
					?>
				              <option value="<?= $rolerow['role_id'] ?>" 
				
					<?php
					if($roleid==$rolerow['role_id'])
					{
						echo $roleid==$rolerow['role_id']?'selected':'';
						$flag=true;
					}
					
					?> >
				     <?=$rolerow['name'] ?>
              </option>
              <?php
				}
				
				//$db->free_result($rolers);
				?>
           </select>( <a class="allchild sel"  href="javascript:s_all();">全选</a>|<a class="allnochild sel" href="javascript:c_all();">全不选</a>)
           </td>
      </tr>
      </table>
</div>
&nbsp;
<?php
if(!$flag)
{
	exit('
	<script type="text/javascript" >
	document.body.innerHTML="不存在的roleid"
	</script>
	
	');
}
?>
<form action="actionprivilege.php" method="post" >
<input name="roleid" type="hidden" value=<?=$roleid?> ></input>
    <?php
    $msql1="select module_id,name,pid from module where pid is null;";
    $mrs1=$db->query($msql1);
	$i=1;
    while($mrow1=$db->fetch_array($mrs1))
    {
    	$mpsql1="select * from access where module_id=$mrow1[module_id] and role_id=$roleid and privilege_id=$mpid;";
    	$mprs1=$db->query($mpsql1);
    	$mp=0;
    	if($mprow=$db->fetch_array($mprs1))
    	{
    		$mp=$mprow['status'];
    	}

    	?>
    	  	<table class="s s_grid" width="90%">
			<tbody id="<?php echo "t".$i;?>">
    		<tr>
    		  <td colspan="6" class="caption" ><input name="pri[<?=$mrow1['module_id']?>][<?=$mpid?>]" class="togglesel" type="checkbox" value=<?=$mpid?>  <?=$mp?'checked':'' ?> >
			  
    		    <?=$mrow1['name']?>&nbsp;<a class="unchild sel" href="javascript:u_all(<?php echo "t".$i;?>);">反选</a>
			  </td>
    		</tr>
    		<tr><th></th>
    	    <?php 
    		$psql="select * from privilege where name<>'access' order by privilege_id;";
    		$prs=$db->query($psql);
    		while($prow=$db->fetch_array($prs))
    		{
    			?>

    			<th align="center"><?=$prow['name']?></th>
    			<?php
    		}
    		//$db->free_result($prs);
    		?>
			</tr>
    	<?php
    	
    	$msql2="select module_id,name,pid from module where pid =$mrow1[module_id];";
    	$mrs2=$db->query($msql2);

    	while($mrow2=$db->fetch_array($mrs2))
    	{

    	    $mpsql2="select * from access where module_id=$mrow2[module_id] and role_id=$roleid and privilege_id=$mpid;";
	    	$mprs2=$db->query($mpsql2);
	    	$mp2=0;
	    	if($mprow2=$db->fetch_array($mprs2))
	    	{
	    		$mp2=$mprow2['status'];
	    	}
    		?>
			<tr  bgcolor="#ffffff" onMouseOver="javascript:this.bgColor='#fdffc5';" onMouseOut="javascript:this.bgColor='#ffffff';">
			<td class="left"><input name="pri[<?=$mrow2['module_id']?>][<?=$mpid?>]" value="<?=$mpid?>" type="checkbox"   <?=$mp2?'checked':'' ?> ></input><?=$mrow2['name']?></td>
			<?php
			$asql="
				select r.role_id as role_id,pri.privilege_id as privilege_id,status from 
				 (select role_id from role where role_id=$roleid) as r inner join (select * from privilege where name<>'access' ) as pri
				  left join access  as a 
				  on r.role_id=a.role_id and pri.privilege_id=a.privilege_id and
				  a.module_id=$mrow2[module_id] order by a.privilege_id;";
			//echo $asql.'<br />';
			$ars=$db->query($asql);
			while ($arow=$db->fetch_array($ars))
			{

			?>
			<td align="left">
			<input name="pri[<?=$mrow2['module_id']?>][<?=$arow['privilege_id']?>]" type="checkbox" value="<?=$arow['privilege_id']?>" <?=$arow['status']?'checked':''?> >
			  </td>
			<?php
			}
			?>
			</tr>
    		<?php
    	}
    	$i++;
    	?>
		</tbody>
    	</table>
</br></br>
    	<?php
    }
	?>
	<table class="s s_grid" width="90%">
		<tbody id="<?php echo "t".$i;?>">
    		<tr>
    		  <td colspan="6" class="caption" ><input name="domain" class="togglesel" type="checkbox" value='domain'>
			  域名管理&nbsp;<a class="unchild sel" href="javascript:u_all(<?php echo "t".$i;?>);">反选</a>
			  </td>
    		</tr>
			<tr><th></th>
				<th align="center">查看</th>
    			<th align="center">修改</th>
    			<th align="center">删除</th>
    			<th align="center">添加</th>
    			<th align="center">应用</th>
    		</tr>
			<?php
			$query=$db->query("select * from domain order by domainid desc");
    		while($row = $db->fetchAssoc($query)){
				?>
				<tr bgcolor="#ffffff" onmouseout="javascript:this.bgColor='#ffffff';" onmouseover="javascript:this.bgColor='#fdffc5';">
					<td  class="left"><?=$row['domainname']?></td>
				<?php
				$sql = "select r.role_id as role_id,pri.privilege_id as privilege_id,status from 
				 (select role_id from role where role_id=$roleid) as r inner join (select * from
privilege where name<>'access' ) as pri
				  left join do_access  as a 
				  on r.role_id=a.role_id and pri.privilege_id=a.privilege_id and
				  a.domain_id=$row[domainid] order by a.privilege_id;";
				  $ars=$db->query($sql);
				  while ($arow=$db->fetch_array($ars)){
					?>

				    <td align='center'>
					<input name="domain[<?=$row['domainid']?>][<?=$arow['privilege_id']?>]" type="checkbox" value="<?=$arow['privilege_id']?>" <?=$arow['status']?'checked':''?> />
					  </td>
					<?php
					}
					?>
			</tr>
			<?php }?>
    </table>
	
        <?
        if(getPri('修改'))
        {
        	?>
			<div align="center">
          <input name="submit" type="submit" value="确定" >&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="reset" type="reset" value="默认" >
        </div>	
	
			<?
		}
		?>
</form></div>
<div class="push"></div></div>
	<? include "../copyright.php";?>
</body>

</html>
