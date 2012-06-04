<?php
/*
 +-----------------------------------------------------
 * 	2010-2-3
 +-----------------------------------------------------
 *		
 +-----------------------------------------------------
 */

include '../include/comm.php';
checklogin();
checkac();
if (isset($_POST['Submit'])){
	$sql = "select count(*) as num from drecord where dname='".$_POST['domain2']."' and dvalue='".$_POST['ip']."'";
	$num = $db->fetchAssoc($db->query($sql));
	if ($num['num'] > 0){
		showmessage('记录已存在!','mode.php?id='.$_POST['id']);
	}
	$sql = "update regroom set domain2='".$_POST['domain2']."',rtype='".$_POST['rtype']."',ip='".$_POST['ip']."',com='".$_POST['com']."',ownner='".$_POST['ownner']."',beizhu='".$_POST['beizhu']."' where id=".$_POST['id'];
	$db->query($sql);
	$top=$_POST['id'];
	for($i=0;$i<count($_POST['ips']);$i++)
	{
		if(!$_POST['ips'][$i]=="")
		{
			$db->query("update aclips set ip='".$_POST['ips'][$i]."' where aclid=".$_POST['ids'][$i]." and regroom=".$top." and status=0");
		}else{
			$db->query("update aclips set ip='".$_POST['ip']."' where aclid=".$_POST['ids'][$i]." and regroom=".$top." status=0");
		}
		
	}
	showmessage('保存成功!','app.php');
}
if (isset($_GET)){
    $id = $_GET['id'];
    $sql = "select * from regroom where id = $id";
    $row = $db->fetchAssoc($db->query($sql));
    
    $sq = "select * from domain where domainid=".$row['doid'];
	$r = $db->fetchAssoc($db->query($sq));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>记录添加设置</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style>
.title{background:#e7f4ff; width:25%; text-align:right;}
</style>
<script src="/js/jquery.js"  type="text/javascript"charset="utf-8" ></script>
<script src="/js/ximo_dns.js"  type="text/javascript" charset="utf-8"></script>

<script language="javascript">

function checklogin(){
	if(!regExp.hostname.test(_g("domain2").value)){
	  	alert("请输入正确的域名名称");
	  	document.record.domain2.select();
	  	return false;
	}
	if(document.record.ip.value ==''){
	  	alert("请输入IP");
	  	document.record.ip.select();
	  	return false;
	}
	var ips_array=$("input.ips");
	for(i=0;i<ips_array.length;i++){
	    if(!ips_array[i].value)continue;
		if(document.record.rtype.value=='A')
		{
			if ( !checkip(ips_array[i].value))
			{ 
				alert("输入的IPV4格式不正确！");
				ips_array[i].focus();
			  return false;
			 }
		}else if(document.record.rtype.value=='AAAA' || document.record.rtype.value=='A6' ){
		    ips_array[i].value=ips_array[i].value.toUpperCase();
			if ( !checkipv6(ips_array[i].value))
			{ 
				alert("输入的IPV6格式不正确！");
				ips_array[i].focus();
			  return false;
			}
		}
		
	};
	if(document.record.com.value ==''){
	  	alert("请输入申请单位");
	  	document.record.com.select();
	  	return false;
	}else{
		if(!checkname(document.record.com.value)){
				alert("申请单位只能输入汉字，数字，字母，下划线！");
				document.record.com.select();
				return false;
			}
	}	
	if(document.record.ownner.value ==''){
	  	alert("请输入申请人");
	  	document.record.ownner.select();
	  	return false;
	}else{
		if(!checkname(document.record.ownner.value)){
				alert("申请人只能输入汉字，数字，字母，下划线！");
				document.record.ownner.select();
				return false;
			}
	}
	
	if(!document.record.beizhu.value ==''){
		if(!checkname(document.record.beizhu.value)){
				alert("只能输入汉字，数字，字母，下划线！");
				document.record.beizhu.select();
				return false;
			}
	}
	return true;
}

function shows()
{
	
	if($("#aa").attr("alt")==0)
	{
		$(".hid").show();
		$("#aa").attr("alt",1);
	}else{
		$(".hid").hide();
		$("#aa").attr("alt",0);
	}
	
}

</script>
</head>

<body>
<div class="wrap">
<div class="content">
<form id="record" name="record" method="post" action="mode.php" onsubmit="return checklogin();">
<table width="600"  class="s s_form">      
        <tr>
          <td colspan="2" class="caption">域名绑定申请修改</td>
        </tr>
       
            <tr>
              <td>域名名称：</td>
              <td>
                <input name="domain2" type="text" id="domain2" size="6" value="<?php echo $row['domain2']?>" /> .<?php echo $r['domainname'];?>
				<input name="domainid" type="hidden" id="domainid" value="<?php echo $r['domainid']?>" />
              </td>
            </tr>
       
            <tr>
              <td>记录类型：</td>
              <td>
                <select name="rtype" id="rtype">
					<option <?php if($row['rtype']=="A")echo "selected" ;?> value="A">A</option>
					<option <?php if($row['rtype']=="AAAA")echo "selected" ;?> value="AAAA">AAAA</option>
                </select>
              </td>
            </tr>
			<tr>
              <td>IP(通用)：</td>
              <td>
                <input name="ip" class="ips" type="text" id="ip" value="<?=$row['ip']?>"/> <a href="#" id="aa" onclick="shows()" alt="1">高级</a>
              </td>
            </tr>
			<tbody class="hid" style="">
			<?
			$sql = "select * from aclips where status=0 and regroom=".$row['id'];
			$que=$db->query($sql);
			while($res=$db->fetchAssoc($que))
			{
			?>
            <tr>
              <td>IP(<?php echo $res['aclname']?>)：</td>
              <td>
			    <input type="hidden" name="aclname[]"  id="aclname[]" value="<?php echo $res['aclident']?>">
				<input type="hidden" name="ids[]"  id="ids[]" value="<?php echo $res['aclid']?>">
                <input name="ips[]" type="text"class="ips" value="<?=$res['ip']?>"/>
              </td>
            </tr>		
		<?}?>
			</tbody>
            <tr>
              <td>申请单位：</td>
              <td>
                <input name="com" type="text" id="com" value="<?php echo $row['com'];?>" />
              </td>
            </tr>
            <tr>
              <td>申请人：</td>
              <td>
                <input name="ownner" type="text" id="ownner" value="<?php echo $row['ownner'];?>" />
              </td>
            </tr>
            <tr>
              <td>备注：</td>
              <td>
                <textarea name="beizhu" type="text" id="beizhu"><?php echo $row['beizhu'];?></textarea>
              </td>
            </tr>
          
        <tr>
          <td  colspan="2" class="footer">
			<input type="hidden" name="id" id="id" value="<?=$row['id']?>">
         	<input type="submit" name="Submit" value="保存设置" />&nbsp;&nbsp;
			<input type="button" name="back" value="返  回" onclick="javascript:history.back(-1);"/>
          </td>
        </tr>
      
    </table></form>
	</div><div class="push"></div></div>
<?
$db->close();
include "../copyright.php";
?>
</body>
</html>
