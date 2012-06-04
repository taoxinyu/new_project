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
<title>DIG查询</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.s td.bluebg{background:#e7f4ff; text-align:left;}
.s td.title{background:#ffffff; text-align:left;}
</style>
<script  type="text/javascript"  src="../js/jquery.js" ></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<script language="javascript">
function checkIp(obj)
{
	var exp=/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
    var url= /^(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/;

	return (exp.test(obj)||url.test(obj));
} 
function checklogin()
{
	if(document.dig.digname.value == '')
	{
		alert("请输入DIG的域名或IP");
		document.dig.digname.focus();
		return false;
	}
	else
	{
	
		if(!checkIp(document.dig.digname.value) && !checkipv6(document.dig.digname.value))
			{
				alert("输入的域名或IP格式不正确！");
		        document.dig.digname.select();
		        return false;
		}
	}
	return true;
}
</script>
</head>

<body>
<div class="wrap">
  <div class="position">&nbsp;当前位置:&gt;&gt; DIG工具查询</div>
      <div class="content">
	  <form id="dig" name="dig" method="get" action="dig.php" onsubmit="return checklogin()">
	  <table width="768"  class="s s_form">
        <tr>
          <td class="caption" colspan="4">DIG工具查询</td>
        </tr>
        
            <tr>
              <td width="20%" class="bluebg">请输入DIG的域名或IP：</td>
              <td width="27%" class="bluebg"><label>
                <input name="digname" type="text" id="digname" value="<?echo $_GET['digname']?>" size="30" />
              </label></td>
              <td width="25%" class="bluebg">只能输入字母和数字 .和- </td>
              <td width="28%" class="bluebg"><label>
                <input type="submit" name="Submit" value="提交" />
              </label></td>
            </tr>

            <tr>
              <td colspan="4" class="title"><?
          if($_GET['digname']!=''){
              checkac('应用');
       /*   $valid_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890-_.@ ";
          	if ( strspn($_GET['digname'], $valid_chars ) != strlen($_GET['digname']) )
				{
						showmessage("对不起，您输入的查询内容不合法！",'dig.php');
				}	*/
		  exec( $digcmd." ".$_GET['digname'], &$whoisResult );
				$whoisResult = join( "<br>", $whoisResult );
				writelog($db,'DIG查询','DIG查询：'.$_GET['digname']);
				if($whoisResult!=''){
				echo $whoisResult;
				}else
				{echo "查询无结果";}
				}else
				{ echo "请输入DIG的域名或IP";} ?></td>
            </tr>
          </table></form>
           </div>
        

<?$db->close();?><div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
 