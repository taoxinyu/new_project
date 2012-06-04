<? include ('../include/comm.php');
checklogin();
checkac();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>traceroute查询</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.s td.bluebg{background:#e7f4ff; text-align:left;}
</style>

<script language="javascript">
 
function checklogin()
{
	if(document.traceroute.tr_ip.value == '')
	{
		alert("请输入traceroute的域名或IP");
		document.traceroute.tr_ip.focus();
		return false;
	}
	
	return true;
}

</script>
</head>

<body>
<div class="wrap">
  <div class="nav">&nbsp;当前位置:&gt;&gt; TRACEROUTE查询</div>
   <div class="content">
<form id="traceroute" name="traceroute" method="get" action="traceroute.php" onsubmit="return checklogin()">
      <table width="768" class="s s_form">
        <tr>
          <td class="caption" colspan="5">TRACEROUTE查询</td>
        </tr>
   
      
            <tr>
              <td width="23%" class="bluebg">请输入traceroute的域名或IP：</td>
              <td width="27%" class="bluebg"><label>
                <input name="tr_ip" type="text" id="tr_ip" value="<?echo $_GET['tr_ip']?>" size="30" />
              </label></td>
              <td width="25%" class="bluebg">只能输入字母和数字 .和- </td>
			   <td width="14%" class="bluebg"><label>类型：
                <select name="iptype" id="iptype">
                  <option value="1" <? if($_GET['iptype']=='1'||$_GET['iptype']==''){echo "selected";}?>>IPV4</option>
                  <option value="2"  <? if($_GET['iptype']=='2'){echo "selected";}?>>IPV6</option>
                </select>
              </label></td>
              <td width="25%" class="bluebg"><label>
                <input type="submit" name="Submit" value="提交" />
              </label></td>
           
        </tr>
        <tr>
         
              <td  colspan="5"><?
          if($_GET['tr_ip']!=''){
             checkac('应用'); 
				if($_GET['iptype']=='1'){
					if(preg_match('/^\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b$/',$_GET['tr_ip']) || preg_match('/[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})$/',$_GET['tr_ip']))
					{
						 exec( "traceroute ".$_GET['tr_ip'], $Result );
					}else{
						showmessage("对不起，您输入的ipv4格式有误！",'traceroute.php');
					}
					
				}else if($_GET['iptype']=='2'){
					if(preg_match('/^([\da-fA-F]{1,4}:){6}((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^::([\da-fA-F]{1,4}:){0,4}((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^([\da-fA-F]{1,4}:):([\da-fA-F]{1,4}:){0,3}((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^([\da-fA-F]{1,4}:){2}:([\da-fA-F]{1,4}:){0,2}((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^([\da-fA-F]{1,4}:){3}:([\da-fA-F]{1,4}:){0,1}((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^([\da-fA-F]{1,4}:){4}:((25[0-5]|2[0-4]\d|[01]?\d\d?)\.){3}(25[0-5]|2[0-4]\d|[01]?\d\d?)$|^([\da-fA-F]{1,4}:){7}[\da-fA-F]{1,4}$|^:((:[\da-fA-F]{1,4}){1,6}|:)$|^[\da-fA-F]{1,4}:((:[\da-fA-F]{1,4}){1,5}|:)$|^([\da-fA-F]{1,4}:){2}((:[\da-fA-F]{1,4}){1,4}|:)$|^([\da-fA-F]{1,4}:){3}((:[\da-fA-F]{1,4}){1,3}|:)$|^([\da-fA-F]{1,4}:){4}((:[\da-fA-F]{1,4}){1,2}|:)$|^([\da-fA-F]{1,4}:){5}:([\da-fA-F]{1,4})?$|^([\da-fA-F]{1,4}:){6}:$/',$_GET['tr_ip']) || preg_match('/[a-zA-Z0-9][-a-zA-Z0-9]{0,62}(\.[a-zA-Z0-9][-a-zA-Z0-9]{0,62})$/',$_GET['tr_ip']))
					{
						 exec( "traceroute6 ".$_GET['tr_ip'], $Result );
					}else{
						showmessage("对不起，您输入的ipv6格式有误！",'traceroute.php');
					}
					
				}
				$Result = join( "<br>", $Result );
				if ( eregi( "[*\\.cn]\$", $name ) )
				{
						$Result = iconv( "UTF-8", "GBK", $Result );
						

				}
				$Result = iconv( "utf8", "GB18030", $Result );
				writelog($db,'TRACEROUTE查询','TRACEROUTE查询：'.$_GET['tr_ip']);
				if($Result!=''){
				echo $Result;
				}else
				{echo "查询无结果";}
				}else
				{ echo "请输入traceroute的域名或IP";} ?></td>
            </tr>         
      </table>
        </form>
 </div>
<?$db->close();?><div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
 