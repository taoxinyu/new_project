<? include ('../include/comm.php');
$pageaccess=2;
checklogin();
checkac();
$page = checkPage();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>NSLOOKUP查询</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.s td.bluebg{background:#e7f4ff; text-align:left;}
</style>
<script src="/js/jquery.js"  type="text/javascript"charset="utf-8" ></script>
<script src="/js/ximo_dns.js"  type="text/javascript" charset="utf-8"></script>
<script language="javascript">
function checklogin()
{
	if(document.dig.digname.value == '')
	{
		alert("请输入NSLOOKUP的域名");
		document.dig.digname.focus();
		return false;
	}
	else
	{
		if(!checkSpace(document.dig.digname.value))
		{
				alert("输入的域名格式不正确！");
		        document.dig.digname.select();
		        return false;
		}
	}
	

	
	return true;
}
function checkSpace(ip) 
{ 
	var reg = /^\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b$/; 
	var ipv6 = /^([\da-fA-F]{1,4}:){6}((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^::([\da-fA-F]{1,4}:){0,4}((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^([\da-fA-F]{1,4}:):([\da-fA-F]{1,4}:){0,3}((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^([\da-fA-F]{1,4}:){2}:([\da-fA-F]{1,4}:){0,2}((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^([\da-fA-F]{1,4}:){3}:([\da-fA-F]{1,4}:){0,1}((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^([\da-fA-F]{1,4}:){4}:((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^([\da-fA-F]{1,4}:){7}[\da-fA-F]{1,4}$|^:((:[\da-fA-F]{1,4}){1,6}|:)$|^[\da-fA-F]{1,4}:((:[\da-fA-F]{1,4}){1,5}|:)$|^([\da-fA-F]{1,4}:){2}((:[\da-fA-F]{1,4}){1,4}|:)$|^([\da-fA-F]{1,4}:){3}((:[\da-fA-F]{1,4}){1,3}|:)$|^([\da-fA-F]{1,4}:){4}((:[\da-fA-F]{1,4}){1,2}|:)$|^([\da-fA-F]{1,4}:){5}:([\da-fA-F]{1,4})?$|^([\da-fA-F]{1,4}:){6}:$/;
	
	var url = /^(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/;
		
	if (!reg.test(ip) && !url.test(ip) && !ipv6.test(ip)) { 
		
	return false; 
	} 
	return true; 
}
</script>
</head>

<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; NSLOOKUP工具查询</div>

      <div class="content">
	  <form id="dig" name="dig" method="get" action="nslookup.php" onsubmit="return  checklogin()">
	  <table width="768" class="s">
        <tr>
          <td  colspan="7" class="caption">NSLOOKUP工具查询</td>
        </tr>       
            <tr>
              <td width="10%" class="bluebg">请输入内容：</td>
              <td width="20%" class="bluebg">
                <input name="digname" type="text" id="digname" size="20" value="<?echo $_GET['digname']?>" />
             </td>
              <td width="8%" class="bluebg">记录类型：</td>
              <td width="10%" class="bluebg">
                <select name="digtype" id="digtype">
                  <option value="any" <?if($_GET['digtype']=='any'||$_GET['digtype']==''){echo "selected";}?>>any</option>
                  <option value="A" <?if($_GET['digtype']=='A'){echo "selected";}?>>A</option>
				  <option value="A6" <?if($_GET['digtype']=='A6'){echo "selected";}?>>A6</option>
                  <option value="MX" <?if($_GET['digtype']=='MX'){echo "selected";}?>>MX</option>
                  <option value="PTR" <?if($_GET['digtype']=='PTR'){echo "selected";}?>>PTR</option>
                  <option value="SOA" <?if($_GET['digtype']=='SOA'){echo "selected";}?>>SOA</option>
                  <option value="NS" <?if($_GET['digtype']=='NS'){echo "selected";}?>>NS</option>
                  <option value="AAAA" <?if($_GET['digtype']=='AAAA'){echo "selected";}?>>AAAA</option>
                  <option value="CNAME" <?if($_GET['digtype']=='CNAME'){echo "selected";}?>>CNAME</option>
                  <option value="TXT" <?if($_GET['digtype']=='TXT'){echo "selected";}?>>TXT</option>
                </select>
              </td>
              <td width="9%" align="right" class="bluebg">DNS服务器:</td>
              <td width="35%" class="bluebg"><input name="digdns" type="text" id="digdns" size="20" value="<?echo $_GET['digdns']?>" />
                (不填为默认本机)</td>
              <td width="8%" class="bluebg"><input type="submit" name="Submit" value="提交" /></td>
            </tr>
         
        <tr>
          
              <td  colspan="7" align="left"><?
          if($_GET['digname']!=''){
              checkac('应用');
          	
		  exec( $nslookupcmd." -q=".$_GET['digtype']." ".$_GET['digname']." ".$_GET['digdns'], &$whoisResult );
				$whoisResult = join( "<br>", $whoisResult );
				writelog($db,'NSLOOKUP查询','NSLOOKUP查询：'.$_GET['digname'].' 记录类型:'.$_GET['digtype']." 主机:".$_GET['digdns']);
				if($whoisResult!=''){
				echo $whoisResult;
				}else
				{echo "查询无结果";}
				}else
				{ echo "请输入要NSLOOKUP查询的域名或IP";} ?></td>
          
            </td>
          </tr>
      </table></form></div>
        

<?$db->close();?><div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
 