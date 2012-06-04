<?php
include ('../include/comm.php');
checklogin();
checkac();
if(isset($_GET["ac"])&&$_GET["ac"]=="query"){
if(isset($_POST["domain"])){
$data=explode("\n",$_POST["domain"]);
foreach($data as $k=>$v){
$data[$k]=$v." A";
}
$data=implode("\n",$data);
file_put_contents("/xmdns/sh/queryperf/test",$data);
$result=$db->fetch($db->query("select dnsip from setdns"));
if($result["dnsip"]==$_GET["ip"]){
exec("/xmdns/sh/queryperf/query.sh ".$result["dnsip"],$info,$error);//查询一次，保障本机dns性能最优
}
}
exec("/xmdns/sh/queryperf/query.sh ".$_GET["ip"],$info,$error);
$info=pos($info);
if($error&&preg_match("/Error/i",$info)){
die("{error:true}");
}else{
die(json_encode(explode(" ",$_GET["ip"]." ".$info)));
}}elseif(isset($_FILES["file"])&&($_FILES["file"]["type"] == "application/octet-stream"||$_FILES["file"]["type"] == "text/plain")&&$data=file($_FILES['file']['tmp_name'])){
  $domain_reg="/^([\w-]+\.)+((com)|(net)|(org)|(gov\.cn)|(info)|(cc)|(com\.cn)|(net\.cn)|(org\.cn)|(name)|(biz)|(tv)|(cn)|(mobi)|(name)|(sh)|(ac)|(io)|(tw)|(com\.tw)|(hk)|(com\.hk)|(ws)|(travel)|(us)|(tm)|(la)|(me\.uk)|(org\.uk)|(ltd\.uk)|(plc\.uk)|(in)|(eu)|(it)|(jp))$/";
  foreach($data as $k=>$v)
  {
  $v=trim($v);
  if(!preg_match($domain_reg,$v)){
  die('上传域名第'.($k+1)."有错误！".$v);
  }
  $data[$k]=$v." A";
  }
  $data=implode("\n",$data);
  file_put_contents("/xmdns/sh/queryperf/test",$data);
  $result=$db->fetch($db->query("select dnsip from setdns"));
  exec("/xmdns/sh/queryperf/query.sh ".$result["dnsip"],$info,$error);//查询一次，保障本机dns性能最优
  $upload=true;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>dns性能测试</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style>
td.color{background:#E7F4FF;}
#input1,#input2{width:100%;height:300px;}
</style>
<script src="/js/jquery.js"  type="text/javascript"charset="utf-8" ></script>
<script language="javascript">
$(function(){
init_query();
})
var ip,domin,N_RegExp=/\r?\n/;
var ip_reg= /^\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b$/; 
var domain_reg=/^([\w-]+\.)+((com)|(net)|(org)|(gov\.cn)|(info)|(cc)|(com\.cn)|(net\.cn)|(org\.cn)|(name)|(biz)|(tv)|(cn)|(mobi)|(name)|(sh)|(ac)|(io)|(tw)|(com\.tw)|(hk)|(com\.hk)|(ws)|(travel)|(us)|(tm)|(la)|(me\.uk)|(org\.uk)|(ltd\.uk)|(plc\.uk)|(in)|(eu)|(it)|(jp))$/;
var input_hide=function(){
   var real=arguments[0]?true:false;
   $("#input1").attr("disabled",real);
   $("#input2").attr("disabled",real);
   $("#check").attr("disabled",real);
}
var query_handler=function(data){
   var html='<tr><td>'+data[0]+'</td><td>'+data[1]+'</td><td>'+data[3]+'</td><td>'+data[2]+'</td><td>'+data[4]+'</td></tr>';
   $("#query_result").append(html);
   if(ip.length){
   $.getJSON("?ip="+ip.shift()+"&ac=query&datetmp="+new Date().getTime(),function(data){query_handler(data);});
   }else{
    input_hide(false);
   }   
}
var test=function(){
    var error;
    $("#query_result").empty();
    ip=$("#input1").attr("disabled",true).val().split(N_RegExp);
	domain=$("#input2").attr("disabled",true).val().split(N_RegExp);
	if(!ip[0]||(!domain[0]&&!$("#file").val())){
　　error="请输入要查询的dns和域!";
	}else if(ip.length>100){
	error="dns输入过多！";
	}else if(domain.length>1000&&!$("#file").val()){
	error="域名超过1000个，请用文本上传！";
	}
	if(error){
	alert(error);
    input_hide(false);
	return;
	}
	for(i=0;i<ip.length;i++){
	if(!ip_reg.test(ip[i])){
	alert("dns第"+(i+1)+"行有错误！");
    input_hide(false);
	return;
	}
	}
	if($("#file").val()){
	input_hide(false);
	document.autoupdate.submit();
	return;
	}
	for(i=0;i<domain.length;i++){
	if(!domain_reg.test(domain[i])){
	alert("域名第"+(i+1)+"行有错误！");
    input_hide(false);
	return;
	}
	}
	domain=domain.join("\n");
	$.post("?ip="+ip.shift()+"&ac=query&datetmp="+new Date().getTime(),{domain:domain},function(data){query_handler(data);},"json")
}
var init_query=function(){
<?=$upload?"":"return;"?>
$("#check").attr("disabled",true);
ip=$("#input1").attr("disabled",true).val().split(N_RegExp);
if(!ip[0]){input_hide(false);return;}
if(ip.length){
   $.getJSON("?ip="+ip.shift()+"&ac=query&datetmp="+new Date().getTime(),function(data){query_handler(data);});
   }else{
    input_hide(false);
}
}
</script>
</head>

<body>
<div class="wrap">
			<div class="position">当前位置：系统工具 >> dns性能测试</div>
<div class="content">
<form id="autoupdate" name="autoupdate" method="post" enctype="multipart/form-data">

      <table width="768" class="s s_form">
        <tr>
          <td colspan="2" class="caption">dns性能测试</td>
        </tr>
         <tr>
            <td  class="color">被测试的dns（格式ip）</td> 
            <td class="color">用来测试dns的域：</td> 
         </tr>
　　　　<tr><td><textarea id="input1" name="input1"><?=$_POST["input1"]?></textarea></td><td><textarea id="input2" name="input2"></textarea></td>		 
         <tr>
         <td class="footer" colspan="2"> 
               <input type="file" name="file" id="file"/>&nbsp;&nbsp;<input type="button" class="button" name="check" id="check" value="测试" onclick="test();"/>
            </td>
            </tr></table></form> &nbsp; 
      <table  width="768" class="s s_grid" border="0" align="center" cellpadding="2" cellspacing="1" >
      <tr bgcolor="#F7FFE8">
             <th width="61" height="25" align="center">被测dns</th>
             <th width="203" align="center">查询次数</th>
             <th width="286" align="center">成功率</th>
             <th width="197" align="center">平均延时</th>
             <th width="81" align="center">每秒解释次数</th>
      </tr>
      <tbody id="query_result">
      </tbody>      
	</table>
</div><div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>