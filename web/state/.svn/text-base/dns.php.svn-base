<? 
include ('../include/comm.php');
checklogin();
checkac();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="refresh" content="300" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="cache-control" content="no-cache" />
<title>DNS解析监控情况</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style>
.box_tab{width:681px;margin:10px auto;}
dl.state_panel dt{height:354px;}/***页面状态面板**/
dl.state_panel embed{width:100%;height:100%;}
dl.tab_state_panel dt{border:solid #cecece;border-width:0 1px;height:25px;line-height:25px; text-align:center;}
dl.tab_state_panel dd{text-align:center;display:none}
dl.tab_state_panel dd.on{display:block;}
dl.tab_state_panel dd img{width:681px;height:354px;}
.caption{background:url(/images/bg1.jpg);color:#ffffff;height:28px;text-align:center; line-height:28px;}
</style>
<script src="/js/jquery.js"  type="text/javascript"charset="utf-8" ></script>
<script src="/js/ximo_dns.js"  type="text/javascript" charset="utf-8"></script>
<script>
$(function(){
  $("input[name='tab']").click(function(){
    $("dd:visible").removeClass("on");
	$("dd").eq($(this).val()).addClass("on")
	.find("img").attr('src',function(){
    return (this.src.indexOf("?")== -1?this.src:this.src.split("?")[0])+"?"+new Date().getTime()});
  });
})
</script>
</head>

<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; DNS解析情况监控</div>
<div class="content">
<div class="box_tab box">
	<div class="caption">DNS解析情况监控</div>
		<dl class="tab_state_panel">
		<dt>
			<input type="radio" name="tab" value="0" checked>六小时监控		
			<input type="radio" name="tab" value="1">一天内监控
			<input type="radio" name="tab" value="2">一周内监控
			<input type="radio" name="tab" value="3">一个月监控
			<input type="radio" name="tab" value="4">一年内监控</dt>
		<dd class="on"><img border="0" alt="bindgraph image 0"  src="../cgi-bin/bindgraph.cgi/bindgraph_0.png"></dd>		
		<dd><img border="0" alt="bindgraph image 1"  src="../cgi-bin/bindgraph.cgi/bindgraph_1.png"></dd>
		<dd><img border="0" alt="bindgraph image 2"  src="../cgi-bin/bindgraph.cgi/bindgraph_2.png"></dd>
		<dd><img border="0" alt="bindgraph image 3"  src="../cgi-bin/bindgraph.cgi/bindgraph_3.png"></dd>
		<dd><img border="0" alt="bindgraph image 4"  src="../cgi-bin/bindgraph.cgi/bindgraph_4.png"></dd>
	    </dl>
	</div>
</div>
</div>
<div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
