<?
include ('../include/comm.php');
$pageaccess=3;
checklogin();
checkac();
$page = checkPage();
$logfile=isset($_GET['logfile'])&&$_GET["logfile"]!=""?$logback.$_GET["logfile"]:$querylog;//默认
$logfile=(isset($_GET["Submit"])&&$_GET["start"]!=""&&$_GET['start']!=date("Y-m-d"))?$logback.date("ymd",strtotime($_GET['start'])):$logfile;//提交
$myfile2=basename($logfile)=="dns_query.log"?"":basename($logfile);
//echo $myfile2;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>DNS查询日志</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/checkdays.js"></script>
<script type="text/javascript" src="../js/setdate.js"></script>
<style>
.s td{text-align:left;}
</style>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; DNS历史日志 </div>
<div class="content">
<table width="768" class="s s_grid">
      <tr>
        <td class="caption">DNS历史日志</td>
      </tr>
      <tr>
        <td height="25" align="center" class="bluebg">
		<form id="search" name="search" method="get" action="logquery.php">
          <table width="78%" border="0" align="center" cellspacing="0" cellpadding="0">
            <tr>
              <td class="bluebg" width="57" align="right">转到：</td>
              <td class="bluebg" width="207" align="left">
			  <select onchange="window.location='?logfile='+this.value"  name="logfile">
              <option value="" <? if($_GET['logfile']==''){echo "selected";}?>>今天日志</option>
              <? $db->close();
              $db=new SQL($logbackdb);
              $query=$db->query("select * from dnslog order by addtime desc");
			  while($row=$db->fetchAssoc($query))
			  {
			  	?>
			  <option value="<?echo $row['doname']?>" <?if($row['doname']==$_GET['logfile']){echo "selected";}?>><?echo $row['logname']?>日志</option>
			  <?}?>
      
			</select>
			<?if($myfile2==''){?><a href="down.php?file=dns_query.log"><?}else{?><a href="down.php?file=<?echo $myfile2;?>"><?}?>点击下载</a></td>
              <td class="bluebg" width="142" align="right">查询(双击选择日期)：</td>
              <td class="bluebg" width="135"><label>
              <input name="start" type="text" id="start" size="12"  readonly="readonly" onfocus="this.select()" onclick="fPopCalendar(event,this,this)" value="<?echo $_GET['start']?>" title="双击弹出日期选择" />
              </label></td>
              <td class="bluebg" width="56"><label>
                <input type="submit" name="Submit" value="查询" />
              </label></td>
            </tr>
          </table>
		  </form>                                    
        </td>
      </tr>
    
         <?      
      	exec("sed -n '$=' ".$logfile,$ipconfig1);
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
     
      exec("sed -n '".$pagem.",".($starnum)."p' ".$logfile,$ipconfig,$rc);

for($Tmpa=sizeof($ipconfig);$Tmpa>=0;$Tmpa--){ 
	if($a==0){
		$ac="#e7f4ff";
		$a=1;
	}else 
	{$ac="#FFFFFF";
	$a=0;}
	if($ipconfig[$Tmpa]!=''){?>
        <tr>
        <td>
<?echo $ipconfig[$Tmpa];?></td></tr><?
	}}
?>
    </table>
	<div align="center">
	<br>
    共 <?echo $linenum?> 条记录，当前：<?echo $page?>/<?echo $totalpage?> 页  每页<?echo $pagesizenum?>条记录
<br>
<a href="?page=1&start=<?echo $_GET['start']?>&logfile=<? echo $myfile2?>">首页</a> <?if($page>1){?><a href="?page=<?echo $page-1?>&start=<?echo $_GET['start']?>&logfile=<? echo $myfile2?>">上一页</a><?}else{?>上一页<?}?> <?if($page<$totalpage){?><a href="?page=<?echo $page+1?>&start=<?echo $_GET['start']?>&logfile=<? echo $myfile2?>">下一页</a><?}else{?>下一页<?}?> <a href="?page=<?echo $totalpage?>&start=<?echo $_GET['start']?>&logfile=<? echo $myfile2?>">末页</a> 　到第
      <select onchange="window.location='?logfile=<? echo $myfile2?>&start=<?echo $_GET['start']?>&page='+this.value" size="1" name="topage">
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
