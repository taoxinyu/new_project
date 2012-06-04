<?php
	include("../include/comm.php");
	checklogin();
	checkac();
	$query = $db->query("select * from netface order by facename");
	while($row = $db->fetch_array($query)){
	$eths[] = $row['facename'];
	}
	$eth = $eths[0];
	if (isset($_GET['eth'])){
		$eth = $_GET['eth'];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" /> 
<title>上海西默智能流量控制系统-6000型</title> 
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />
<style>
.box_tab{width:681px;margin:10px auto;}
dl.state_panel dt{height:354px;}/***页面状态面板**/
dl.state_panel embed{width:100%;height:100%;}
dl.tab_state_panel dt{border:solid #cecece;border-width:0 1px;height:25px;line-height:25px; text-align:center;}
dl.tab_state_panel dt.ss{border:1px solid #cecece;text-align:left; background-color:#e7f4ff;}
dl.tab_state_panel dd{text-align:center;display:none}
dl.tab_state_panel dd.on{display:block;}
dl.tab_state_panel dd img{width:681px;height:302px;}
.caption{background:url(/images/bg1.jpg);color:#ffffff;height:28px;text-align:center; line-height:28px;}


</style>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
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
<div class="nav">&nbsp;当前位置:&gt;&gt; 接口监控 </div>
<div class="content">
<div class="box_tab box">
	<div class="caption">接口监控</div>
		<dl class="tab_state_panel">
		<dt class="ss">
		网络接口
      <select onchange="window.location='?eth='+this.value">
      <?php
      foreach ($eths as $v){
      ?>
      <option value="<? echo $v?>" <? if ($v == $eth) echo "selected"?> ><? echo $v?></option>
      <? }?>
      </select>
		</dt>
		<dt>
			<input type="radio" name="tab" value="0" checked>一小时
			<input type="radio" name="tab" value="1">六小时
			<input type="radio" name="tab" value="2">一天内
			<input type="radio" name="tab" value="3">一周内
			<input type="radio" name="tab" value="4">一个月
			<input type="radio" name="tab" value="5">一年内</dt>
		<dd class="on"><img src="../hot/traffic/<? echo $eth?>-hour.png"></dd>
		<dd><img src="../hot/traffic/<? echo $eth?>-6h.png"></dd>
		<dd><img src="../hot/traffic/<? echo $eth?>-day.png"></dd>
		<dd><img src="../hot/traffic/<? echo $eth?>-week.png"></dd>
		<dd><img src="../hot/traffic/<? echo $eth?>-month.png"></dd>
		<dd><img src="../hot/traffic/<? echo $eth?>-year.png"></dd>
	    </dl>
	</div>
   <!-- <table width="670" class="s"> 
	  <tr><td class="caption">带宽监控</td></tr>	  
	  <tr><td align="center">网络接口
      <select onchange="window.location='?eth='+this.value">
      <?php
      foreach ($eths as $v){
      ?>
      <option value="<? echo $v?>" <? if ($v == $eth) echo "selected"?> ><? echo $v?></option>
      <? }?>
      </select>
      </td> </tr>
	  <tr><td class="bluebg">一小时内的情况</td></tr>
	  <tr><td><img src="../hot/traffic/<? echo $eth?>-hour.png"></td></tr>  
	  <tr><td> </td> </tr>	  
	  
	  <tr><td class="bluebg">六小时内的情况</td></tr>
	  <tr><td><img src="../hot/traffic/<? echo $eth?>-6h.png"></td></tr>  
	  <tr><td> </td> </tr>
	  
	  <tr><td class="bluebg">一天内的情况</td></tr>
	  <tr><td> <img src="../hot/traffic/<? echo $eth?>-day.png"></td></tr>
	  <tr><td> </td> </tr>
	  
	  <tr><td class="bluebg">一周内的情况</td></tr>
	  <tr><td> <img src="../hot/traffic/<? echo $eth?>-week.png"></td></tr>
	  <tr><td> </td> </tr>
	  
	  <tr><td class="bluebg">一个月内的情况</td></tr>
	  <tr><td> <img src="../hot/traffic/<? echo $eth?>-month.png"></td></tr>
	  <tr><td> </td> </tr>
	  
	  <tr><td class="bluebg">一年内的情况</td></tr>
	  <tr><td> <img src="../hot/traffic/<? echo $eth?>-year.png"></td></tr>
  	</table>
  </td>  
  </tr></table> -->
 
</div>
<div class="push"></div></div>
<? include "../copyright.php";?>
</html> 