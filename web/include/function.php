<? 
/*********************************************
*
* 程序名： 动态dns后台管理系统
* 演  示： http://www.zzci.com
*
* 作 者： 张水华
* Email： ryangecko@163.com
* 网 址： http://www.zzci.com
*
* 版本： v1.0
* 帮助： http://www.zzci.com/cdn
*
*********************************************/
function showmessage($msg,$tt="0")
{
	switch ($tt)
	{
		case '0':
			$script = "";
			break;
		case '1':
			$script = "location.href=\"".$_SESSION["HTTP_REFERER"]."\";";
			break;
		case '2':
			$script = "history.back();";
			break;
		default:
		 $script = "location.href=\"".$tt."\";";	
	}
    echo "<script language='javascript'>window.alert('".$msg."');".$script."</script>";
    exit;	
}

function sqlEncode(&$value,$key='',$allowHtml=array()){
	if(is_array($value))
		array_walk($value,'sqlEncode');
	else {
		if(!get_magic_quotes_gpc())
			$value = addslashes($value);
	}
}
function createnewserial()
{
	return date("Ymd", time())."01";
}
function createserial($oldstr)
{
	$new=date("Ymd",time());	
	if(strlen($oldstr)==10)
	{
		$old=substr($oldstr, 0, 8);
		if($new==$old)
		{
			$ll=substr($oldstr,8,9);
			$l2=$ll+1;
			if(strlen($l2)==1)
			{
				$l2='0'.$l2;
			}
			return $new.$l2;			
		}else 
		{
			return createnewserial();
		}
		
	}else 
	{
		return createnewserial();
	}
	
}
function mystate($thisstate)
{
if($thisstate==1)
{return "启用中";
}
else
{
return "未启用";
}
}
function sqlDecode(&$value,$key='',$allowHtml=array()){
	if(is_array($value))
		array_walk($value,'sqlDecode');
	else{	
		if(get_magic_quotes_runtime())
			$vue = stripslashes($value);
		if(!in_array($key,$allowHtml))
			$value = textFormat($value);
		else
			$value = deUnsafeTag($value);
	}
}

function textFormat($text){
	$text = htmlspecialchars($text);
	$text = preg_replace("/[ ]/",'&nbsp;',$text);
	$text = nl2br($text);
	return $text;
}

function deUnsafeTag($content){
	$content = preg_replace("/<script(.*?)>(.*?)<\/script>/ies","htmlspecialchars('\\0')",$content);
	$content = strip_tags($content,'<p><strong><em><u><strike><a><img><font><br><ul><li><b>');
	$pattern = array(
		0 => '/<(.+?)(class|style|id)\s*=\s*(\'(.+?)\'|"(.+?)")?(.*?)>/is',
		1 => '/<(.+?)on[a-zA-z]+\s*=\s*(\'(.+?)\'|"(.+?)")?(.*?)>/is',
		2 => '/<img(.+?)\/?>/is'
	);
	$replacement = array(
		0 => '<\\1\\6>',
		1 => '<\\1\\5>',
		2 => '<img\\1 onload="if(this.width>screen.width*0.55) {this.resized=true; this.width=screen.width*0.55;}">'
	);
	return preg_replace($pattern,$replacement,$content);
}

function deIp($ip){
	return preg_replace('/\.\d{1,3}$/','.*',$ip);
}



function gettime(){
	$timeArr = explode(" ",microtime());
	return $timeArr[1] + $timeArr[0];
}





function encode($str) { 
	$encode_key = '1234567890'; 
	$decode_key = '2468021359'; 
	if (strlen($str) == 0) return  ''; 
	$enstr = '';
	for($i=0;$i<strlen($str);$i++){ 
		for($j=0;$j<strlen($encode_key);$j++){ 
			if($str[$i] == $encode_key [$j]){ 
				$enstr .=  $decode_key[$j]; 
				break; 
			} 
		} 
	} 
	return $enstr; 
} 


function decode($str){ 
	$encode_key = '1234567890'; 
	$decode_key = '2468021359'; 
	if(strlen($str) == 0) return  ''; 
	$destr = '';
	for($i=0;$i<strlen($str);$i++){ 
		for($j=0;$j<strlen($decode_key);$j++){ 
			if($str[$i] == $decode_key [$j]){ 
				$enstr .=  $encode_key[$j]; 
				break; 
			} 
		} 
	} 
	return $destr; 
} 

function checkPage(){
	if(empty($_GET['page'])) 
		return 1;
	elseif(intval($_GET['page']) < 1) 
		return 1;
	else 
		return intval($_GET['page']);
}

function referer($encode=false){
	$referer = './index.php';
	if(!empty($_REQUEST['referer'])){
		$referer = $_REQUEST['referer'];
	}
	elseif(!empty($_SERVER['HTTP_REFERER'])){		
		$referer = $_SERVER['HTTP_REFERER'];
	}

	if($encode)
		$referer = urlencode($referer);
			
	return $referer;
}

function htmlTag($tag,$attr='',$content='',$addition=''){
	if($content == '')
		return '<'.$tag.(($attr=='')?'':' '.$attr).' />'.$addition;
	else 
		return '<'.$tag.(($attr=='')?'':' '.$attr).'>'.$content.'</'.$tag.'>'.$addition;
}

function writeFile($file_url,$file_str){
	if(file_exists($file_url) && !is_writable($file_url))
		return false;
	if(!($fp = fopen($file_url,'w')))
		return false;
	if(!(fwrite($fp,$file_str)))
		return false;
	fclose($fp);
	
	return true;
}
function writeShell($file,$content)
{
	$sh_head="#!/bin/bash\n\n";	
	file_put_contents($file,$sh_head . $content);
	chmod($file,0755);
}
function read_file($file_url){
	if(!file_exists($file_url) || !is_readable($file_url))
		return false;
		
	if(function_exists('file_get_contents'))
		return file_get_contents($file_url);
	else{
		$fp = fopen($file_url, "r");
		$contents = fread($fp, filesize ($file_url));
		fclose($fp); 
		return $contents;
	}
}
//设置
function setdns($conf,$iplist)
{
	if(writeFile($conf,$iplist))
 	{
 		return true;
 	}else 
 	{
 		return false;
 	}
}
 //设置网卡
 function setnetcard($conf,$cardname,$ip,$mask)
 {
 	//先判断是否存有
 	$configfile=read_file($conf);
 	$myset="ifconfig_".$cardname."=\"inet ".$ip." netmask ".$mask."\"";
 	if(preg_match("/ifconfig_".$cardname.".*/",$configfile))
 	{//如果网卡存有
 		$configfile=preg_replace("/ifconfig_".$cardname.".*/",$myset,$configfile);
	}else 
	{
		//网卡不存在
		$myset=$myset."\n#{end network set}";
		$configfile=preg_replace("/#\{end network set\}/",$myset,$configfile);
	}
	if(writeFile($conf,$configfile))
 	{
 		return true;
 	}else 
 	{
 		return false;
 	}
 }
 function setnetgate($conf,$ip)
 { 	
 	$configfile=read_file($conf);
 	$configfile=preg_replace('/defaultrouter=.*/',"defaultrouter=\"".$ip."\"",$configfile);
 	if(writeFile($conf,$configfile))
 	{
 		return true;
 	}else 
 	{
 		return false;
 	}
 }
  //设置主机
 function sethost($conf,$host)
 { 	
 	$configfile=read_file($conf);
 	$configfile=preg_replace('/hostname=.*/',"hostname=\"".$host."\"",$configfile);
 	if(writeFile($conf,$configfile))
 	{
 		return true;
 	}else 
 	{
 		return false;
 	}
 }
  //转换掩码IP函数  
 function getmaskip($mask)
 {
 	$a[1]=substr($mask,2,2);	
 	$a[2]=substr($mask,4,2);
 	$a[3]=substr($mask,6,2);
 	$a[4]=substr($mask,8,2);
 	return hexdec($a[1]).'.'.hexdec($a[2]).'.'.hexdec($a[3]).'.'.hexdec($a[4]);
 }
 //网卡信
 function getnetcard($cardname)
{
exec("ifconfig ".$cardname,$ipconfig,$rc);
$isactive[0]="0";
$isactive[1]="";
$isactive[2]="";
if($rc==0)
	{//先获取网卡			
		for($i=0,$max=sizeof($ipconfig);$i<$max;$i++)
		{		
			
			if(preg_match('/status: no carrier/',$ipconfig[$i]))
			{
				$isactive[0]="未连接";

			}
			if(preg_match('/status: active/',$ipconfig[$i]))
			{
				$isactive[0]="已连接";
			}
			if(preg_match('/media:.*/',$ipconfig[$i]))
			{//如果活动
				preg_match_all('/\(.*\)/',$ipconfig[$i],$a1);
				$isactive[1]=$a1[0][0];
			}
			if(preg_match('/ether.*/',$ipconfig[$i]))
			{//如果活动
				preg_match_all('/\d{2}.*/',$ipconfig[$i],$a1);
				$isactive[2]= $a1[0][0];
			}
		
		}
				 
	}
return $isactive;
}
function setwebport($conf,$newport)
{
$a=read_file($conf);
if(preg_match("/\\nListen .*\\n[\s\S]/",$a))
{ 
	$a=preg_replace("/\\nListen .*[\s\S]/","\nListen ".$newport."\n",$a);
	
}
if(preg_match("/\\nServerName 127.0.0.1\:.*[\s\S]/",$a))
{ 
	$a=preg_replace("/\\nServerName 127.0.0.1\:.*[\s\S]/","\nServerName 127.0.0.1:".$newport."\n",$a);
	
}
if(writeFile($conf,$a))
{return true;}else{return false;}
}
//设置https端口
function setwebports($conf,$newport)
{
$a=read_file($conf);
if(preg_match("/\\nListen .*\\n[\s\S]/",$a))
{ 
	$a=preg_replace("/\\nListen .*[\s\S]/","\nListen ".$newport."\n",$a);
	
}
if(preg_match("/\\n\<VirtualHost _default_\:.*[\s\S]/",$a))
{ 
	$a=preg_replace("/\\n\<VirtualHost _default_\:.*[\s\S]/","\n<VirtualHost _default_:".$newport.">\n",$a);
	
}
if(preg_match("/\\nServerName 127.0.0.1\:.*[\s\S]/",$a))
{ 
	$a=preg_replace("/\\nServerName 127.0.0.1\:.*[\s\S]/","\nServerName 127.0.0.1:".$newport."\n",$a);
	
}
if(writeFile($conf,$a))
{return true;}else{return false;}
}
//关闭https
function closehttps($conf,$newport)
{
$a=read_file($conf);
$b="\n#Include conf/extra/httpd-ssl.conf\n";

if(preg_match("/\\nInclude conf\/extra\/httpd-ssl.conf.*\\n[\s\S]/",$a))
{ 
	$a=preg_replace("/\\nInclude conf\/extra\/httpd-ssl.conf.*[\s\S]/",$b,$a);
}
if(preg_match("/\\n\#Listen .*\\n[\s\S]/",$a))
{ 
	$a=preg_replace("/\\n\#Listen .*[\s\S]/","\nListen ".$newport."\n",$a);	
}
if(writeFile($conf,$a))
{return true;}else{return false;}
}
//开启https
function openhttps($conf,$newport)
{
$a=read_file($conf);
$b="\nInclude conf/extra/httpd-ssl.conf\n";

if(preg_match("/\\n\#Include conf\/extra\/httpd-ssl.conf.*\\n[\s\S]/",$a))
{ 
	$a=preg_replace("/\\n\#Include conf\/extra\/httpd-ssl.conf.*[\s\S]/",$b,$a);
	
}
if(preg_match("/\\nListen .*\\n[\s\S]/",$a))
{ 
	$a=preg_replace("/\\nListen .*[\s\S]/","\n#Listen ".$newport."\n",$a);	
}
if(writeFile($conf,$a))
{return true;}else{return false;}
}
function setroute($db,$conf)
{
$query=$db->query("select * from route order by addtime desc");
$num=$db->num_rows($query);
if($num<=0)
{
$st1="";
}else 
{
	$st1="static_routes=\"";
}
	$i=1;
	$st2="";
while($row1 = $db->fetch_array($query))
{
	
	if($row1['isuse']==1)
	{
		$st1=$st1."static".$i." ";
		$st2=$st2."route_static".$i."=\"-net ".$row1['ip']."/".$row1['mask']." ".$row1['route']."\"\n";
		$i=$i+1;
	}
}
$a=$st1."\"\n".$st2;
if($num<=0){
	$a="";
}
$configfile=read_file($conf);
$c="#{start route}\n";
$c=$c.$a."#{end route}\n";
$configfile=preg_replace('/#\{start route\}[\s\S]+.*#\{end route\}/',$c, $configfile);
if(writeFile($conf,$configfile))
{return true;}else{return false;}
}

//设置网卡监控
function setmrtg($card,$ip)
{
$apachehome="/usr/local/apache/htdocs/";
$com="/usr/local/bin/cfgmaker --output=".$apachehome.$card."/index.cfg mrtg@".$ip;
exec($com);
$con=read_file($apachehome.$card."/index.cfg");
$con=preg_replace("/# WorkDir: \/home\/http\/mrtg/","WorkDir: ".$apachehome.$card,$con);
$recon="Options[_]: growright, bits\n"."#Language:GB2312\n";
$con=preg_replace("/# Options\[_\]\: growright, bits/",$recon,$con);
writeFile($apachehome.$card."/index.cfg",$con);
$com="/usr/local/bin/mrtg ".$apachehome.$card."/index.cfg";
exec($com);
$com="/usr/local/bin/indexmaker --output=".$apachehome.$card."/index.html ".$apachehome.$card."/index.cfg";
exec($com);
}
function setnetip($netname,$netip,$netmask)
{
	$com="/sbin/ifconfig ".$netname." ".$netip."  netmask ".$netmask;
    exec($com);
}
function setnetactive($netname,$isdown)
{
	if($isdown==0)
	{
	$com="/sbin/ifconfig ".$netname." down";
	}
	if($isdown==1)
	{
	$com="/sbin/ifconfig ".$netname." up";
	}
	if(isset($com)){
	exec($com);
	}
}
// error handler
function check_error(&$obj)
{
    if ($obj->isError()) {
        $error = $obj->getLastError();
        switch ($error->getCode()) {
        case CRYPT_RSA_ERROR_WRONG_TAIL :
            // nothing to do
            break;
        default:
            // echo error message and exit
            echo 'error: ', $error->getMessage();
            exit;
        }
    }
}

function getlic($file_con="")
{    
	require INC.'/RSA.php';
	$pubkey='YTozOntpOjA7czoxMjg6InNjf3UglwtUvqQiFWlxf3BbcsWmaO7gkVM9Vr9xfzez0qqVhYnx2R/XWZqr3ApO/TMOP9Rd97vA5x2x9Nhw0As9pZFlPL3isdc7xpFc80FjARp4BHEVsA4Xs+qCd5O+4BYMqOWRk9JqCJMFLfBrTHjXUBSzFiXF3o2RuOkfKCCzIjtpOjE7czozOiIBAAEiO2k6MjtzOjY6InB1YmxpYyI7fQ==';	
	if($file_con==""){
	$keyfile=LICDIR."license.key";
	if(!file_exists($keyfile)||!$file_con=file_get_contents($keyfile))
	{
	return false;
	}
	}
	    $enc_text = base64_decode($file_con);
	    $key = Crypt_RSA_Key::fromString($pubkey);
	    check_error($key);
	    $rsa_obj = new Crypt_RSA;
	    check_error($rsa_obj);
	    $rsa_obj->setParams(array('dec_key' => $key));
	    check_error($rsa_obj);
	    $plain_text = $rsa_obj->decrypt($enc_text);
	    check_error($rsa_obj);
		$licinfo=unserialize($plain_text);
		if(time()>$licinfo['expire'])
		{
			$licinfo['isexpire']=true;
			$licinfo['status_text']="已过期";
			$licinfo['status']=1;
		}
		else 
		{
			$licinfo['isexpire']=false;
			$licinfo['status_text']="已注册";
			$licinfo['status']=0;
		}
		

	return $licinfo;
}
function format_size($size) {
      $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
      if ($size == 0) { return('n/a'); } else {
      return (round($size/pow(1024, ($i = floor(log($size, 1024)))), $i > 1 ? 2 : 0) . $sizes[$i]); }
}
?>
