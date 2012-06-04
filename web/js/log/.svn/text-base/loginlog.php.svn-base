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
<title>登陆日志</title>
<link href="../divstyle.css" rel="stylesheet" type="text/css" />
<script src="../js/calendar.js"></script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="28" align="left" background="../images/bg_topbg.gif">&nbsp;当前位置:&gt;&gt; 登陆日志 </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><table width="768" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#82C4E8">
      <tr>
        <td height="25" colspan="5" align="center" background="../images/abg2.gif" bgcolor="#D7F5F9" class="greenbg">登陆日志</td>
      </tr>
      <tr>
        <td height="25" colspan="5" align="center" background="../images/abg.gif" bgcolor="#D7F5F9" class="graybg"><table width="747" border="0" align="center" cellpadding="0" cellspacing="0">
          <form id="keyword" name="keyword" method="get" action="loginlog.php">
            <tr>
              <td width="64" height="25" align="right">开始时间:</td>
              <td width="106"><label>
                <input name="start" type="text" id="start" size="12" ondblclick="calendar()" value="<?echo $_GET['start']?>" title="双击弹出日期选择" />
              </label></td>
              <td width="66" align="right">结束时间:</td>
              <td width="102"><input name="end" type="text" id="end" size="12" ondblclick="calendar()" value="<?echo  $_GET['end']?>" title="双击弹出日期选择" /></td>
              <td width="58" align="right">用户名:</td>
              <td width="79"><input name="username" type="text" id="username" size="10" value="<?echo $_GET['username']?>" /></td>
              <td width="55" align="right">状态:</td>
              <td width="98" align="left"><label>
                <select name="op">
                  <option value="" selected="selected">所有</option>
                <option value="成功登陆" <? if($_GET['op']=='成功登陆'){echo "selected";}?>>成功登陆</option>
				<option value="登陆失败" <? if($_GET['op']=='登陆失败'){echo "selected";}?>>登陆失败</option>
                </select>
              </label></td>
              <td width="119">
                <input type="submit" name="Submit" value="查询" />
				<?
        $starnum = ($page-1)*$pagesizenum;
        $keyword="";
        $sqld=" 1<2 ";
        if($_GET['start']!='')
        {
        	$sqld=$sqld." and date(addtime)>='".$_GET['start']."'";
        	$keyword=$keyword."&start=".$_GET['start'];
        }
         if($_GET['end']!='')
        {
        	$sqld=$sqld." and date(addtime)<='".$_GET['end']."'";
        	$keyword=$keyword."&end=".$_GET['end'];
        }
         if($_GET['username']!='')
        {
        	$sqld=$sqld." and username='".$_GET['username']."'";
        	$keyword=$keyword."&username=".$_GET['username'];
        }
        if($_GET['op']!='')
        {
        	$sqld=$sqld." and userstate='".$_GET['op']."'";
        	$keyword=$keyword."&op=".$_GET['op'];
        }
        $sql = "select count(*) as mycount from userlog where".$sqld;
        $query=$db->query($sql);
        $allnum=0;
        while($row=$db->fetchAssoc($query))
        {
        	$allnum=$row['mycount'];
        }
        $totalpage=ceil($allnum/$pagesizenum);
        $sql1 ="select * from userlog where ".$sqld." order by addtime desc"; 
	$sql=$sql1." limit {$starnum},{$pagesizenum}";
	//echo $sql;
$query = $db->query($sql);
$i=0;    
$a=0;
?>
			
				<a href="downlogin.php?sql=<? echo $sql1;?>">点击下载</a></td>
            </tr>
          </form>
        </table></td>
        </tr>
      <tr>
        <td width="51" height="22" align="center" background="../images/abg.gif" bgcolor="#D7F5F9" class="graybg"><strong>序号</strong></td>
        <td width="227" height="22" align="center" background="../images/abg.gif" bgcolor="#D7F5F9" class="graybg"><strong>
          <label>时间</label>
        </strong></td>
        <td width="117" height="22" align="center" background="../images/abg.gif" bgcolor="#D7F5F9" class="graybg"><strong>用户</strong></td>
        <td width="181" height="22" align="center" background="../images/abg.gif" bgcolor="#D7F5F9" class="graybg"><strong>登陆IP</strong></td>
        <td width="166" height="22" align="center" background="../images/abg.gif" bgcolor="#D7F5F9" class="graybg"><strong>状态</strong></td>
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
        <td height="25" align="center" bgcolor="<?echo $ac?>" class="<? if($row['userstate']=='登陆失败'){echo "redtext";}else {echo "graytext";}?>"><? echo $row['logid']?> </td>
        <td height="25" align="center" bgcolor="<?echo $ac?>" class="<? if($row['userstate']=='登陆失败'){echo "redtext";}else {echo "graytext";}?>"><label><? echo $row['addtime']?> </label></td>
        <td align="center" bgcolor="<?echo $ac?>" class="<? if($row['userstate']=='登陆失败'){echo "redtext";}else {echo "graytext";}?>"><? echo $row['username']?> </td>
        <td align="center" bgcolor="<?echo $ac?>" class="<? if($row['userstate']=='登陆失败'){echo "redtext";}else {echo "graytext";}?>"><? echo $row['userip']?> </td>
        <td align="center" bgcolor="<?echo $ac?>" class="<? if($row['userstate']=='登陆失败'){echo "redtext";}else {echo "graytext";}?>"><? echo $row['userstate']?> </td>
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
</table>
<? include "../copyright.php";?>
</body>
</html>
