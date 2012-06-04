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
<title>防火墙日志</title>
<link href="../divstyle.css" rel="stylesheet" type="text/css" />
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
    <td height="28" align="left" background="../images/bg_topbg.gif">&nbsp;当前位置:&gt;&gt; 防火墙日志 </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  
  <tr>
    <td><table width="768" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#82C4E8">
      <tr>
        <td height="25" colspan="3" align="center" background="../images/abg2.gif" bgcolor="#D7F5F9" class="greenbg">防火墙日志</td>
      </tr>
    
         <?      
        
       exec("sed -n '$=' ".$ipfwlog,$ipconfig1);
      
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
     
      exec("sed -n '".$pagem.",".($starnum)."p' ".$ipfwlog,$ipconfig,$rc);
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
<?echo $ipconfig[$Tmpa];?>
</td></tr><?
	}}
?>
    </table></td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle">共 <?echo $linenum?> 条记录，当前：<?echo $page?>/<?echo $totalpage?> 页  每页<?echo $pagesizenum?>条记录</td>
  </tr>
  <tr>
    <td height="25" align="center" valign="middle"><a href="?page=1&logfile=<? echo $logfile?>">首页</a> <?if($page>1){?><a href="?page=<?echo $page-1?>&keyword=<? echo $keyword?>&logfile=<? echo $logfile?>">上一页</a><?}else{?>上一页<?}?> <?if($page<$totalpage){?><a href="?page=<?echo $page+1?>&keyword=<? echo $keyword?>&logfile=<? echo $logfile?>">下一页</a><?}else{?>下一页<?}?> <a href="?page=<?echo $totalpage?>&keyword=<? echo $keyword?>&logfile=<? echo $logfile?>">末页</a> 　到第
      <select onchange="window.location='?logfile=<? echo $logfile?>&page='+this.value" size="1" name="topage">
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
