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
<title>DNS状态日志</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<script type="text/javascript" src="../js/checkdays.js"></script>
<script type="text/javascript" src="../js/setdate.js"></script>
<style>
.s td{text-align:left;}
</style>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; DNS状态日志 </div>
<div class="content">
<table width="768" class="s s_grid">
      <tr>
        <td class="caption">DNS状态日志</td>
      </tr>
	   <tr>
        <td height="25" align="center" class="bluebg">
		<form id="search" name="search" method="post" action="dnsstatelog.php">
          <table width="100%" border="0" align="center" cellspacing="0" cellpadding="0">
            <tr>
              <td class="bluebg" width="54" align="right">时间：</td>
              <td class="bluebg" width="120" align="left">
			 <input name="start" type="text" id="start" size="12" onclick="fPopCalendar(event,this,this)" onfocus="this.select()" readonly="readonly" value="<?echo  $_REQUEST['start']?>" title="双击弹出日期选择" />
			</td>
              <td class="bluebg" width="54" align="right">域名：</td>
              <td class="bluebg" width="100"><input type="text" name="domain" id="domain" size="20" value="<?echo $_REQUEST['domain']?>"/></td>
              <td class="bluebg" width="54">关键词</td>
			  <td class="bluebg" width="125"><input type="text" name="keywords" id="keywords" size="20" value="<?echo $_REQUEST['keywords']?>"/></td>
			  <td class="bluebg" width="54" align="right"><input type="submit" name="Submit" value="查询" /></td>
			  <td class="bluebg" width="90" align="left"></td>
			  <td class="bluebg" width="56"></td>
            </tr>
          </table>
		  </form>                                    
        </td>
      </tr>
<?php
		$subs='';
	    if($_REQUEST['start']!=''){
			$start=date('d-M-Y',strtotime($_REQUEST['start']));		  
			$subs.="|grep '".$start."' ";
			$where[]= "start=".$_REQUEST['start'];
		}
		if($_REQUEST['domain']){
			$strip="/^\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b$/";
			if(preg_match($strip,$_REQUEST['domain'])){
				$domains=explode(".",$_REQUEST['domain']);
				$domain=$domains[2].".".$domains[1].".".$domains[0];
			}else{			  
				$domain=$_REQUEST['domain'];
			}
			$subs.="|grep  'zone ".$domain."' ";
			$where[]= "domain=".$_REQUEST['domain'];
		}
		if($_REQUEST['keywords']){
			$subs.="|grep  '".$_REQUEST['keywords']."' ";
			$where[]= "keywords=".$_REQUEST['keywords'];
		}
		if(isset($_REQUEST['Submit'])){
			exec("cat ".$bindgenerallog." ".$subs." |sed -n '$='",$ipconfig1);
			$linenum=$ipconfig1[0];
			if($page==1){
				$starnum =$linenum-($page-1)*$pagesizenum;
			}else {
				$starnum =$linenum-($page-1)*$pagesizenum+1;
			}
			$pagem=$starnum-$pagesizenum+1;
			if($pagem<=0){
				$pagem=1;
			}
			exec("cat ".$bindgenerallog." ".$subs." |sed -n '".$pagem.",".($starnum)."p'",$ipconfig);
			$where[]= "Submit=".$_REQUEST['Submit'];
			$logfile=implode("&",$where);
		}else{
			exec("sed -n '$=' ".$bindgenerallog,$ipconfig1);
			$linenum=$ipconfig1[0];
			if($page==1){
				$starnum =$linenum-($page-1)*$pagesizenum;
			}else {
				$starnum =$linenum-($page-1)*$pagesizenum+1;
			}
			$pagem=$starnum-$pagesizenum+1;
			if($pagem<=0){
				$pagem=1;
			}
			exec("sed -n '".$pagem.",".($starnum)."p' ".$bindgenerallog,$ipconfig);
		}
		$ac="#FFFFFF";
		$a=0;
		$totalpage=ceil($linenum/$pagesizenum);
		for($Tmpa=sizeof($ipconfig);$Tmpa>=0;$Tmpa--){ 
			if($a==0){
				$ac="#e7f4ff";
				$a=1;
			}else {
				$ac="#FFFFFF";
				$a=0;
			}
			if($ipconfig[$Tmpa]!=''){
?>
        <tr>
        <td>
<?echo $ipconfig[$Tmpa];?>
</td></tr><?
	}}
?>
    </table>
	<div align="center">
	<br>
共 <?echo $linenum?> 条记录，当前：<?echo $page?>/<?echo $totalpage?> 页  每页<?echo $pagesizenum?>条记录
<br><a href="?page=1&<? echo $logfile?>">首页</a> <?if($page>1){?><a href="?page=<?echo $page-1?>&keyword=<? echo $keyword?>&<? echo $logfile?>">上一页</a><?}else{?>上一页<?}?> <?if($page<$totalpage){?><a href="?page=<?echo $page+1?>&keyword=<? echo $keyword?>&<? echo $logfile?>">下一页</a><?}else{?>下一页<?}?> <a href="?page=<?echo $totalpage?>&keyword=<? echo $keyword?>&<? echo $logfile?>">末页</a> 　到第
      <select onchange="window.location='?<? echo $logfile?>&page='+this.value" size="1" name="topage">
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
