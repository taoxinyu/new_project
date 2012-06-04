<?php
	include("../include/comm.php");
	checklogin();
	checkac();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />

<title>CPU实时监控</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style>
.box_tab{width:708px;margin:10px auto;}
dl.state_panel dt{height:350px;}/***页面状态面板**/
dl.state_panel embed{width:100%;height:100%;}
dl.tab_state_panel dt{border:solid #cecece;border-width:0 1px;height:25px;line-height:25px; text-align:center;}
dl.tab_state_panel dt.ss{border:1px solid #cecece;text-align:left; background-color:#ffffff; line-height:28px;}

dl.tab_state_panel dd embed{width:708px;height:352px;}
.caption{background:url(/images/bg1.jpg);color:#ffffff;height:28px;text-align:center; line-height:28px;}


</style>
</head>

<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; CPU实时监控</div>
<div class="content">
<div class="box_tab box">
	<div class="caption">实时CPU系统负载监控</div>
		<dl class="tab_state_panel">
		<dt class="ss">
		<strong><font color="FF0000">注意:</font></strong></span> 如果您看不到图形，可能您需要安装SVG插件。请下载安装插件：<a href="http://www.adobe.com/svg/viewer/install/" target="_blank">Adobe SVG viewer</a>.
		</dt>
		<dd><embed src="graph_cpu.php" type="image/svg+xml"
                width="708" height="352" pluginspage="http://www.adobe.com/svg/viewer/install/auto" /></dd>		
		
	    </dl>	
	</div>
</div>

      <!--<table width="708" class="s">
        <tr>
          <td class="caption">实时CPU系统负载监控</td>
        </tr>
         
        
        <tr>
		
          <td class="bluebg"><embed src="graph_cpu.php" type="image/svg+xml"
                width="708" height="354" pluginspage="http://www.adobe.com/svg/viewer/install/auto" /></td>
        </tr>
        <tr>
          <td class="footer"><strong><font color="FF0000">注意:</font></strong></span> 如果您看不到图形，可能您需要安装SVG插件。请下载安装插件：<a href="http://www.adobe.com/svg/viewer/install/" target="_blank">Adobe SVG viewer</a>.</td>
        </tr>
      </table>--><div class="push"></div>
</div></div>
<?php  include ("../copyright.php")?>
</body>
</html>
