<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();
if(isset($_POST['Submit'])){
    checkac('添加');
	$sql="select * from mhostacl where maclhostid=".$_POST['maclhostid'];
	$query=$db->query($sql);
	$num=$db->num_rows($query);
	if($num>0)
	{
		$db->close();
		showmessage('本主机监控策略已经存在,不能添加！','setmoacl.php');
	}
$sql="insert into mhostacl (maclhostid,maclis,maclns,maclnd,maclzh)values(".$_POST['maclhostid'].",'".$_POST['maclis']."',";
$sql=$sql."'".$_POST['maclns']."','".$_POST['maclnd']."',0)";
	$db->query($sql);
	
	writelog($db,'主机监控策略管理',"添加主机监控策略");
		$db->close();
		showmessage('设置主机监控策略成功','setmoacl.php');
		

}
if(isset($_GET['ac']))
{
	if($_GET['ac']=='del')
	{
	    checkac('删除');
		//删除
		$db->query("delete from mhostacl where maclid=".$_GET['id']);
		writelog($db,'监控主机管理',"删除监控策略");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>主机监控策略设置</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style>
.title{background:#e7f4ff; width:20%; text-align:right;}
</style>
<script src="/js/jquery.js"></script>
<script src="/js/ximo_dns.js"></script>

<script language="javascript">

function checklogin(){
	

	if(document.macl.maclhostid.value == ''){	
			alert("请选择监控主机");
			
			return false;
		}
	if(document.macl.maclns.value ==document.macl.maclnd.value){	
			alert("不通状态线路转换不能相同");
			
			return false;
		}
	
	return true;
}

</script>
</head>

<body><div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 监控策略设置</div>
<div class="content">
       <form id="macl" name="macl" method="post" action="setmoacl.php" onsubmit="return checklogin();"> 
      <table width="776" class="s s_form">
         <tr>
          <td colspan="4" class="caption">监控策略设置</td>
        </tr>
         <tr>
           <td>监控主机：</td>
           <td   align="left" ><label>
             <select name="maclhostid" id="maclhostid">
             <?$query=$db->query("select * from mhost");
             while($row=$db->fetchAssoc($query)){?>
             <option value="<?echo $row['mid']?>"><?echo $row['mname']."(".$row['mip'].")"?></option>
             <?}?>
             </select>
           </label></td>
           <td  class="title">是否开启：</td>
           <td >
             <select name="maclis" id="maclis">
               <option value="1">开启</option>
               <option value="0">关闭</option>
             </select>
           </td>
         </tr>
         <tr>
          <td><span >不通状态源线路：</span></td>
          <td > 
           <?$query=$db->query("select * from setacl");
           $i=0;
             while($row=$db->fetchAssoc($query)){
             	$acl[$i][0]=$row['aclname'];
             	$acl[$i][1]=$row['aclident'];
             $i++;
             }?>
          <select name="maclns" id="maclns">
             <?for($t=0;$t<$i;$t++){?>
             <option value="<?echo $acl[$t][1]?>"><?echo $acl[$t][0]."(".$acl[$t][1].")"?></option>
             <?}?>
             </select></td>
          <td class="title">转换到线路：</td>
          <td width="265" align="left" > <select name="maclnd" id="maclnd">
             <?for($t=0;$t<$i;$t++){?>
             <option value="<?echo $acl[$t][1]?>"><?echo $acl[$t][0]."(".$acl[$t][1].")"?></option>
             <?}?>
             </select></td>
         </tr>
        
        
        
        <tr>
          <td  colspan="4"   class="footer"><label>
            <input type="submit" name="Submit" value="保存设置" />
          </label></td>
        </tr>      </table></form>
 <table width="776" class="s s_grid">
  <tr>
    <td class="caption" colspan="4">监控策略列表</td>
  </tr>    <tr>
        <th width="279" >监控主机</th>
        <th width="287" >不通状态</th>
        <th width="65" >是否开启</th>
        <th width="124">管理</th>
      </tr>
      <?
		$query=$db->query("select * from mhostacl,mhost where mhost.mid=mhostacl.maclhostid order by mhostacl.maclid desc");
while($row = $db->fetchAssoc($query))
{
?>
      <tr>
        <td    ><?echo $row['mname']."(".$row['mip'].")"?></td>
        <td    ><?echo $row['maclns']."线路切换到->".$row['maclnd']."线路"?></td>
        <td    ><?if($row['maclis']=="1"){echo "启用中";}else{echo "停用中";}?></td>
        <td    ><a href="setmoacl_mode.php?id=<?echo $row['maclid']?>">修改</a> <a href="setmoacl.php?id=<?echo $row['maclid']?>&ac=del" onclick="javascript:return   confirm('真的要删除此监控策略吗？');">删除</a></td>
      </tr>
      <?}
      $db->close();?>
    </table>
 </div><div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
