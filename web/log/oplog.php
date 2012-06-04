<?
include ('../include/comm.php');
$pageaccess=3;
checklogin();
checkac();
$page = checkPage();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>操作日志</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>

<script src="../js/checkdays.js"></script>
<script src="../js/setdate.js"></script>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 操作日志 </div>
<div class="content">
<table width="780" class="s s_grid">
      <tr>
        <td colspan="5" class="caption">操作日志</td>
      </tr>
      <tr>
        <td colspan="5">
          <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
            <form id="keyword" name="keyword" method="post" action="oplog.php"><tr>
              <td  class="bluebg" width="64" height="25" align="right">开始时间:</td>
              <td  class="bluebg" width="106"><label>
                <input name="start" type="text" id="start" size="12" onclick="fPopCalendar(event,this,this)" onfocus="this.select()" readonly="readonly" value="<?echo $_REQUEST['start']?>" alt="双击弹出日期选择" title="双击弹出日期选择" />
              </label></td>
              <td  class="bluebg" width="64" align="right">结束时间:</td>
              <td  class="bluebg" width="104"><input name="end" type="text" id="end" size="12" onclick="fPopCalendar(event,this,this)" onfocus="this.select()" readonly="readonly" value="<?echo  $_REQUEST['end']?>" title="双击弹出日期选择" /></td>
              <td  class="bluebg" width="58" align="right">用户名:</td>
              <td  class="bluebg" width="84"><input name="username" type="text" id="username" size="10" value="<?echo $_REQUEST['username']?>" /></td>
              <td  class="bluebg" width="50" align="right">行为:</td>
              <td  class="bluebg" width="88" align="left"><label>
                <select name="op">
                  <option value="" selected>所有</option>
                  <?
                  $query=$db->query('select distinct dotype from dorecord');
                  while($row=$db->fetchAssoc($query))
                  {?>
                   <option value="<?echo $row['dotype']?>" <? if($row['dotype']==$_REQUEST['op']){echo "selected";}?>><?echo $row['dotype']?></option>
                   <?}?>
                </select>
              </label></td>
              <td  class="bluebg" width="129">
                <input type="submit" name="Submit" value="查询" />
             <?
        $starnum = ($page-1)*$pagesizenum;
        $keyword="";
        $sqld=" 1<2 ";
        if($_REQUEST['start']!='')
        {
        	$sqld=$sqld." and date(addtime)>='".$_REQUEST['start']."'";
        	$keyword=$keyword."&start=".$_REQUEST['start'];
        }
         if($_REQUEST['end']!='')
        {
        	$sqld=$sqld." and date(addtime)<='".$_REQUEST['end']."'";
        	$keyword=$keyword."&end=".$_REQUEST['end'];
        }
         if($_REQUEST['username']!='')
        {
        	$sqld=$sqld." and username='".$_REQUEST['username']."'";
        	$keyword=$keyword."&username=".$_REQUEST['username'];
        }
        if($_REQUEST['op']!='')
        {
        	$sqld=$sqld." and dotype='".$_REQUEST['op']."'";
        	$keyword=$keyword."&op=".$_REQUEST['op'];
        }
        $sql = "select count(*) as mycount from dorecord where".$sqld;
        $query=$db->query($sql);
        $allnum=0;
        while($row=$db->fetchAssoc($query))
        {
        	$allnum=$row['mycount'];
        }
        $totalpage=ceil($allnum/$pagesizenum);
        $sql1 ="select * from dorecord where".$sqld." order by addtime desc"; 
	$sql=$sql1." limit {$starnum},{$pagesizenum}";
$query = $db->query($sql);
$i=0;    
		$a=0;
		?>
	
		 <a href="downop.php?sql=<? echo $sql1;?>">			
			点击下载</a></td>
            </tr></form>
          </table>
		   </td>
        </tr>
      <tr>
        <th width="10%"><strong>序号</strong></th>
        <th width="25%"><strong>时间</strong></th>
        <th width="15%"><strong>用户</strong></th>
        <th width="20%"><strong>行为</strong></th>
        <th width="30%"><strong>详细记录</strong></th>
      </tr>
<?
while($row = $db->fetchAssoc($query))
{
	$i=$i+1;
	if($a==0){
		$ac="#e7f4ff";
		$a=1;
	}else 
	{$ac="#FFFFFF";
	$a=0;}

?>
      <tr>
        <td><? echo $row['id']?></td>
        <td><? echo $row['addtime']?></td>
        <td><? echo $row['username']?></td>
        <td><? echo $row['dotype']?></td>  
        <td><? echo $row['param']?> </td>
      </tr><?
		}		
		$db->close();		
		?>
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
