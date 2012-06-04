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
<title>PING工具使用</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.s td.bluebg{background:#e7f4ff; text-align:left;}
</style>

<script language="javascript">

function checklogin()
{
	if(document.ping.pingname.value == '')
	{
		alert("请输入ping的域名或IP");
		document.ping.pingname.select();
		return false;
	}
	else
	{
		if(!checkSpace(document.ping.pingname.value))
		{
			alert("输入的域名或IP格式不正确！");
			document.ping.pingname.select();
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
 <div class="position">&nbsp;当前位置:&gt;&gt; PING工具使用 </div>
       <div class="content">
	   <form id="ping" name="ping" method="get" action="ping.php" onsubmit="return checklogin()">
	   <table width="768"class="s s_form">
        <tr>
          <td colspan="4" class="caption">PING工具使用</td>
        </tr>
        <tr>
          
              <td width="18%" class="bluebg">请输入ping的域名或IP：</td>
              <td width="59%" class="bluebg"><label>
                <input name="pingname" type="text" id="pingname" size="38" value="<?echo $_GET['pingname']?>" />
              (只能输入字母和数字.和- :) </label></td>
              <td width="14%" class="bluebg"><label>类型：
                <select name="iptype" id="iptype">
                  <option value="1" <? if($_GET['iptype']=='1'||$_GET['iptype']==''){echo "selected";}?>>IPV4</option>
                  <option value="2"  <? if($_GET['iptype']=='2'){echo "selected";}?>>IPV6</option>
                </select>
              </label></td>
              <td width="9%" class="bluebg"><label>
                <input type="submit" name="Submit" value="提交" />
              </label></td>
            </tr>
  
            <tr>
              <td colspan="4" align="left"><?
          if($_GET['pingname']!=''){
              checkac('应用');
          	$valid_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-_.:";
          	if ( strspn($_GET['pingname'], $valid_chars ) != strlen($_GET['pingname']) )
				{
						showmessage("对不起，您输入的查询内容不合法！",'ping.php');
				}
				if($_GET['iptype']=="1"){
		  exec( "$pingcmd -c5 ".$_GET['pingname'], &$ping );
				}
				if($_GET['iptype']=="2"){
		  exec( "$ping6cmd -c5  ".$_GET['pingname'], &$ping );
	
				}
				$ping = join( "<br>", $ping );	
				echo $ping;
				writelog($db,'PING操作','PING：'.$_GET['pingname']);
				}else
				{ echo "请输入ping的域名或IP";} ?></td>
            
          </tr>
      </table></form></div>
        
  
<?$db->close();?></div>
<? include "../copyright.php";?>
</body>
</html>