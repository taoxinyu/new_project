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
<link href="../divstyle.css" rel="stylesheet" type="text/css" />
<script src="../js/calendar.js"></script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="28" align="left" background="../images/bg_topbg.gif">&nbsp;当前位置:&gt;&gt; 操作日志 </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><table width="768" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#82C4E8">
      <tr>
        <td height="25" colspan="5" align="center" background="../images/abg2.gif" bgcolor="#D7F5F9" class="greenbg">操作日志</td>
      </tr>
      <tr>
        <td height="22" colspan="5" align="center" background="../images/abg.gif" bgcolor="#D7F5F9" class="graybg">
          <table width="747" border="0" align="center" cellpadding="0" cellspacing="0">
            <form id="keyword" name="keyword" method="post" action="oplog.php"><tr>
              <td width="64" height="25" align="right">开始时间:</td>
              <td width="106"><label>
                <input name="start" type="text" id="start" size="12" ondblclick="calendar()" value="<?echo $_POST['start']?>" alt="双击弹出日期选择" title="双击弹出日期选择" />
              </label></td>
              <td width="64" align="right">结束时间:</td>
              <td width="104"><input name="end" type="text" id="end" size="12" ondblclick="calendar()" value="<?echo  $_POST['end']?>" title="双击弹出日期选择" /></td>
              <td width="58" align="right">用户名:</td>
              <td width="84"><input name="username" type="text" id="username" size="10" value="<?echo $_POST['username']?>" /></td>
              <td width="50" align="right">行为:</td>
              <td width="88" align="left"><label>
                <select name="op">
                  <option value="" selected>所有</option>
                  <?
                  $query=$db->query('select distinct dotype from dorecord');
                  while($row=$db->fetchAssoc($query))
                  {?>
                   <option value="<?echo $row['dotype']?>" <? if($row['dotype']==$_POST['op']){echo "selected";}?>><?echo $row['dotype']?></option>
                   <?}?>
                </select>
              </label></td>
              <td width="129">
                <input type="submit" name="Submit" value="查询" />
             <?
        $starnum = ($page-1)*$pagesizenum;
        $keyword="";
        $sqld=" 1<2 ";
        if($_POST['start']!='')
        {
        	$sqld=$sqld." and date(addtime)>='".$_POST['start']."'";
        	$keyword=$keyword."&start=".$_POST['start'];
        }
         if($_POST['end']!='')
        {
        	$sqld=$sqld." and date(addtime)<='".$_POST['end']."'";
        	$keyword=$keyword."&end=".$_POST['end'];
        }
         if($_POST['username']!='')
        {
        	$sqld=$sqld." and username='".$_POST['username']."'";
        	$keyword=$keyword."&username=".$_POST['username'];
        }
        if($_POST['op']!='')
        {
        	$sqld=$sqld." and dotype='".$_POST['op']."'";
        	$keyword=$keyword."&op=".$_POST['op'];
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
        <td width="38" height="22" align="center" background="../images/abg.gif" bgcolor="#D7F5F9" class="graybg"><strong>序号</strong></td>
        <td width="134" height="22" align="center" background="../images/abg.gif" bgcolor="#D7F5F9" class="graybg"><strong>
          <label>时间</label>
        </strong></td>
        <td width="75" height="22" align="center" background="../images/abg.gif" bgcolor="#D7F5F9" class="graybg"><strong>用户</strong></td>
        <td width="100" height="22" align="center" background="../images/abg.gif" bgcolor="#D7F5F9" class="graybg"><strong>行为</strong></td>
       
        <td width="316" height="22" align="center" background="../images/abg.gif" bgcolor="#D7F5F9" class="graybg"><strong>详细记录</strong></td>
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
        <td height="25" align="center" bgcolor="<?echo $ac?>" class="graytext"><? echo $row['id']?></td>
        <td height="25" align="center" bgcolor="<?echo $ac?>" class="graytext"><label><? echo $row['addtime']?></label></td>
        <td align="center" bgcolor="<?echo $ac?>" class="graytext"><? echo $row['username']?></td>
        <td align="center" bgcolor="<?echo $ac?>" class="graytext"><? echo $row['dotype']?></td>
   
        <td align="left" bgcolor="<?echo $ac?>" class="graytext"><? echo $row['param']?> </td>
      </tr><?
		}
		
		$db->close();
		
		?>
    </table></td>
  </tr>
 <tr>
    <td height="25" align="center" valign="middle">共 <?echo $allnum?> 条记录，当前：<?echo $page?>/<?echo $totalpage?> 页 显示第 <? echo $starnum+1?>-<?echo $starnum+$i?> 条记录 </td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle"><a href="?page=1<?echo $keyword?>">首页</a> <?if($page>1){?><a href="?page=<?echo $page-1?><?echo $keyword?>">上一页</a><?}else{?>上一页<?}?> <?if($page<$totalpage){?><a href="?page=<?echo $page+1?><?echo $keyword?>">下一页</a><?}else{?>下一页<?}?> <a href="?page=<?echo $totalpage?><?echo $keyword?>">末页</a> 　到第
      <select onchange="window.location='?page='+this.value+'<?echo $keyword?>'" size="1" name="topage">
        <? for( $i=1;$i<=$totalpage;$i++) 
        {?>
        <option value="<?echo $i?>" <?if($i==$page){echo "selected=selected";}?>><?echo $i?></option>
       <?}?>
      </select>
页，共 <?echo $totalpage?>页</td>
  </tr>
</table><? include "../copyright.php";?>
</body>
</html>
