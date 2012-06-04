<?
include ('../include/comm.php');
checklogin();
checkac();

if(isset($_GET['action'])&&$_GET['action']=='del'){
	checkac('删除');
	$query=$db->query("select * from  user");
	$num=$db->num_rows($query);
	if($num<=1)
	{
		showmessage('不能删除最后一个管理员','user.php');
	}else {
	$query=$db->query("delete from  user where user_id=".$_GET['id']);
	//oplog('删除管理员','删除'.$_GET['username'].'管理员');
	}
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>用户管理</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
</head>
<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 用户管理  </div>
<ul class="tab-menu">
    <li class="on"><span>用户管理</span> </li>
    <li><a href="useradd.php">添加用户</a></li> 
</ul>

      <div class="content"><table width="813" class="s s_grid">
        <tr >
          <td colspan="8" class="caption">用户管理</td>
        </tr>
        <tr>
          <th>用户名</th>
          <th>
            姓名
          </th>
          <th>用户角色</th>
          <th>邮箱</th>
          <th>添加时间</th>
          <th>状态</th>
          <th>部门</th>
          <th>管理</th>
        </tr>
        <?
		$query=$db->query("select * from user ");
		while($row = $db->fetch_array($query))
		{
			$rolesql="select name from role where role_id=(select role_id from user where user_id=$row[user_id]);";
			$rolers=$db->query($rolesql);
			$roleName=$db->fetch_array($rolers);
		?>
        <tr bgcolor="#ffffff" onMouseOver="javascript:this.bgColor='#fdffc5';" onMouseOut="javascript:this.bgColor='#ffffff';">
          <td><? echo $row['username'];?></td>
          <td><label><? echo $row['userrealname'];?></label></td>
          <td><?=$roleName['name'] ?></td>
          <td><? echo $row['usermail'];?></td>
          <td><? echo $row['userupdate'];?></td>
          <td><? echo mystate($row['userstate']);?></td>
          <td><? echo $row['userdepart'];?></td>
          <td>
        <?
        if(getPri('修改'))
        {
        	?>    
          <a href="useredit.php?id=<? echo $row['user_id'];?>">编辑</a> 

			<?
		}
		?>

        <?
        if(getPri('删除'))
        {
        	?>    
          <a href="user.php?id=<? echo $row['user_id'];?>&username=<?echo $row['username'];?>&action=del" onclick="javascript:return   confirm('真的要删除吗？');">删除</a>
          
			<?
		}
		?>
          </td>
        </tr>
		<?
		}
		//$db->free_result($query);
		$db->close();
		?>
      </table></div>
<div class="push"></div>
</div>
<? include "../copyright.php";?>
</body>
</html>
