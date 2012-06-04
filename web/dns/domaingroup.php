<?
/***********************域名批量转发**************
*把需要批量转发的域名和转发的地址序列化后保存在domain_group文件里。
*在应用域名时把数据取出来放到脚本中
*域名不能重复。
**/
include ('../include/comm.php');
checklogin();
checkac();
//$domaingroup_conf="domain_group";//数据储存文件
/**************处理表单提交********************/
if(isset($_POST['Submit'])){
	checkac('修改');
	//数据安全验证:验证domain的重复
	$domain=array();
	$sql="select domainname from domain";
	$rs=$db->query($sql);
	while($v=$db->fetch($rs))
	{
	$domain[]=$v["domainname"];
	}
	//上面的为数据库中的域名，下面合并表单中的域名
	foreach($_POST["domain"] as $row)
	{
	$domain=array_merge($domain,explode(";",$row));
	}
	$domain_count=array_count_values($domain);
	foreach($domain_count as $k=>$v)
	{
	if($v==1)continue;
	$double_domain[$k]=$v;
	}
	if(count($double_domain))
	{
	showmessage('域名重复\n'.implode("\n",array_keys($double_domain)),2);
	}
	//保存数据
	$domainA=array();
	foreach($_POST["domain"] as $k=>$v){
		 if(trim($v)==""||trim($_POST["ip"][$k])=="")continue;
		 $domainA[]=array($v,trim($_POST["ip"][$k]),$_POST["state"][$k]);
	}
	file_put_contents($domaingroup_conf,serialize($domainA));
	$db->close();
	showmessage('域名转发设置成功!','domaingroup.php');
}
/*************表单初始数据******************/
$row =unserialize(file_get_contents($domaingroup_conf));//取出数据 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>域名转发管理</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style>
textarea{width:668px;height:100px;}
.error{border-color:red;}
.input{width:668px;height:25px;}
td{padding:0;}
</style>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>

<script src="../js/jquery.js"></script>
<script language="javascript">
var error=false;
function checkdomain(value){
if(value==""){error="要转发的域名不能为空";return false;}
if(value.lastIndexOf("\n")!=-1){error="不能有换行符！";return false;}
var valueA=value.split(";");
for(i in valueA){
if(!checkurl(valueA[i])){
error="域名格式不正确:"+valueA[i];
return false;
}
}//end for
return true;}

function checkmyip(value){
if(value==""){error="转发地址不能为空";return false;}
var valueA=value.split(";");
for(i in valueA){
if(!checkip(valueA[i])&&!checkipv6(valueA[i])){
error="转发地址格式不正确:"+valueA[i];
return false;
}
}//end for
return true;}//end ip check
$(function(){
	var iii=0;
	$("input[value='删除']").each(function(i,n){
		iii++;
		});
	if(iii==1 && $("textarea[name='domain[]']").val()==""){
		$("input[value='删除']").attr("disabled",true);
	}
$("#setip").submit(function(){
 var textarea_A=document.domain["domain[]"];
//if(textarea_A==undefined){alert("没有要提交的内容");return false;}
if(textarea_A.length==undefined)textarea_A=[textarea_A];
 for(ii in textarea_A){
 if(checkdomain(textarea_A[ii].value))continue;
 alert(error);$(textarea_A[ii]).addClass("error");return false;
}
  var ip_A=document.domain["ip[]"];
if(ip_A.length==undefined)ip_A=[ip_A];
 for(ii in ip_A){
 if(checkmyip(ip_A[ii].value))continue;
 alert(error);$(ip_A[ii]).addClass("error");return false;
}
  return true;
});
});
function rmerror(obj)
{
$(obj).removeClass("error");
}
function addif(){
var html="<tbody>";
     html+="   <tr>";
      html+="     <td class=\"title\">要转发的域名:</td>";
     html+="     <td> <textarea name=\"domain[]\" onfocus=\"rmerror(this)\" ></textarea></td>";
      html+=" </tr>";
       html+="<tr> <td class=\"title\">转发至:</td>";
    html+="       <td ><input name=\"ip[]\" class=\"input\"onfocus=\"rmerror(this)\"></td>";
     html+=" </tr>";
      html+="   <tr>";
       html+="   <td class=\"title\">状态:</td>";
       html+=" <td ><select name=\"state[]\"><option  value=\"1\" >开启</option> <option value=\"0\">停用</option></select><input type=\"button\" value=\"删除\" onclick=\"if(!confirm('确实要删除本条记录吗？')){return;}$(this).parent().parent().parent().remove();\">";
        html+="</tr>";  
      html+="    </td>";
       html+=" </tbody>";
$(html).appendTo("#if");
}
</script>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 域名设置 </div>
<ul class="tab-menu">    
    <li><a href="domain.php">域名管理</a></li>
	<li><a href="domain_add.php">域名添加</a></li>
    <li class="on"><span>域名转发管理</span></li>
	<li><a href="domain_input.php">批量导入</a></li>
    <li><a href="domain_output.php">域名导出</a></li>
	<!--li><a href="checkzone.php">检测域名记录</a></li-->
    <li><a href="domain.php?ac=app">应用设置到系统</a></li>   
</ul>
<div class="content">
    <form id="setip" name="domain" method="post"  onsubmit=""> 
      <table id="if" width="768"  align="center"class="s s_form">
         <tr>
          <td colspan="2" class="caption"> 域名转发管理</td>
        </tr>       
        <tr><td height="25" colspan="2"bgcolor="#FFFFFF"class="redtext">多个dns或域名用英文“;”分隔,dns不能重复,保存后需应用设置到系统才能起效。</td></tr>
        <?php 
               if(is_array($row)&&count($row))foreach($row as $k=>$v){
        ?>
        <tbody>
        <tr>
           <td >要转发的域名:</td>
          <td> <textarea name="domain[]" onfocus="rmerror(this)"><?=$v[0];?></textarea></td>
       </tr>
       <tr> <td>转发至:</td>
           <td ><input name="ip[]" class="input"value="<?=$v[1];?>"onfocus="rmerror(this)"></td>
      </tr>
         <tr>
          <td>状态:</td>
        <td ><select name="state[]"><option  value="1" >开启</option> <option value="0" <?=$v[2]==0?"selected":""?>>停用</option></select><input type="button" value="删除" onclick="if(!confirm('确实要删除本条记录吗？')){return;}$(this).parent().parent().parent().remove();">
          </td>
        </tr>  
        </tbody>
 
<?php }else{?>
        <tbody>
        <tr>
           <td>要转发的域名:</td>
          <td> <textarea name="domain[]"onfocus="rmerror(this)"></textarea></td>
       </tr>
       <tr> <td >转发至:</td>
           <td ><input name="ip[]" class="input"onfocus="rmerror(this)"></td>
      </tr>
         <tr>
          <td>状态:</td>
        <td ><select name="state[]"><option  value="1" >开启</option> <option value="0">停用</option></select><input type="button" value="删除"  onclick="if(!confirm('确实要删除本条记录吗？')){return;}$(this).parent().parent().parent().remove();">
 
          </td>
        </tr>  
        </tbody>
<?}?>
             </table>
       <div class="t_c"> <input type="button" onclick="addif();"value="添加"/>
          	<input type="submit" name="Submit" value="保存设置" /> </div>
      </form></div><!--content--> 
<div class="push"></div></div>
<?$db->close();?>
<? include "../copyright.php";?>
</body>
</html>
