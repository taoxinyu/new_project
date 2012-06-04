<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac('修改');
if(isset($_POST['Submit'])){
$sql="update domain set domainname='".$_POST['domainname']."',domainadmin='".$_POST['domainadmin']."',domainsoa='".$_POST['domainsoa'];
$sql=$sql."',domainis='".$_POST['domainis']."',domainisapp='0',domainserial='".$_POST['domainserial']."',domainexpire=".$_POST['domainexpire'];
$sql=$sql.",domainrefresh=".$_POST['domainrefresh'].",domainretry=".$_POST['domainretry'].",domainttl=".$_POST['domainttl'].",domainremarks='".$_POST['domainremarks']."'";
$sql=$sql.",domainupdate=datetime('now','localtime') where domainid=".$_POST['domainid'];
	$db->query($sql);

	writelog($db,'域名管理',"修改域名：".$_POST['domainname']);
		$db->close();
		showmessage('域名修改成功!','domain.php');
		

}else 
{//读取信息
	
		$query=$db->query("select * from domain where domainid=".$_GET['id']);
		$row=$db->fetchAssoc($query);
		
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>日志设置</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style>
.redtext{ color:red;}
.s td.title{width:140px;};
</style>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<script language="javascript">

	function checklogin(){
	    document.domain.domainname.value=document.domain.domainname.value.toLowerCase();
		if(document.domain.domainname.value == ''){	
			alert("请输入域名名称");
			document.domain.domainname.select();
			return false;
		}else {
			if(!checkzheng(document.domain.domainname.value))
			{
				alert("域名名称格式不正确");
				document.domain.domainname.select();
				return false;
			}
		}
		if(document.domain.domainsoa.value == ''){	
			alert("请输入域名SOA");
			document.domain.domainsoa.select();
			return false;
		}
		else {
			if(!checkzheng(document.domain.domainsoa.value))
			{
				alert("域名SOA格式有误");
				document.domain.domainsoa.select();
				return false;
			}
		}
		
		if(document.domain.domainadmin.value == ''){	
			alert("请输入域名管理员");
			document.domain.domainadmin.select();
			return false;
		}
		else {
			if(!checkzheng(document.domain.domainadmin.value))
			{
				alert("域名管理员输入格式有误！");
				document.domain.domainadmin.select();
				return false;
			}
		}
		
			
			
		if(document.domain.domainserial.value == ''){	
			alert("请输入域名serial");
			document.domain.domainserial.select();
			return false;
		}
		else {
			if(!checkInt(document.domain.domainserial.value))
			{
				alert("域名serial输入有误");
				document.domain.domainserial.select();
				return false;
			}
		}
		
		if(document.domain.domainrefresh.value == ''){	
			alert("请输入域名refresh");
			document.domain.domainrefresh.select();
			return false;
		}
		else {
			if(!checkInt(document.domain.domainrefresh.value))
			{
				alert("域名refresh输入有误");
				document.domain.domainrefresh.select();
				return false;
			}
		}
		
		if(document.domain.domainretry.value == ''){	
			alert("请输入域名retry");
			document.domain.domainretry.select();
			return false;
		}
		else {
			if(!checkInt(document.domain.domainretry.value))
			{
				alert("域名retry输入有误");
				document.domain.domainretry.select();
				return false;
			}
		}
		
		if(document.domain.domainexpire.value == ''){	
			alert("请输入域名expire");
			document.domain.domainexpire.select();
			return false;
		}
		else {
			if(!checkInt(document.domain.domainexpire.value))
			{
				alert("域名expire输入有误");
				document.domain.domainexpire.select();
				return false;
			}
		}
		if(!document.domain.domainremarks.value==''){
			var val= /^[\u0391-\uFFE5\w]+$/;
			if(!val.test(document.domain.domainremarks.value)  )
			{
				alert("不允许输入特殊字符！");
				document.domain.domainremarks.select();
				return false;
			}
		
		}
		if(document.domain.domainttl.value == ''){	
			alert("请输入域名TTL");
			document.domain.domainttl.select();
			return false;
		}
		else {
			if(!checkInt(document.domain.domainttl.value))
			{
				alert("域名TTL输入有误");
				document.domain.domainttl.select();
				return false;
			}
		}
		
	return true;
}

</script>
</head>

<body><div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; 域名设置 &gt;&gt; 域名修改</div>
<ul class="tab-menu">	
    <li><a href="domain.php">域名管理</a></li>
	<li class="on"><span>域名修改</span></li>    
    <li><a href="domaingroup.php">域名转发管理</a></li>
	<li><a href="domain_input.php">批量导入</a></li>
    <li><a href="domain_output.php">域名导出</a></li>
	<!--li><a href="checkzone.php">检测域名记录</a></li-->
    <li><a href="domain.php?ac=app">应用设置到系统</a></li>   
</ul>
   
       
       <div class="content">
	   <form id="domain" name="domain" method="post" action="domain_mode.php" onsubmit="return checklogin();">
	      <table width="85%" class="s s_form">
		   <tr>
          <td  colspan="2" class="caption">域名修改</td>
        </tr>
            <tr>
              <td>域名名称：</td>
              <td>
                <input name="domainname" type="text" id="domainname" size="30" value="<?echo $row['domainname']?>" />
              <span class="redtext">格式：ximotech.com 反解为
                <label title="97.138.222.in-addr.arpa" for="d2">97.138.222.in-addr.arpa</label>
                等</span></td>
            </tr>
       
            <tr>
              <td>SOA：</td>
              <td>
                <input name="domainsoa" type="text" id="domainsoa" value="<?echo $row['domainsoa']?>" size="40" />
              </td>
            </tr>
            <tr>
              <td>域名管理员：</td>
              <td><input name="domainadmin" type="text" id="domainadmin" value="<?echo $row['domainadmin']?>" size="40" />
                <input name="domainid" type="hidden" id="domainid" value="<?echo $row['domainid']?>" /></td>
            </tr>
            <tr>
              <td>启用状态：</td>
              <td>
                <input name="domainis" type="radio" value="1" <?if($row['domainis']=='1'){?>checked="checked"<?}?> />
                启用
                <input type="radio" name="domainis" value="0" <?if($row['domainis']=='0'){?>checked="checked"<?}?> />
                停用</td>
            </tr>
            
            <tr>
              <td>Serial：</td>
              <td><input name="domainserial" type="text" id="domainserial" size="15" value="<?echo createserial($row['domainserial']);?>" />
               <?echo $row['domainserial']?> <span class="redtext">* 域名版本序号</span></td>
            </tr>
            <tr>
              <td>Refresh：</td>
              <td><input name="domainrefresh" type="text" id="domainrefresh" size="15" value="<?echo $row['domainrefresh']?>" />
                <span class="redtext">* 秒</span></td>
            </tr>
            <tr>
              <td>Retry：</td>
              <td>
                <input name="domainretry" type="text" id="domainretry" size="15" value="<?echo $row['domainretry']?>" />
                <span class="redtext">* 秒</span></td>
            </tr>
            <tr>
              <td>Expire：</td>
              <td><input name="domainexpire" type="text" id="domainexpire" size="15" value="<?echo $row['domainexpire']?>" />
                <span class="redtext">* 秒</span></td>
            </tr>
            <tr>
              <td>Minimum TTL ：</td>
              <td><input name="domainttl" type="text" id="domainttl" size="15" value="<?echo $row['domainttl']?>" />
                <span class="redtext">* 秒</span></td>
            </tr>
			<tr>
              <td>备注信息：</td>
              <td><input name="domainremarks" type="text" id="domainremarks" size="40" value="<?echo $row['domainremarks']?>" />
              </td>
            </tr>
           <tr>
          <td  colspan="2" class="footer">
          <input type="submit" name="Submit" value="保存设置" />
</td>
        </tr>
          </table>   
         
        
      </form>
 
 <?
      $db->close();?></div><div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
