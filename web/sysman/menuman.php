<?php
require_once '../include/comm.php';
checklogin();
$orderno=0;
$posno=0;
?>
<html>
<head>
<style type="text/css" >
body{
font-size:12px;
text-align:center;
color: #333;

}
#wrapper{
  width:100%;
  margin:20px auto;
}
table
{
font-size:12px;
border:2px none white;
border-width:0px;
border-collapse:collapse;
}
tr td
{
		border:2px solid white;
		border-color:#FFF;
		border-width:2px;
}
hr
{
	border-style:solid;
	border-width:2px;
}
 tr td {  
     background:#AFF;
 }
 .child,tr[class|="child"]
 {
 	display:none;
}
 .nchild,tr[class|="nchild"]
 {
  	display:table-row;	
}

</style>
<!--[if IE]>
<style type="text/css">
.nchild,tr[class|="nchild"]
{
 	display:block;
}
</style>
<![endif]-->
<script src="../js/jquery.js" type="text/javascript"></script>
<script type="text/javascript" >

$(function() {
	$('tr.parent')
		.css("cursor","pointer")
		.attr("title","Click to expand/collapse")
		.click(function(){
			$(this).siblings('.child-'+this.id).toggle();
		});
	$('tr[@class^=child-]').hide().children('td');
});
</script>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" >
<title>Insert title here</title>
</head>

    <body>
    <div id="wrapper" >
    	<a name="<?=++$posno?>" ></a>
		<table width="100%" border=1 cellpadding="6" >
		<tr class="parent" id="row0" align="left" ><td colspan=5 >顶级菜单(↓展开/收起↑)</td></tr>
		<tr class="child child-row0 <?=@$_REQUEST['posno']==$posno?'nchild':''?>" align="center" ><td width="10%" >顺序编号</td><td width="35%" >菜单项</td><td width="40%" >URL</td><td width="10%" >排序</td><td width="5%" ></td></tr>
		<?php
		$sql="select module_id,name,url,`order` from module where pid is null order by `order`;";
		$rs=$db->query($sql);
		while($row=$db->fetch_array($rs))
		{
			if($orderno)
			{
				$orderno++;
			}
			else
			{
				if(!$row['order'])
				{
					$orderno=1;
				}
				elseif($row['order']==$orderno)
				{
					$orderno++;
				}
				else
				{
					$orderno=$row['order'];
				}
			}
			if($orderno!=$row['order'])
			{
				$ordersql="update module set `order`=$orderno where module_id=$row[module_id];";
				$db->query($ordersql);
			}
			?>

			<tr class="child child-row0 <?=@$_REQUEST['posno']==$posno?'nchild':''?>" >
			<td align="right" ><?=$orderno?>&nbsp;</td>
			<form action="actionmenu.php" method="post" >
			<input type="hidden" name="action" value="modiname" ></input>
			<input type="hidden" name="moduleid" value="<?=$row['module_id']?>" ></input>
            <input type="hidden" name="posno" value="<?=$posno?>" ></input>
			<td align="right" >
			<?=$row['name']?>
			<input type="text" name="name" ></input>
			<input type="submit" name="submit" value="修改" ></input>
			</td>
			</form>
			<form action="actionmenu.php" method="post" >
			<input type="hidden" name="action" value="modiurl" ></input>
			<input type="hidden" name="moduleid" value="<?=$row['module_id']?>" ></input>
            <input type="hidden" name="posno" value="<?=$posno?>" ></input>
			<td align="right" ><?=$row['url']?>
			<input type="text" name="url" ></input>
			<input type="submit" name="submit" value="修改" ></input>

			</td>
			</form>
			<td align="center" ><a href="actionmenu.php?action=up&orderno=<?=$orderno?>&moduleid=<?=$row['module_id']?>&posno=<?=$posno?>" >上移</a> <a href="actionmenu.php?action=down&orderno=<?=$orderno?>&moduleid=<?=$row['module_id']?>&posno=<?=$posno?>" >下移</a></td>
			<td align="center" ><a href="actionmenu.php?action=del&moduleid=<?=$row['module_id']?>&posno=<?=$posno?>" >删除</a></td></tr>
			<?php
		}
		?>
		</table>
		<form action="actionmenu.php" method="post">
		<input type="hidden" name="moduleid" value="null" ></input>
		<input type="hidden" name="action" value="add" ></input>
        <input type="hidden" name="posno" value="<?=$posno?>" ></input>        
		菜单项:<input type="text" name="name" ></input>
		URL:<input type="text" name="url" ></input>
		于<input type="radio" name="pos" value="last" checked >最后<input type="radio" name="pos" value="first" >最前<input type="radio" name="pos" value="no" >
		<select name="posno" >
		<?php
		$sql="select `order` from module where pid is null order by `order` ;";
		$rs=$db->query($sql);
		while($row=$db->fetch_array($rs))
		{
			?>
			<option value="<?=$row['order']?>" ><?=$row['order']?></option>
			<?php
		}
		$db->free_result($rs);
		?>

		</select>后
		 <input type="submit" value="添加" ></input>
		</form>
		<?php

		$msql="select * from module where pid is null order by 'order' ;";
		$mrs=$db->query($msql);
		while($mrow=$db->fetch_array($mrs))
		{
			?>
            <a name="<?=++$posno?>" ></a>
			<table width="100%" border=1  cellpadding="6" >
			<tr class="parent" id="row<?=$mrow['module_id']?>" align="left" ><td colspan=5 ><?=$mrow['name']?>(↓展开/收起↑)</td></tr>
			<tr class="child child-row<?=$mrow['module_id']?> <?=@$_REQUEST['posno']==$posno?'nchild':''?>" align="center" ><td width="10%" >顺序编号</td><td width="35%" >菜单项</td><td width="40%" >URL</td><td width="10%" >排序</td><td width="5%" ></td></tr>
			<?php
			$ssql="select module_id,name,url,`order` from module where pid =$mrow[module_id] order by `order`;";
			$srs=$db->query($ssql);
			while($srow=$db->fetch_array($srs))
			{
				if($orderno)
				{
					$orderno++;
				}
				else
				{
					if(!$srow['order'])
					{
						$orderno=1;
					}
					elseif($srow['order']==$orderno)
					{
						$orderno++;
					}
					else
					{
						$orderno=$srow['order'];
					}
				}
				if($orderno!=$srow['order'])
				{
					$ordersql="update module set `order`=$orderno where module_id=$srow[module_id];";
					$db->query($ordersql);
				}
				?>
				<tr  class="child child-row<?=$mrow['module_id']?> <?=@$_REQUEST['posno']==$posno?'nchild':''?>" >
				<td align="right" ><?=$orderno?>&nbsp;</td>
				<form action="actionmenu.php" method="post" >
				<input type="hidden" name="action" value="modiname" ></input>
				<input type="hidden" name="moduleid" value="<?=$srow['module_id']?>" ></input>
            <input type="hidden" name="posno" value="<?=$posno?>" ></input>                
				<td align="right" >
				<?=$srow['name']?>
				<input type="text" name="name" ></input>
				<input type="submit" name="submit" value="修改" ></input>
				</td>
				</form>
				<form action="actionmenu.php" method="post" >
				<input type="hidden" name="action" value="modiurl" ></input>
				<input type="hidden" name="moduleid" value="<?=$srow['module_id']?>" ></input>
            	<input type="hidden" name="posno" value="<?=$posno?>" ></input>                
				<td align="right" ><?=$srow['url']?>
				<input type="text" name="url" ></input>
				<input type="submit" name="submit" value="修改" ></input>
	
				</td>
				</form>
				<td align="center" ><a href="actionmenu.php?action=up&orderno=<?=$orderno?>&moduleid=<?=$srow['module_id']?>&posno=<?=$posno?>" >上移</a> <a href="actionmenu.php?action=down&orderno=<?=$orderno?>&moduleid=<?=$srow['module_id']?>&posno=<?=$posno?>" >下移</a></td>
				<td  align="center" ><a href="actionmenu.php?action=del&orderno=<?=$orderno?>&moduleid=<?=$srow['module_id']?>&posno=<?=$posno?>" >删除</a></td></tr>
			<?php

			}
			$db->free_result($srs);
			?>

			</table>
			<form action="actionmenu.php" method="post">
			<input type="hidden" name="moduleid" value=<?=$mrow['module_id']?> ></input>
			<input type="hidden" name="action" value="add" ></input>
            <input type="hidden" name="posno" value="<?=$posno?>" ></input>            
			菜单项:<input type="text" name="name" ></input>
			URL:<input type="text" name="url" ></input>
			于<input type="radio" name="pos" value="last" checked >最后<input type="radio" name="pos" value="first" >最前<input type="radio" name="pos" value="no" >
			<select name="posno" >
			<?php
			$asql="select `order` from module where pid =$mrow[module_id] order by `order` ;";
			$ars=$db->query($asql);
			while($arow=$db->fetch_array($ars))
			{
				?>
				<option value="<?=$arow['order']?>" ><?=$arow['order']?></option>
				<?php
			}
			?>
	
			</select>后
			 <input type="submit" value="添加" ></input>
			</form>
		<?php
		}
		$db->free_result($mrs);
		?>
	</div>
    </body>

</html>
