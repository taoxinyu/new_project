<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();
if(isset($_POST['Submit'])){
	checkac('应用');
	$_POST['dnssecip']=($_POST['dnssecip']!="")?$_POST['dnssecip'].";":"";
	$_POST['dnsthirdip']=($_POST['dnsthirdip']!="")?$_POST['dnsthirdip'].";":"";
	$sql="update setdns set dnsname='".$_POST['dnsname']."',dnsdomain='".$_POST['dnsdomain']."',dnstype='".$_POST['dnstype']."'";
	$sql=$sql.",dnsip='".$_POST['dnsip']."',dnsadmin='".$_POST['dnsadmin']."',dnskey='".$_POST['dnskey']."',dnsdatebase=".$_POST['dnsdatebase'].",";
	$sql=$sql."dnsforward='".$_POST['dnsforward']."',dnsmainip='".$_POST['dnsmainip']."',dnssecip='".$_POST['dnssecip']."',dnsthirdip='".$_POST['dnsthirdip'];
	$sql=$sql."',dnsrefresh=".$_POST['dnsrefresh'].",dnsretry=".$_POST['dnsretry'].",dnsexpire=".$_POST['dnsexpire'].",dnsttl=".$_POST['dnsttl'].",dnsupdate=datetime('now','localtime')";
	$sql=$sql." where dnsid=1";
	
	$db->query($sql);
	createdns($db,$binddir);
	writelog($db,'DNS设置',"设置".$_POST['dnstype']."成功!");
	$sql="update domain set domainisapp='0'";
	$db->query($sql);
	aclapp($db,$binddir); //允许递归查询地址 应用到线路
	showmessage($_POST['dnstype'].'设置成功','setdns.php');
		

}else 
{//读取信息
	$query=$db->query("select * from setdns where dnsid=1");
	$row=$db->fetchAssoc($query);
	$row['dnssecip']=($row['dnssecip']!="")?substr($row['dnssecip'], 0, -1):"";
	$row['dnsthirdip']=($row['dnsthirdip']!="")?substr($row['dnsthirdip'], 0, -1):"";
}

function aclapp($db,$binddir){
global $logover,$logtemp,$logtemp1,$logtemp2,$logdns10,$logip10,$logurl,$logim,$sqlite3,$dnsdb,$logtimesh,$logback;
$sql="update setacl set aclisapp='1'";
$db->query($sql);
$sql="update forwarder set app=1";
$db->query($sql);

$rc=""; 	//存放ximoacl.conf内容
$rc1="";	//存放ximozone.conf内容

//DNS线路转发
/*
 * forwarder数据表中
 * zftype: 1 : 全部转此DNS解析;  0 : 本地DNS无法解析，转此DNS解析 
 * state: 1 : 启用; 0 : 停用
 * app: 1 : 应用; 0 : 未应用
 */
$sql = "select * from forwarder where state=1";
$query = $db->query($sql);
while ($row = $db->fetchAssoc($query)){
	if ($row['zftype'] == 1){ //全部转此DNS解析;
		$dnsip = $row['addr'];
		$dnsip = str_replace(";", ";\n", $dnsip);
		$dnsip .= ";";
		
		$rc .= "include \"acl/".$row['ident']."\";\n";    //存入ximoacl.conf的内容
		//存入ximozone.conf的内容
		$rc1 .= "view \"view_".$row['ident']."\" {\nmatch-clients { ".$row['ident']."; };\nallow-query { any; };\n";
		$rc1 .= "allow-recursion { any; };\nallow-transfer { any; };\nrecursion  yes;\n";
		$rc1 .= "forwarders {\n$dnsip\n};\n};\n";
	}
	else { //本地DNS无法解析，转此DNS解析 
		$dnsip = $row['addr'];
		$dnsip = str_replace(";", ";\n", $dnsip);
		$dnsip .= ";\n";
		
		$rc .= "include \"acl/".$row['ident']."\";\n";    //存入ximoacl.conf的内容
		$rc1 .= "view \"view_".$row['ident']."\" {\n";    //存入ximozone.conf的内容
		$rc1 .= "forwarders {\n$dnsip\n};\n};\n";
	}
}
//END    DNS线路转发

//添加线路信息
$sql="select * from setacl where aclis='1' order by aclpri";
$query=$db->query($sql);
$i=0;
while($row=$db->fetchAssoc($query))
{
	$rc=$rc."include \"acl/".$row['aclident']."\";\n";
	$rc1=$rc1.createaclzone($binddir,$row['aclident'],$db);
	$i++;
}

if($i>0){//线路个数大于0。有线路
    $rc1=$rc1.createanyzone($binddir,$db);
}else {//没有线路
	$rc1=createanyzone($binddir,$db);
}
//END    添加线路信息

//写入文件
//echo $rc1;
writeFile($binddir."ximoacl.conf",$rc);
writeFile($binddir."ximozone.conf",$rc1);

//添加区域文件
		
//生成time.sh
$timesh = "";
$strtop ="#!/bin/sh\n";
$strtop .="a=/bin/awk\n";
$strtop .="b=/bin/sort\n";
$strtop .="c=/usr/bin/tail\n";
$strtop .="log=`date +%y%m%d --date=\"-1 day\"`\n";

$strtop .="\$a -F '[ #]' '{print $11,$6,$9}' $logback\$log > $logover\n";

$timesh = $timesh.$strtop;
$sql = "select aclident from setacl where aclisapp='1'";
$rs = $db->query($sql);
while($row = $db->fetchAssoc($rs)){
$flag = $row['aclident'];
$strmid="\$a '/view_$flag/' $logover>$logtemp\n";
$strmid .="\$a '{a[$1]+=1};END{for(i in a){print \"$flag\" \",\" \",\" i \",\" \",\" a[i] \",\" \"'\$log'\"}}' $logtemp > $logtemp1\n";
$strmid .="\$b -n -t, -k5  $logtemp1|\$c -n10 >>$logdns10\n";
$strmid .="\$a '{a[$2]+=1};END{for(i in a){print \"$flag\" \",\" i \",\" \",\" a[i] \",\" \",\" \"'\$log'\"}}' $logtemp> $logtemp1\n";
$strmid .="\$b -n -t, -k5 $logtemp1|\$c -n10 >>$logip10\n";
$strmid .="x=0\n";                                                    
$strmid .="while [ \$x -le 100 ]\n";                                     
$strmid .="do\n";                                                     
$strmid .="x=$((x+1))\n";                                             
$strmid .="url=` grep $flag $logdns10|sed -n ''\$x'p'|awk -F ',' '{print $3}'`\n";
$strmid .="echo \$url\n";
$strmid .="awk '/^'\$url'/' $logtemp>$logtemp2\n";
$strmid .="awk '{a[$2]+=1}END{for(i in a) print a[i]\",\" \"$flag,\" i \",\" \"'\$url'\" \",\" \"'\$log'\"}' $logtemp2 | sort -n|tail -n10>> $logurl\n";
$strmid .="done\n";

$timesh = $timesh.$strmid;
}
$strend ="\$a '/view_ANY/' $logover>$logtemp\n";
$strend .="\$a '{a[$1]+=1};END{for(i in a){print \"ANY\" \",\" \",\" i \",\" \",\" a[i] \",\" \"'\$log'\"}}' $logtemp > $logtemp1\n";
$strend .="\$b -n -t, -k5  $logtemp1|\$c -n10 >>$logdns10\n";
$strend .="\$a '{a[$2]+=1};END{for(i in a){print \"ANY\" \",\" i \",\" \",\" a[i] \",\" \",\" \"'\$log'\"}}' $logtemp> $logtemp1\n";
$strend .="\$b -n -t, -k4 $logtemp1|\$c -n10 >>$logip10\n";
$strend .="x=0\n";                                                    
$strend .="while [ \$x -le 100 ]\n";                                     
$strend .="do\n";                                                     
$strend .="x=$((x+1))\n";                                             
$strend .="url=` grep ANY $logdns10|sed -n ''\$x'p'|awk -F ',' '{print $3}'`\n";
$strend .="echo \$url\n";
$strend .="awk '/^'\$url'/' $logtemp>$logtemp2\n";
$strend .="awk '{a[$2]+=1}END{for(i in a) print a[i]\",\" \"ANY,\" i \",\" \"'\$url'\" \",\" \"'\$log'\"}' $logtemp2 | sort -n|tail -n10>> $logurl\n";
$strend .="done\n";

$strend .="rm $logtemp\n";
$strend .="rm $logtemp1\n";

$strend .="tm=`date +%y%m`\n";
$strend .="dm=`date +%y%m --date=\"-1 day\"`\n";
$strend .="if [ \$tm -ne \$dm ];then\n";
$strend .="tm=\$dm\n";
$strend .="fi\n";

$strend .="echo -e \"create table IF NOT EXISTS dns\$tm(server,ip,domain,ipn int,domn int,time);\">$logim\n";
$strend .="echo -e \".separator \\\",\\\"\" >> $logim\n";
$strend .="echo -e \".import $logip10 dns\$tm\" >>$logim\n";
$strend .="echo -e \".import $logdns10 dns\$tm\" >>$logim\n";

$strend .="echo -e \"create table IF NOT EXISTS url\$tm(num int, flag varchar(10), ip varchar(30), domain varchar(30),time);\" >> $logim\n";
$strend .="echo -e \".import $logurl url\$tm\" >> $logim\n";

$strend .="cat $logim | $sqlite3 $dnsdb\n";
$strend .="#rm -f $logim\n";
$strend .="rm -f $logdns10\n";
$strend .="rm -f $logip10\n";
$strend .="rm -f $logtemp2\n";
$strend .="rm -f $logurl\n";
$strend .="rm -f $logover\n";
$timesh = $timesh.$strend;

writeFile($logtimesh, $timesh);

system("chmod +x ".$logtimesh);    
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>DNS设置</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<script src="/js/jquery.js"></script>
<script src="/js/ximo_dns.js"></script>
<script language="javascript">

function checklogin(){
	var regipd=/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\/(\d|1\d|2\d|3[0-2])$/;
	var regip=/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
	if(document.setdns.dnsname.value == ''){	
			alert("请输入DNS名");
			document.setdns.dnsname.select();
			return false;
		}
		if(document.setdns.dnsdomain.value == ''){	
			alert("请输入DNS域名");
			document.setdns.dnsdomain.select();
			return false;
		}
		if(document.setdns.dnsip.value == ''){	
			alert("请输入DNSip");
			document.setdns.dnsip.select();
			return false;
		}
		else
	    {
		 if(!checkip(document.setdns.dnsip.value) && !checkipv6(document.setdns.dnsip.value))
		  {
			alert("输入的IP格式不正确！");
		    document.setdns.dnsip.select();
			return false;
		   }
	    }
	
		if(document.setdns.dnskey.value == ''){	
			alert("请输入DNS密钥");
			document.setdns.dnskey.select();
			return false;
		}
		if(document.setdns.dnsadmin.value == ''){	
			alert("请输入DNS管理员");
			document.setdns.dnsadmin.select();
			return false;
		}
		if(document.setdns.dnsdatebase.value == ''){	
			alert("请输入DNS缓存大小");
			document.setdns.dnsdatebase.select();
			return false;
		}else if(!checkInt(document.setdns.dnsdatebase.value) || document.setdns.dnsdatebase.value<=0){
			alert("输入的DNS缓存大小不合法");
			document.setdns.dnsdatebase.select();
			return false;
		}
		if(_g("dnssecip").value!=""){
		  var ip_array=_g("dnssecip").value.split(";");
		  for(var i=0;i<ip_array.length;i++){
			  if(!regipd.test(ip_array[i]) && !regip.test(ip_array[i])){
				  alert("输入的允许使用地址的格式不正确！");
				  _g("dnssecip").select();
				  return false;
			  }
		  }
		}
		if(_g("dnsthirdip").value!=""){
		  var ip_array=_g("dnsthirdip").value.split(";");
		  for(var i=0;i<ip_array.length;i++){
			  if(!regipd.test(ip_array[i]) && !regip.test(ip_array[i])){
				  alert("输入的允许递归查询地址的格式不正确！");
				  _g("dnsthirdip").select();
				  return false;
			  }
		  }
		}
		if(document.setdns.dnsrefresh.value == ''){	
			alert("请输入refresh");
			document.setdns.dnsrefresh.select();
			return false;
		}else if(!checkInt(document.setdns.dnsrefresh.value) || document.setdns.dnsrefresh.value<=0){
			alert("输入的refresh不合法");
			document.setdns.dnsrefresh.select();
			return false;
		}
		if(document.setdns.dnsretry.value == ''){	
			alert("请输入retry");
			document.setdns.dnsretry.select();
			return false;
		}else if(!checkInt(document.setdns.dnsretry.value) || document.setdns.dnsretry.value<=0){
			alert("输入的retry不合法");
			document.setdns.dnsretry.select();
			return false;
		}
		if(document.setdns.dnsexpire.value == ''){	
			alert("请输入expire");
			document.setdns.dnsexpire.select();
			return false;
		}else if(!checkInt(document.setdns.dnsexpire.value) || document.setdns.dnsexpire.value<=0){
			alert("输入的expire不合法");
			document.setdns.dnsexpire.select();
			return false;
		}
		if(document.setdns.dnsttl.value == ''){	
			alert("请输入ttl");
			document.setdns.dnsttl.select();
			return false;
		}else if(!checkInt(document.setdns.dnsttl.value) || document.setdns.dnsttl.value<=0){
			alert("输入的ttl不合法");
			document.setdns.dnsttl.select();
			return false;
		}
	return true;
}
function isEmail(str){ 
res = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/; 
var re = new RegExp(res); 
return !(str.match(re) == null); 
} 
function   checktelphone(str){   
  res   =   /^(([0\+]\d{2,3}-)?(0\d{2,3})-)?(\d{7,12})(-(\d{3,}))?$/  ;  
 var re=new RegExp(res);
 return !(str.match(re)==null);
  }
</script>
</head>

<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; DNS设置</div>


      <div class="content">
	  <form id="setdns" name="setdns" method="post" action="setdns.php" onsubmit="return checklogin();">
	  <table width="768" class="s s_form">
        <tr>
          <td colspan="2"class="caption">DNS设置</td>
        </tr>
         <tr>
          <td>注册的DNS名称：</td>
          <td>
            <input name="dnsname" type="text" id="dnsname" size="10" value="<?echo $row['dnsname']?>" />
          .
          <input name="dnsdomain" type="text" id="dnsdomain" value="<?echo $row['dnsdomain']?>" />
          </td>
        </tr>
        <tr>
          <td>注册的DNS IP：</td>
          <td>
            <input name="dnsip" type="text" id="dnsip" value="<?echo $row['dnsip']?>" size="30" />
          </td>
        </tr>
        <tr>
          <td>域管理员邮箱：</td>
          <td>
            <input name="dnsadmin" type="text" id="dnsadmin" value="<?echo $row['dnsadmin']?>" />
          因为@代表特殊意义，所以用.代替@，如root@domain.com改为root.domain.com</td>
        </tr>
        <tr>
          <td>DNS服务器密钥：</td>
          <td>
            <input name="dnskey" type="text" id="dnskey" size="50" value="<?echo $row['dnskey']?>" />
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td class="redtext"> 当设置为辅控DNS服务器或者从DNS服务器时，才需要填写</td>
        </tr>
        <tr>
          <td>缓存数据库大小：</td>
          <td>
            <input name="dnsdatebase" type="text" id="dnsdatebase" size="10" value="<?echo $row['dnsdatebase']?>" />
          M <span class="redtext">(缓存服务器时需要填写) </span></td>
        </tr>
         <tr>
          <td>&nbsp;</td>
          <td>当为转发服务器和从服务器时需要填写</td>
        </tr>
        <tr>
           <td> 允许使用地址：</td>
           <td>
             <input name="dnssecip" type="text" id="dnssecip" value="<?echo $row['dnssecip']?>" size="60" />
           </td>
         </tr>
         <tr>
           <td>&nbsp;</td>
           <td class="redtext">当允许所有能使用本DNS则为空,否则每个ip或ip段以;号隔开</td>
         </tr>
         <tr>
           <td>允许递归查询地址：</td>
           <td>
             <input name="dnsthirdip" type="text" id="dnsthirdip" value="<?echo $row['dnsthirdip']?>" size="60" />
           </td>
         </tr>
         <tr>
           <td>&nbsp;</td>
           <td class="redtext">当允许所有时为空，否则每个ip或ip段以;号隔开 </td>
         </tr>
         <tr>
          <td>Refresh：</td>
          <td>
            <input name="dnsrefresh" type="text" id="dnsrefresh" size="14" value="<?echo $row['dnsrefresh']?>" />
            秒
          辅助域名服务多长时间更新数据
          </td>
        </tr>
         <tr>
           <td>Retry：</td>
           <td>
             <input name="dnsretry" type="text" id="dnsretry" size="14" value="<?echo $row['dnsretry']?>" />
           秒 若辅助域名服务器更新失效再次更新时间</td>
         </tr>
         <tr>
           <td>Expire：</td>
           <td>
             <input name="dnsexpire" type="text" id="dnsexpire" size="14" value="<?echo $row['dnsexpire']?>" />
           秒 若辅助域名服务器无法从主域名服务器获得数据多长时间原数据失效 </td>
         </tr>
         <tr>
           <td>Minimum：</td>
           <td>
             <input name="dnsttl" type="text" id="dnsttl" size="14" value="<?echo $row['dnsttl']?>" />
           秒 若资源记录里没有设置TTL值，则以这里为准 </td>
         </tr>        
        
        <tr>
          <td colspan="2" class="footer">
            <input type="submit" name="Submit" value="保存设置" />
          </td>
        </tr>
      </table>
	  </form>
	  </div>
 
<?$db->close();?></div><div class="push"></div>
<? include "../copyright.php";?>
</body>
</html>
