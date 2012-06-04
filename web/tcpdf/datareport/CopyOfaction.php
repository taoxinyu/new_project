<?
include ("/xmdns/web/include/comm.php");
$db1 = new SQL("pdo:database=/xmdns/var/log/dns.db");
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
$bb="/usr/bin/true >".$dumpfile;
//exec($runipt." '".$bb."'");
exec($bb);
exec("/ximo/usr/sbin/rndc stats");
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


function getDates($str)
{
	return date('ymd',strtotime($str));
}

$startDay=getDates($_POST['start']);
$startY=date('y',strtotime($_POST['start']));
$startM=date('m',strtotime($_POST['start']));
$startD=date('d',strtotime($_POST['start']));
$endDay=getDates($_POST['end']);
$endY=date('y',strtotime($_POST['end']));
$endM=date('m',strtotime($_POST['end']));
$endD=date('d',strtotime($_POST['end']));

$ns=$_POST['pagese'];
$topn="limit 0,$ns";
//echo $_POST['pagese'].'<br>';

/*
var_dump($startY);echo '<br>';
var_dump($startM);echo '<br>';
var_dump($startD);echo '<br>';
var_dump($endY);echo '<br>';
var_dump($endM);echo '<br>';
var_dump($endD);echo '<br>';
*/
$intSY=intval($startY);
$intSM=intval($startM);
$intSD=intval($startD);
$intEY=intval($endY);
$intEM=intval($endM);
$intED=intval($endD);

function getstrings($ints)
{
	$strs=strval($ints);
	if(strlen($strs)==1)
	$strs='0'.$strs;
	return $strs;
}

$mon_arr=array();
$sqlsum="select * from dns".$startY.$startM." where time between '".$startDay."' and '".$startY.$startM."31' union all select * from dns".$endY.$endM." where time between '".$endY.$endM."01' and '".$endDay."'";

if (!$db1->fetchAssoc($db1->query("select * from sqlite_master where name = 'dns".$startY.$startM."'"))) {
	//echo '空首';
	$sqlsum="select * from dns".$endY.$endM." where time between '".$endY.$endM."01' and '".$endDay."'";
}
if (!$db1->fetchAssoc($db1->query("select * from sqlite_master where name = 'dns".$endY.$endM."'"))) {
	//echo !$db1->fetchAssoc($db->query("select * from sqlite_master where name = 'dns".$endY.$endM."'"));
	//echo '空尾';
	$sqlsum="select * from dns".$startY.$startM." where time between '".$startDay."' and '".$startY.$startM."31'";
}

if ((!$db1->fetchAssoc($db1->query("select * from sqlite_master where name = 'dns".$startY.$startM."'"))) && (!$db1->fetchAssoc($db1->query("select * from sqlite_master where name = 'dns".$endY.$endM."'")))) {
	$sem=1;
	$sqlsum="";
}


if ($intSY==$intEY) {
	if ($intSM==$intEM) {
		$sqlsum="select * from dns".$startY.$startM." where time between '".$startDay."' and '".$endDay."'" ;
	}
	elseif (($intEM-$intSM)>1)
	{
		$len=$intEM-$intSM-1;
		$arrM=$intSM+1;
		for ($i=1;$i<=$len;$i++)
		{
			$nowmonth=getstrings($arrM);
			array_push($mon_arr,'dns'.$startY.$nowmonth);
			$arrM++;
		}
	}
}
else{
	if ($intSM<12) {
		$arrM=$intSM+1;
		for ($i=$intSM+1;$i<=12;$i++)
		{
			$nowmonth=getstrings($arrM);
			array_push($mon_arr,'dns'.$startY.$nowmonth);
			$arrM++;
		}
	}
	if ($intEM>1) {
		$arrM=1;
		for ($i=1;$i<$intEM;$i++)
		{
			$nowmonth=getstrings($arrM);
			array_push($mon_arr,'dns'.$endY.$nowmonth);
			$arrM++;
		}
	}
	for ($i=$intSY+1;$i<$intEY;$i++)
	{
		for ($j=1;$j<=12;$j++){
			array_push($mon_arr,'dns'.getstrings($i).getstrings($j));
		}
	}
}

$mon_table=array();

if ($mon_arr) {
	foreach ($mon_arr as $a)
	{
		$sqlarr="select * from sqlite_master where name = '".$a."'";
		$queryarr=$db1->query($sqlarr);

		//var_dump($queryarr);
		//var_dump($db1->fetchAssoc($queryarr));echo '<br>';
		if ($db1->fetchAssoc($queryarr)) {
			//$sqlsum.=" union all select * from $a";
			array_push($mon_table,$a);
		}
	}
}

foreach ($mon_table as $keys=>$tn)
{
	if ($sem==1 && $keys==0) {
		$sqlsum.="select * from $tn";
	}
	else {
		$sqlsum.=" union all select * from $tn";
	}
}

//echo $sqlsum.'<br>'.$topn;
//var_dump($mon_arr);
//var_dump($mon_table);


//$db1 = new SQL("pdo:database=/xmdns/var/log/dns.db");
$db2 = new SQL("pdo:database=/xmdns/var/log/dns.db");
//$topn=" limit 0,$ns";
$sqlEDU1="select domain,sum(domn) from (".$sqlsum.") where time between '".$startDay."' and '".$endDay."' and server = 'EDU' and domain !='' group by domain order by sum(domn) DESC ".$topn;
//echo $sqlEDU1.'<br>'.$topn;
$sqlEDU2="select ip,sum(ipn) from (".$sqlsum.") where time between '".$startDay."' and '".$endDay."' and server = 'EDU' and ip !='' group by ip order by sum(ipn) DESC ".$topn;
$sqlTELECOM1="select domain,sum(domn) from (".$sqlsum.") where time between '".$startDay."' and '".$endDay."' and server = 'TELECOM' and domain !='' group by domain order by sum(domn) DESC ".$topn;
$sqlTELECOM2="select ip,sum(ipn) from (".$sqlsum.") where time between '".$startDay."' and '".$endDay."' and server = 'TELECOM' and ip !='' group by ip order by sum(ipn) DESC ".$topn;
$sqlCNC1="select domain,sum(domn) from (".$sqlsum.") where time between '".$startDay."' and '".$endDay."' and server = 'CNC' and domain !='' group by domain order by sum(domn) DESC ".$topn;
$sqlCNC2="select ip,sum(ipn) from (".$sqlsum.") where time between '".$startDay."' and '".$endDay."' and server = 'CNC' and ip !='' group by ip order by sum(ipn) DESC ".$topn;
$sqlMOBILE1="select domain,sum(domn) from (".$sqlsum.") where time between '".$startDay."' and '".$endDay."' and server = 'MOBILE' and domain !='' group by domain order by sum(domn) DESC ".$topn;
$sqlMOBILE2="select ip,sum(ipn) from (".$sqlsum.") where time between '".$startDay."' and '".$endDay."' and server = 'MOBILE' and ip !='' group by ip order by sum(ipn) DESC ".$topn;
$sqlANY1="select domain,sum(domn) from (".$sqlsum.") where time between '".$startDay."' and '".$endDay."' and server = 'ANY' and domain !='' group by domain order by sum(domn) DESC ".$topn;
$sqlANY2="select ip,sum(ipn) from (".$sqlsum.") where time between '".$startDay."' and '".$endDay."' and server = 'ANY' and ip !='' group by ip order by sum(ipn) DESC ".$topn;


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



//  ------------------------------------------------------------------------------------
require_once('../config/lang/eng.php');
require_once('../tcpdf.php');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8',
 false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 009');
$pdf->SetSubject('TCPDF');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
$pdf->SetFont('stsongstdlight', '', 8);
$pdf->SetHeaderData('../images/logo.png', PDF_HEADER_LOGO_WIDTH, ' '  , '');
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setLanguageArray($l);


$pdf->AddPage();
$pdf->SetFont('chinese', 'L', 12);
$path=array(
1=>array("内存一小时内情况","/xmdns/var/hot/system/mem-hour.png"),
2=>array("内存六小时内情况","/xmdns/var/hot/system/mem-6h.png"),
3=>array("内存一天内情况","/xmdns/var/hot/system/mem-day.png"),
4=>array("内存一周内情况","/xmdns/var/hot/system/mem-week.png"),
5=>array("内存一月内情况","/xmdns/var/hot/system/mem-month.png"),
6=>array("内存一年内情况","/xmdns/var/hot/system/mem-year.png"),

7=>array("CPU一小时内情况","/xmdns/var/hot/system/cpu-hour.png"),
8=>array("CPU六小时内情况","/xmdns/var/hot/system/cpu-6h.png"),
9=>array("CPU一天内情况","/xmdns/var/hot/system/cpu-day.png"),
10=>array("CPU一周内情况","/xmdns/var/hot/system/cpu-week.png"),
11=>array("CPU一月内情况","/xmdns/var/hot/system/cpu-month.png"),
12=>array("CPU一年内情况","/xmdns/var/hot/system/cpu-year.png"),

13=>array("接口一小时内情况","/xmdns/var/hot/traffic/".$_POST['port']."-hour.png"),
14=>array("接口六小时内情况","/xmdns/var/hot/traffic/".$_POST['port']."-6h.png"),
15=>array("接口一天内情况","/xmdns/var/hot/traffic/".$_POST['port']."-day.png"),
16=>array("接口一周内情况","/xmdns/var/hot/traffic/".$_POST['port']."-week.png"),
17=>array("接口一月内情况","/xmdns/var/hot/traffic/".$_POST['port']."-month.png"),
18=>array("接口一年内情况","/xmdns/var/hot/traffic/".$_POST['port']."-year.png"),

//19=>array("DNS一小时内情况","system/cpu-hour.png"),
20=>array("DNS六小时内情况","/var/cache/bindgraph/,cgi-bin,bindgraph.cgi/bindgraph_0.png"),
21=>array("DNS一天内情况","/var/cache/bindgraph/,cgi-bin,bindgraph.cgi/bindgraph_1.png"),
22=>array("DNS一周内情况","/var/cache/bindgraph/,cgi-bin,bindgraph.cgi/bindgraph_2.png"),
23=>array("DNS一月内情况","/var/cache/bindgraph/,cgi-bin,bindgraph.cgi/bindgraph_3.png"),
24=>array("DNS一年内情况","/var/cache/bindgraph/,cgi-bin,bindgraph.cgi/bindgraph_4.png")

);
$html="";
foreach ($_POST["checkbox"] as $v){
	if($v==19){ continue;};
	$html.='<div align="center">'.$path[$v][0].'</div>
<div align="center"><img src="'.$path[$v][1].'" height="230" width="530"></div>';
		
}

// -------------------------------------------------------------------------
if($startDay!=700101 or $endDay!=700101)
{
$html.='
<table border="1px">
  <tr>
    <td class="caption" colspan="7">教育网</td>
  </tr>
  <tr bgcolor="f7fe0" align="center">
    <th>域名排名</th>
    <th>域名</th>
    <th>次数</th>
    <th>IP排名</th>
    <th>IP</th>
    <th>地区</th>
    <th>次数</th>
  </tr>
';
$queryEDU1=$db2->query($sqlEDU1);
$queryEDU2=$db2->query($sqlEDU2);
$rankEDU1=$db2->rowCount($queryEDU1);
$rankEDU2=$db2->rowCount($queryEDU2);
$rankEDU=($rankEDU1>=$rankEDU2)?$rankEDU1:$rankEDU2;
$queryEDU1=$db2->query($sqlEDU1);
$queryEDU2=$db2->query($sqlEDU2);
//while ($rowEDU1=$db1->fetch($queryEDU1))
for($i=1;$i<=$rankEDU;$i++)
{
	$rowEDU1=$db2->fetch($queryEDU1);
	$rowEDU2=$db2->fetch($queryEDU2);
	$ip2=$rowEDU2['ip']?mb_convert_encoding(convertip($rowEDU2['ip']),"utf-8","gb2312"):"";
$html.='
  <tr>
    <td height="25" align="center">'. $i .'</td>
    <td align="center">'.$rowEDU1['domain'] .'</td>
    <td align="center">'.$rowEDU1['sum(domn)'] .'</td>
    <td align="center">'.$i.'</td>
    <td align="center">'.$rowEDU2['ip'].'</td>
    <td align="center">'.$ip2.'</td>
    <td align="center">'.$rowEDU2['sum(ipn)'].'</td>
  </tr>
  ';
}
$html.='
  <tr>
    <td class="caption" colspan="7">中国电信</td>
  </tr>
  <tr bgcolor="f7fe0" align="center">
    <th>域名排名</th>
    <th>域名</th>
    <th>次数</th>
    <th>IP排名</th>
    <th>IP</th>
    <th>地区</th>
    <th>次数</th>
  </tr>
  ';
$queryTELECOM1=$db2->query($sqlTELECOM1);
$queryTELECOM2=$db2->query($sqlTELECOM2);
$rankTELECOM1=$db2->rowCount($queryTELECOM1);
$rankTELECOM2=$db2->rowCount($queryTELECOM2);
$rankTELECOM=($rankTELECOM1>=$rankTELECOM2)?$rankTELECOM1:$rankTELECOM2;
$queryTELECOM1=$db2->query($sqlTELECOM1);
$queryTELECOM2=$db2->query($sqlTELECOM2);
//while ($rowEDU1=$db1->fetch($queryEDU1))
for($i=1;$i<=$rankTELECOM;$i++)
{
	$rowTELECOM1=$db2->fetch($queryTELECOM1);
	$rowTELECOM2=$db2->fetch($queryTELECOM2);
	$ip2=$rowTELECOM2['ip']?mb_convert_encoding(convertip($rowTELECOM2['ip']),"utf-8","gb2312"):"";
$html.='
  <tr>
    <td height="25" align="center">'. $i .'</td>
    <td align="center">'.$rowTELECOM1['domain'] .'</td>
    <td align="center">'.$rowTELECOM1['sum(domn)'] .'</td>
    <td align="center">'. $i .'</td>
    <td align="center">'.$rowTELECOM2['ip'].'</td>
    <td align="center">'.$ip2.'</td>
    <td align="center">'.$rowTELECOM2['sum(ipn)'].'</td>
  </tr>
  ';
}

$html.='
  <tr>
    <td class="caption" colspan="7">新联通</td>
  </tr>
  <tr bgcolor="f7fe0" align="center">
    <th>域名排名</th>
    <th>域名</th>
    <th>次数</th>
    <th>IP排名</th>
    <th>IP</th>
    <th>地区</th>
    <th>次数</th>
  </tr>
  ';
$queryCNC1=$db2->query($sqlCNC1);
$queryCNC2=$db2->query($sqlCNC2);
$rankCNC1=$db2->rowCount($queryCNC1);
$rankCNC2=$db2->rowCount($queryCNC2);
$rankCNC=($rankCNC1>=$rankCNC2)?$rankCNC1:$rankCNC2;
$queryCNC1=$db2->query($sqlCNC1);
$queryCNC2=$db2->query($sqlCNC2);
//while ($rowEDU1=$db1->fetch($queryEDU1))
for($i=1;$i<=$rankCNC;$i++)
{
	$rowCNC1=$db2->fetch($queryCNC1);
	$rowCNC2=$db2->fetch($queryCNC2);
	$ip2=$rowCNC2['ip']?mb_convert_encoding(convertip($rowCNC2['ip']),"utf-8","gb2312"):"";
$html.='
  <tr>
    <td height="25" align="center">'. $i .'</td>
    <td align="center">'.$rowCNC1['domain'].'</td>
    <td align="center">'.$rowCNC1['sum(domn)'].'</td>
    <td align="center">'. $i .'</td>
    <td align="center">'.  $rowCNC2['ip'].'</td>
    <td align="center">'.$ip2.'</td>
    <td align="center">'.$rowCNC2['sum(ipn)'].'</td>
  </tr>
  ';
}
$html.='
  <tr>
    <td class="caption" colspan="7">新移动</td>
  </tr>
  <tr bgcolor="f7fe0" align="center">
    <th>域名排名</th>
    <th>域名</th>
    <th>次数</th>
    <th>IP排名</th>
    <th>IP</th>
    <th>地区</th>
    <th>次数</th>
  </tr>
  ';
$queryMOBILE1=$db2->query($sqlMOBILE1);
$queryMOBILE2=$db2->query($sqlMOBILE2);
$rankMOBILE1=$db2->rowCount($queryMOBILE1);
$rankMOBILE2=$db2->rowCount($queryMOBILE2);
$rankMOBILE=($rankMOBILE1>=$rankMOBILE2)?$rankMOBILE1:$rankMOBILE2;
$queryMOBILE1=$db2->query($sqlMOBILE1);
$queryMOBILE2=$db2->query($sqlMOBILE2);
//while ($rowEDU1=$db1->fetch($queryEDU1))
for($i=1;$i<=$rankMOBILE;$i++)
{
	$rowMOBILE1=$db2->fetch($queryMOBILE1);
	$rowMOBILE2=$db2->fetch($queryMOBILE2);
	$ip2=$rowMOBILE2['ip']?mb_convert_encoding(convertip($rowMOBILE2['ip']),"utf-8","gb2312"):"";
$html.='
  <tr>
    <td height="25" align="center">'. $i .'</td>
    <td align="center">'.  $rowMOBILE1['domain'] .'</td>
    <td align="center">'.  $rowMOBILE1['sum(domn)'] .'</td>
    <td align="center">'.  $i.'</td>
    <td align="center">'. $rowMOBILE2['ip'].'</td>
    <td align="center">'.$ip2.'</td>
    <td align="center">'. $rowMOBILE2['sum(ipn)'].'</td>
  </tr>
  ';
}

$html.='
  <tr>
    <td class="caption" colspan="7">其他线路</td>
  </tr>
  <tr bgcolor="f7fe0" align="center">
    <th>域名排名</th>
    <th>域名</th>
    <th>次数</th>
    <th>IP排名</th>
    <th>IP</th>
    <th>地区</th>
    <th>次数</th>
  </tr>
  ';

$queryANY1=$db2->query($sqlANY1);
$queryANY2=$db2->query($sqlANY2);
$rankANY1=$db2->rowCount($queryANY1);
$rankANY2=$db2->rowCount($queryANY2);
$rankANY=($rankANY1>=$rankANY2)?$rankANY1:$rankANY2;
$queryANY1=$db2->query($sqlANY1);
$queryANY2=$db2->query($sqlANY2);
//while ($rowEDU1=$db1->fetch($queryEDU1))
for($i=1;$i<=$rankANY;$i++)
{
	$rowANY1=$db2->fetch($queryANY1);
	$rowANY2=$db2->fetch($queryANY2);
	$ip2=$rowANY2['ip']?mb_convert_encoding(convertip($rowANY2['ip']),"utf-8","gb2312"):"";

$html.='
  <tr>
    <td height="25" align="center">'. $i .'</td>
    <td align="center">'.  $rowANY1['domain'].'</td>
    <td align="center">'. $rowANY1['sum(domn)'].'</td>
    <td align="center">'. $i .'</td>
    <td align="center">'.  $rowANY2['ip'].'</td>
    <td align="center">'.$ip2.'</td>
    <td align="center">'.$rowANY2['sum(ipn)'].'</td>
  </tr>
  ';
 
}
 $html.='</table>';
}
$pdf->writeHTML($html, true, true, true, true, '');
$pdf->Output('report.pdf', 'I');
?>
