<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();
$page = checkPage();
if($_GET['ac']=='del')
	{
		
		$sql="delete from mhostapp where mappid=".$_GET['id'];
		$db->query($sql);
	
	}
	if($_GET['ac']=='all')
	{
		
		$sql="delete from mhostapp ";
		$db->query($sql);
	
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>监控检测设置</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script src="../js/jquery.js"></script>
<script src="../js/ximo_dns.js"></script>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 监控检测 </div>
<div class="content"><table width="80%" class="s s_grid">
  <tr>
    <td  class="caption" colspan="4">监控检测 <a href="?ac=all" onclick="javascript:return confirm('真的要清空全部记录吗？');">清空全部</a></td>
  </tr>
      <tr>
        <th>检测时间</th>
        <th>监控主机主机IP/URL</th>
        <th>检测状态</th>
        <th>管理</th>
        </tr>
      <?
		 $starnum = ($page-1)*$pagesizenum;
	  $sql = "select count(*) as a1 from mhostapp";
        
        $query=$db->query($sql);
        $allnum=0;
        while($row=$db->fetchAssoc($query))
        {
        	$allnum=$row['a1'];
        }
        $totalpage=ceil($allnum/$pagesizenum);
        $sql ="select * from mhostapp order by mappid desc"; 
	$sql=$sql." limit {$starnum},{$pagesizenum}";
$query = $db->query($sql);
while($row = $db->fetchAssoc($query))
{
	$bg="#ffffff";
	if($row['mappresult']=="0")
	{
		$bg="#fcdfdf";
	}
?>
      <tr class="<?=$row['mappresult']=="0"?"bg_red":""?>">
        <td bgcolor="<?echo $bg?>"><?echo $row['mapptime']?></td>
        <td  bgcolor="<?echo $bg?>"><?echo $row['mapphost']?></td>
        <td bgcolor="<?echo $bg?>"><?if($row['mappresult']==1){echo '正常状态！';}else{echo '不通状态';}?></td>
        <td bgcolor="<?echo $bg?>" ><a href="?id=<?echo $row['mappid']?>&ac=del" onclick="javascript:return   confirm('真的要删除此监控历史吗？');">删除</a></td>
        </tr>
      <?}
      $db->close();?>
    </table>
  <div align="center"> 
  <br>
         共 <?echo $allnum?> 条记录，当前：<?echo $page?>/<?echo $totalpage?> 页 显示第 <? echo $starnum+1?>-<?echo $starnum+$i?> 条记录
		 <br><a href="?page=1<?echo $keyword?>">首页</a> <?if($page>1){?><a href="?page=<?echo $page-1?><?echo $keyword?>">上一页</a><?}else{?>上一页<?}?> <?if($page<$totalpage){?><a href="?page=<?echo $page+1?><?echo $keyword?>">下一页</a><?}else{?>下一页<?}?> <a href="?page=<?echo $totalpage?><?echo $keyword?>">末页</a> 　到第
      <select onchange="window.location='?page='+this.value+'<?echo $keyword?>'" size="1" name="topage">
        <? for( $i=1;$i<=$totalpage;$i++) 
        {?>
        <option value="<?echo $i?>" <?if($i==$page){echo "selected=selected";}?>><?echo $i?></option>
       <?}?>
      </select>
页，共 <?echo $totalpage?>页
</div>
</div>
<div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
