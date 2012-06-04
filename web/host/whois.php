<? include ('../include/comm.php');
checklogin();
checkac();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>WHOIS查询</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.s td.bluebg{background:#e7f4ff; text-align:left;}
</style>

<script language="javascript">
 
function checklogin()
{
	if(document.whois.whoisname.value == '')
	{
		alert("请输入WHOIS的域名或IP");
		document.whois.whoisname.focus();
		return false;
	}
	else
	{
		
		if(!checkIp(document.whois.whoisname.value))
			{
				alert("输入的域名或IP格式不正确！");
		        document.whois.whoisname.select();
		        return false;
		}
	}
	return true;
}
function checkIp(ip)
{
	var reg = /^\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b$/; 
	var ipv6 = /^([\da-fA-F]{1,4}:){6}((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^::([\da-fA-F]{1,4}:){0,4}((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^([\da-fA-F]{1,4}:):([\da-fA-F]{1,4}:){0,3}((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^([\da-fA-F]{1,4}:){2}:([\da-fA-F]{1,4}:){0,2}((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^([\da-fA-F]{1,4}:){3}:([\da-fA-F]{1,4}:){0,1}((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^([\da-fA-F]{1,4}:){4}:((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^([\da-fA-F]{1,4}:){7}[\da-fA-F]{1,4}$|^:((:[\da-fA-F]{1,4}){1,6}|:)$|^[\da-fA-F]{1,4}:((:[\da-fA-F]{1,4}){1,5}|:)$|^([\da-fA-F]{1,4}:){2}((:[\da-fA-F]{1,4}){1,4}|:)$|^([\da-fA-F]{1,4}:){3}((:[\da-fA-F]{1,4}){1,3}|:)$|^([\da-fA-F]{1,4}:){4}((:[\da-fA-F]{1,4}){1,2}|:)$|^([\da-fA-F]{1,4}:){5}:([\da-fA-F]{1,4})?$|^([\da-fA-F]{1,4}:){6}:$/;
	
    var url= /^(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/;
	if (!reg.test(ip) && !url.test(ip) && !ipv6.test(ip)) { 
		
	return false; 
	} 
	return true; 
}
</script>
</head>

<body>
<div class="wrap">
  <div class="nav">&nbsp;当前位置:&gt;&gt; WHOIS查询</div>
   <div class="content">
<form id="whois" name="whois" method="get" action="whois.php" onsubmit="return checklogin()">
      <table width="768" class="s s_form">
        <tr>
          <td class="caption" colspan="4">WHOIS查询</td>
        </tr>
   
      
            <tr>
              <td width="20%" class="bluebg">请输入WHOIS的域名或IP：</td>
              <td width="27%" class="bluebg"><label>
                <input name="whoisname" type="text" id="whoisname" value="<?echo $_GET['whoisname']?>" size="30" />
              </label></td>
              <td width="25%" class="bluebg">只能输入字母和数字 .和- </td>
              <td width="28%" class="bluebg"><label>
                <input type="submit" name="Submit" value="提交" />
              </label></td>
           
        </tr>
        <tr>
         
              <td  colspan="4"><?
          if($_GET['whoisname']!=''){
             checkac('应用'); 
          	/*$valid_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-_.";
          	if ( strspn($_GET['whoisname'], $valid_chars ) != strlen($_GET['whoisname']) )
				{
						showmessage("对不起，您输入的查询内容不合法！",'whois.php');
				}*/
		  exec( $whoiscmd." ".$_GET['whoisname'], &$whoisResult );
				$whoisResult = join( "<br>", $whoisResult );
				if ( eregi( "[*\\.cn]\$", $name ) )
				{
						$whoisResult = iconv( "UTF-8", "GBK", $whoisResult );
						

				}
				$whoisResult = iconv( "utf8", "GB18030", $whoisResult );
				writelog($db,'WHOIS查询','whois查询：'.$_GET['whoisname']);
				if($whoisResult!=''){
				echo $whoisResult;
				}else
				{echo "查询无结果";}
				}else
				{ echo "请输入WHOIS的域名或IP";} ?></td>
            </tr>         
      </table>
        </form>
 </div>
<?$db->close();?><div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
 