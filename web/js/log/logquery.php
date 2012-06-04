<?
include ('../include/comm.php');
$pageaccess=3;
checklogin();
checkac();
$bindquerylog='/xmdns/var/logquery/dns_query.log';
$page = checkPage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>DNS查询日志</title>
<link href="../divstyle.css" rel="stylesheet" type="text/css" />
<script src="../js/calendar.js"></script>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
.STYLE1 {font-size:12px; color:#420505; margin-left:30px; font: "宋体";}
-->
</style></head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="28" align="left" background="../images/bg_topbg.gif">&nbsp;当前位置:&gt;&gt; DNS历史日志 </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><table width="768" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#82C4E8">
      <tr>
        <td height="25" colspan="3" align="center" background="../images/abg.gif" bgcolor="#D7F5F9" class="greenbg">DNS历史日志</td>
      </tr>
      <tr>
        <td height="25" colspan="3" align="center" background="../images/abg2.gif" bgcolor="#D7F5F9" class="graybg">
          <table width="597" border="0" cellspacing="0" cellpadding="0">
            <form id="search" name="search" method="get" action="logquery.php"><tr>
              <td width="57" align="right">转到：</td>
              <td width="207" align="left">
			  <select onchange="window.location='?logfile='+this.value"  name="logfile">
              <option value="" <? if($_GET['logfile']==''){echo "selected";}?>>今天日志</option>
              <? $db->close();
              $db=new SQL($logbackdb);
              $query=$db->query("select * from dnslog order by addtime desc");
              
			  while($row=$db->fetchAssoc($query))
			  {?>
			  <option value="<?echo $row['doname']?>" <?if($row['doname']==$_GET['logfile']){echo "selected";}?>><?echo $row['logname']?>日志</option>
			  <?}?>
      
			</select>
			<?if($_GET['logfile']==''){?><a href="down.php?file=../logback/dns_query.log"><?}else{?><a href="down.php?file=../logback/logback/<?echo $_GET['logfile']?>"><?}?>点击下载</a></td>
              <td width="142" align="right">查询(双击选择日期)：</td>
              <td width="135"><label>
              <input name="start" type="text" id="start" size="12" ondblclick="calendar()" value="<?echo $_GET['start']?>" title="双击弹出日期选择" />
              </label></td>
              <td width="56"><label>
                <input type="submit" name="Submit" value="查询" />
              </label></td>
            </tr></form>
          </table>
                                        
        </td>
      </tr>
    
         <?      
        if(isset($_GET['logfile'])&&$_GET['logfile']!='')
        {
        	$myfile=$logback.$_GET['logfile'];
        	$myfile2=$_GET['logfile'];
        }else 
        {
        	if($_GET['logfile']==''&&$_GET['start']=='')
        	{
        		$myfile=$bindquerylog;
        		$myfile2='';
        	}else{
        	if($_GET['start']!='')
        	{
        		$query=$db->query("select * from dnslog where logname='".$_GET['start']."'");
        		$row=$db->fetchAssoc($query);
        		$myfile1=$row['doname'];
        	}
        	$db->close();
        	if($myfile1!=''){
        	$myfile=$logback.$myfile1;
        	$myfile2=$myfile1;
        	}
        	}
        }
       exec("sed -n '$=' ".$myfile,$ipconfig1);
      
        $linenum=$ipconfig1[0];
        if($page==0){
        $starnum =$linenum-($page-1)*$pagesizenum;
        }else 
        {
        	 $starnum =$linenum-($page-1)*$pagesizenum+1;
        }
      $pagem=$starnum-$pagesizenum+1;
      if($pagem<=0)
      {
      	$pagem=1;
      }
      $ac="#FFFFFF";
      $a=0;
      $totalpage=ceil($linenum/$pagesizenum);
     
      exec("sed -n '".$pagem.",".($starnum)."p' ".$myfile,$ipconfig,$rc);
for($Tmpa=sizeof($ipconfig);$Tmpa>=0;$Tmpa--){ 
	if($a==0){
		$ac="#e7f4ff";
		$a=1;
	}else 
	{$ac="#FFFFFF";
	$a=0;}
	if($ipconfig[$Tmpa]!=''){?>
        <tr>
        <td align="left"  height="22"  colspan="3" bgcolor="<?echo $ac?>" class="graytext">
<?echo $ipconfig[$Tmpa];?></td></tr><?
	}}
?>
    </table></td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle">共 <?echo $linenum?> 条记录，当前：<?echo $page?>/<?echo $totalpage?> 页  每页<?echo $pagesizenum?>条记录</td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle"><a href="?page=1&start=<?echo $_GET['start']?>&logfile=<? echo $myfile2?>">首页</a> <?if($page>1){?><a href="?page=<?echo $page-1?>&start=<?echo $_GET['start']?>&logfile=<? echo $myfile2?>">上一页</a><?}else{?>上一页<?}?> <?if($page<$totalpage){?><a href="?page=<?echo $page+1?>&start=<?echo $_GET['start']?>&logfile=<? echo $myfile2?>">下一页</a><?}else{?>下一页<?}?> <a href="?page=<?echo $totalpage?>&start=<?echo $_GET['start']?>&logfile=<? echo $myfile2?>">末页</a> 　到第
      <select onchange="window.location='?logfile=<? echo $myfile2?>&start=<?echo $_GET['start']?>&page='+this.value" size="1" name="topage">
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
