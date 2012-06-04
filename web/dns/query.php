<?php
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();



exec( $rndccmd." status", &$dnsstatus );	
$aa=$dnsstatus;	
$dnsstatus = join( "<br>", $dnsstatus );	
if($dnsstatus!=""){
		
		$dns=1;
}else 
{
	$dns=0;
}
//执行RNDC stats查看统计信息
if($dns==1){

//$bb="/bin/mv ".$dumpfile." /ximolog/named.old";
$bb=$truecmd." >".$dumpfile;
//exec($runipt." '".$bb."'");	
exec($bb);
exec($rndccmd." stats");	
}
//开始统计
//$a=file($dumpfile);
$b=file_get_contents($dumpfile);

$astats = get_count2($b);
//$allcount=gettotal($a);

if (isset($_GET['table']))
	$table = $_GET['table'];
else
	$table = "dns".date("Ymd", strtotime("1 days ago"));

function get_count2($content){
	$content = str_replace("\n", "\r\n", $content);
	$pattern = "/\+\+\+ Statistics Dump \+\+\+[\s\S]*?--- Statistics Dump --- \(\d{10}\)/";
	preg_match_all($pattern, $content, $matches);

	$n = count($matches[0]);
	//$count = array("",0,0,0,0,0,0);
    $count = array();
	
	//循环各次统计
	for ($b = 0; $b < $n; $b++){
		//global $count;
		$str = $matches[0][$b];

		$p_pzqs = "/(?<=\+\+ Per Zone Query Statistics \+\+)[\s\S]*?(?=\n[-$])/";
		preg_match($p_pzqs, $str, $m_pzqs);

		$p_pzqs1 = "/(?<=\[).+(?=\])/";
		$p_pzqs2 = "/(?<=\])[\s\S]*?(?=($|(\n\[)))/";
		preg_match_all($p_pzqs1, $m_pzqs[0], $m_pzqsn);        //匹配出所有[]内的名称
		preg_match_all($p_pzqs2, $m_pzqs[0], $m_pzqsv);        //匹配出名称后的属性信息
		
		for ($i = 0; $i < count($m_pzqsn[0]); $i++){
			$doci = 0;
			if (strlen($m_pzqsv[0][$i]) > 1){//有统计数据
			    
				$p_domain = '/.+(?=\()/';
				preg_match($p_domain, $m_pzqsn[0][$i], $domain);//提取出域名
                
				/*
				$p_do = "/".$yum."/";
				if (!preg_match($p_do, $domain[0]))
					break;
				*/
				
				$querycount = array("", 0,0,0,0,0,0);
				$querycount[0] = $domain[0];
				$p_pzqs2_d = "/\b\d+\b/";
				$p_pzqs2_s = "/(?<=\d\s).*/";
				preg_match_all($p_pzqs2_d, $m_pzqsv[0][$i], $pzqs_d);  //提取出数字
				preg_match_all($p_pzqs2_s, $m_pzqsv[0][$i], $pzqs_s);  //提取出说明文字

				$pquery[2] = '/successful/';		//成功次数
				$pquery[3] = '/nxrrset/';			//不存在记录
				$pquery[4] = '/NXDOMAIN/';     		//不存在域名
				$pquery[5] = '/SERVFAIL/'; 			//失败查询
				//$pquery[6] = '/authoritative/';		//权威查询

				for ($a = 0; $a < count($pzqs_s[0]); $a++){
					for ($k = 2; $k < 7; $k++){
						if (@preg_match($pquery[$k], $pzqs_s[0][$a]) == 1){
						    
							$querycount[$k] = $pzqs_d[0][$a];
						}
					}
				}
                $count[trim($domain[0])][1] += $querycount[2]+$querycount[3]+$querycount[4]+$querycount[5]; //total
				$count[trim($domain[0])][2] += $querycount[2]; //succes
				$count[trim($domain[0])][3] += $querycount[3]; //nxrrset
				$count[trim($domain[0])][4] += $querycount[4]; //nxdomain
				$count[trim($domain[0])][5] += $querycount[5]; //servfail
				//$count[trim($domain[0])][6] += $querycount[6]; //author
			}
		}
	}
	return $count;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>无标题文档</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script src="../js/checkdays.js"></script>
<script src="../js/setdate.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<style>
.s_form td{text-align:center;}
</style>
<script language="javascript">

function show(showId)
{
	document.getElementById(showId).style.display=""; 
}

function hide(hideId)
{
	document.getElementById(hideId).style.display="none"; 
}

function showAndHide(showId,hideId)
{
	show(showId);hide(hideId);
}

function checkGo()
{
	if(document.checkdays.start.value=="")
	{
		alert("请输入开始时间");
		document.checkdays.start.focus();
		return false;
	}
	if(document.checkdays.end.value=="")
	{
		alert("请输入结束时间");
		document.checkdays.end.focus();
		return false;
	}
	return true;
}

function autoGo()
{
	if(document.autodays.autostart.value=="")
	{
		alert("您还没有输入日期");
		document.autodays.autostart.focus();
		return false;
	}
	return true;
}
</script>
</head>
<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; 统计查询</div>
<div class="content">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td>
  <table width="768" class="s s_grid">
      <tr>
        <td  class="caption" colspan="6">域名查询统计</td>
      </tr>
      <tr align="center">
        <th>域名</th>
        <th>总查询</th>
        <th>成功查询</th>
        <th>NXRRSET</th>
        <th>NXDOMAIN</th>
        <th>失败查询</th>
      </tr>
      <?$query=$db->query("select * from domain");
      while($row=$db->fetchAssoc($query))
      {
		//$count = get_count($b, $row['domainname']);
		$dm = $row['domainname'];
		$count = $astats[$dm];
		if ($count[1] == 0){
		    $count = array(0,0,0,0,0,0);
		}
	  ?>
      <tr>
        <td><?echo $row['domainname']?></td>
        <td><?echo $count[1];?></td>
        <td><?echo $count[2];?></td>
        <td><?echo $count[3];?></td>
        <td><?echo $count[4];?></td>
        <td><?echo $count[5];?></td>
      </tr>
      <?}?>
    
    </table>
  <br>
  <div align="center">
  <input type="submit" name="openhelp" value="点击查看使用说明" onclick="javascript:show('helps')"/>
  <table id="helps" width="768" align="center" cellpadding="2" cellspacing="1" style="display:none; background-color:#FFFFFF; border:1px solid #82c4e8;"><tr><td align="left">
  <br><br><p>
  本页面具有丰富的查询功能：可自行输入起始日期（双击弹出日期选择框）直接查询起始日期之间的数据，也可根据“系统自动帮助”按：年，月，日，季度，周自动输入起始时间查询！
  </p>
  <p>
  系统自动输入功能详解：首先输入要查询时间段的任意日期（双击弹出日期选择框），然后按照选择按钮选择该日期所在的时间段：可以是年，月，日，季度，周！选择完成后系统将自动输入所在时间段的起始日期。
  </p>
  </td></tr>
  <tr><td><br><br><input type="submit" name="shuthelp" value="我知道了，关闭" onclick="javascript:hide('helps')" /></td></tr>
  </table>
  </div>
  <br />
  <div align="center">
  <table width="768" class="s s_form">
  <tr>
     <td class="caption">统计查询</td>
  </tr>
  
  <tr><td>
  <input type="radio" name="checkmode" value="0" onclick="javascript:showAndHide('autodays','checkdays');" />精确查询&nbsp;&nbsp;&nbsp;
  <input type="radio" name="checkmode" value="1" onclick="javascript:showAndHide('checkdays','autodays');" checked />范围查询

  <tr><td>
  <form name="checkdays" method="POST" action="querydata.php" onsubmit="return checkGo();"> 
  <table id="checkdays" width="768" class="bod" align="center" cellpadding="0" cellspacing="0" bgcolor="#82C4E8" >  
   <tr><td>  
  起始日期（单击弹出选择器）：
  <input id="start" name="start" type="text" size="13" title="单击弹出日期选择" onclick="fPopCalendar(event,this,this)" onfocus="this.select()" readonly="readonly" />到
  <input id="end" name="end" type="text" size="13" title="单击弹出日期选择" onclick="fPopCalendar(event,this,this)" onfocus="this.select()" readonly="readonly" />
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TopN：
  <select id="pagese" size="1" name="pagese">
  <option value="10" selected=selected>10</option>
  <option value="20" >20</option>
  <option value="30" >30</option>
  <option value="40" >40</option>
  <option value="50" >50</option>
  <option value="60" >60</option>
  <option value="70" >70</option>
  <option value="80" >80</option>
  <option value="90" >90</option>
  <option value="100" >100</option>
  </select>
  </td></tr>
  <tr><td>
  <input type="submit" name="dayscheck" value="查询"/>
  </td></tr>
  </table></form>
  <table id="autodays" width="768" align="center" class="bod" cellpadding="0" cellspacing="0" bgcolor="#82C4E8"  style="display:none;">
  <form name="autodays" method="POST" action="querydata.php" onsubmit="return autoGo();">
  <tr><td>
  查询时间：
  <input name="aday" type="text" id="aday" size="13" title="单击弹出日期选择" value="<?php echo date("Y-m-d",strtotime("-1 day")); ?>" onclick="fPopCalendar(event,this,this)" onfocus="this.select()" readonly onPropertyChange="newSE()" />&nbsp;&nbsp;
  时间范围：
  <input type="radio" name="timese" id="timese0" value="0" checked onclick="javascript:creatOneDay('aday','autostart','autoend');" />最近一天&nbsp;
  <input type="radio" name="timese" id="timese3" value="3" onclick="javascript:creatWeek('aday','autostart','autoend');" />当周&nbsp;
  <input type="radio" name="timese" id="timese1" value="1" onclick="javascript:creatMonth('aday','autostart','autoend');" />当月&nbsp;
  <input type="radio" name="timese" id="timese4" value="4" onclick="javascript:creatQuarter('aday','autostart','autoend');" />当季度&nbsp;
  <input type="radio" name="timese" id="timese2" value="2" onclick="javascript:creatYear('aday','autostart','autoend');" />当年&nbsp;&nbsp;TopN：
  <select id="pageauto" size="1" name="pageauto">
  <option value="10" selected=selected>10</option>
  <option value="20" >20</option>
  <option value="30" >30</option>
  <option value="40" >40</option>
  <option value="50" >50</option>
  <option value="60" >60</option>
  <option value="70" >70</option>
  <option value="80" >80</option>
  <option value="90" >90</option>
  <option value="100" >100</option>
  </select>
  </td></tr>
  <tr><td>
  <input name="autostart" type="text" id="autostart" size="13" title="自动输入开始日期" readonly="readonly"value="<?php echo date("Y-m-d",strtotime("-1 day")); ?>"  />到
  <input name="autoend" type="text" id="autoend" size="13" title="自动输入结束日期" readonly="readonly"value="<?php echo date("Y-m-d",strtotime("-1 day")); ?>"  />
  <input type="submit" name="autodays" value="查询"/>
  </td></tr>
  <!--tr><td height="25" background="../images/abg.gif" bgcolor="#e7f4ff" class="graybg">
  
  </td></tr-->
  </form>
  </table>
  </div>
  </table>
</table>
</div>
<div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
<script language="javascript">
/*function getOs(){//判断浏览器类型 
var OsObject = ""; 
if(navigator.userAgent.indexOf("MSIE")>0) { 
return "MSIE"; 
} 
if(isFirefox=navigator.userAgent.indexOf("Firefox")>0){ 
return "Firefox"; 
} 
if(isSafari=navigator.userAgent.indexOf("Safari")>0) { 
return "Safari"; 
} 
if(isCamino=navigator.userAgent.indexOf("Camino")>0){ 
return "Camino"; 
} 
if(isMozilla=navigator.userAgent.indexOf("Gecko/")>0){ 
return "Gecko"; 
} 

} 

if(navigator.userAgent.indexOf("MSIE")>0){ 
document.getElementById('aday').attachEvent("onpropertychange",txChange);
}else if(navigator.userAgent.indexOf("Firefox")>0){ 
document.getElementById('aday').addEventListener("input",txChange2,false); 
} 
function txChange(){ 
newSE(); alert('222');
} 
function txChange2(){ 
newSE();
}*/
function newSE()
{
	if(document.getElementById('timese0').checked)
	{
		creatOneDay('aday','autostart','autoend');
	}
	if(document.getElementById('timese1').checked)
	{
		creatMonth('aday','autostart','autoend');
	}
	if(document.getElementById('timese2').checked)
	{
		creatYear('aday','autostart','autoend');
	}
	if(document.getElementById('timese3').checked)
	{
		creatWeek('aday','autostart','autoend');
	}
	if(document.getElementById('timese4').checked)
	{
		creatQuarter('aday','autostart','autoend');
	}
}
</script>
