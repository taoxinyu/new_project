<? include ('../include/comm.php');
$pageaccess=2;
checklogin();
checkac();
$page = checkPage();
exec( $rndccmd." status", &$dnsstatus );	
$aa=$dnsstatus;	
$dnsstatus = join( "<br>", $dnsstatus );	
if($dnsstatus!=""){
		$mydns="DNS正常运行中....";
		$dns=1;
}else 
{
	$mydns="DNS已经停止服务....";
	$dns=0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />

<title>DNS状态</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.redtext{color:#d71d1d;}
.yeetext{color:#d71d1d;font-size:14px;line-height:25px;}

</style>
<script src="/js/jquery.js"  type="text/javascript"charset="utf-8" ></script>
<script src="/js/ximo_dns.js"  type="text/javascript" charset="utf-8"></script>
</head>

<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; DNS状态显示</div>
<div class="content">
      <table width="768" class="s">
        <tr>
          <td class="caption">DNS状态显示</td>
        </tr>
        <tr>
          <td>当前DNS服务器状态：<span class="redtext"><?echo $mydns?></span> 
          </td>
        </tr>
        <tr>
          <td><table width="678" height="220" border="0" cellpadding="0" cellspacing="3" bgcolor="#FFFFFF">
            <tr>
              <td width="240" rowspan="2" align="center" class="graytext"><?if($dns==1){?><img src="../images/dnsstatus1.jpg" width="218" height="211" /><?}else{?><img src="../images/dnsstatus4.jpg" width="218" height="211" /><?}?></td>
              <td height="30" align="left" class="graytext">状态信息：</td>
            </tr>
            <tr>
              <td height="190" align="left" valign="top" class="yeetext"><?if($dns==1){
              	$aa[0]=$system['dnstype'].$system['version'];
              	$aa[7]="智能DNS解析服务运行正常.";
              	for($i=0;$i<sizeof($aa)-2;$i++)
              	{
              		echo $aa[$i]."<br>";
              	}
              }else {echo "DNS服务已停止！";}?></td>

            </tr>
          </table>
          </td>
          </tr>
      </table></div>
  
<?$db->close();?></div>
<? include "../copyright.php";?>
</body>
</html>
