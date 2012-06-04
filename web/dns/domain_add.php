<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac('添加');
if(isset($_POST['Submit'])){
	$sql="select * from domain where domainname='".$_POST['domainname']."'";
	$q=$db->query($sql);
	$numb=$db->num_rows($q);
	if($numb>0){
	$db->close();
		showmessage('域名已经存在!','domain.php');
	}else{
	$sql="insert into domain (domainname,domainadmin,domainsoa,domainserial,domainrefresh,domainretry,domainexpire,domainttl,domainis,domainisapp,domainupdate,domainnum,domainremarks)values(";
	$sql=$sql."'".$_POST['domainname']."','".$_POST['domainadmin']."','".$_POST['domainsoa']."',".$_POST['domainserial'].",".$_POST['domainrefresh'];
	$sql=$sql.",".$_POST['domainretry'].",".$_POST['domainexpire'].",".$_POST['domainttl'].",'".$_POST['domainis']."','0',datetime('now','localtime'),0,'".$_POST['domainremarks']."')";
	$db->query($sql);
	
	$id = $db->fetchAssoc($db->query("SELECT domainid FROM domain ORDER BY domainid DESC LIMIT 1"));
	for($i=2;$i<=6;$i++){
		$sql="insert into do_access (role_id,domain_id,privilege_id,status) values($_SESSION[role],$id[domainid],$i,1)";
		$db->query($sql);
	}
	if($_SESSION['role']!=1){
		for($i=2;$i<=6;$i++){
			$sql="insert into do_access (role_id,domain_id,privilege_id,status) values(1,$id[domainid],$i,1)";
			$db->query($sql);
		}
	}

	writelog($db,'域名管理',"添加域名：".$_POST['domainname']);
		$db->close();
		showmessage('域名添加成功!','domain.php');
	}	

}else 
{//读取信息
	
		$query=$db->query("select * from setdns where dnsid=1");
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
<script language="javascript" src="/js/jquery.js"></script>
<script language="javascript" src="/js/ximo_dns.js"></script>
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

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 域名设置 &gt;&gt; 域名添加</div>
<ul class="tab-menu">	
    <li><a href="domain.php">域名管理</a></li>
	<li class="on"><span>域名添加</span></li>    
    <li><a href="domaingroup.php">域名转发管理</a></li>
	<li><a href="domain_input.php">批量导入</a></li>
    <li><a href="domain_output.php">域名导出</a></li>
	<!--li><a href="checkzone.php">检测域名记录</a></li-->
    <li><a href="domain.php?ac=app">应用设置到系统</a></li>   
</ul>
<div class="content">
 <form id="domain" name="domain" method="post" action="domain_add.php" onsubmit="return checklogin();">

          <table width="700"  cellspacing="1"class="s s_form">
		   <tr>
          <td colspan="2"  class="caption">域名添加</td>
        </tr>
            <tr>
              <td >域名名称：</td>
              <td ><label>
                <input name="domainname" type="text" id="domainname" size="30" />
             <span class="redtext">格式：ximotech.com 反解为
                <label title="97.138.222.in-addr.arpa" for="d2">97.138.222.in-addr.arpa</label>
                等</span></td>
            </tr>
       
            <tr>
              <td>SOA：</td>
              <td><label>
                <input name="domainsoa" type="text" id="domainsoa" value="<?echo $row['dnsname'].'.'.$row['dnsdomain']?>" size="40" />
              </label></td>
            </tr>
            <tr>
              <td>域名管理员：</td>
              <td><input name="domainadmin" type="text" id="domainadmin" value="<?echo $row['dnsadmin']?>" size="40" /></td>
            </tr>
            <tr>
              <td>启用状态：</td>
              <td><label>
                <input name="domainis" type="radio" value="1" checked="checked" />
                启用
                <input type="radio" name="domainis" value="0" />
                停用 </label></td>
            </tr>
            
            <tr>
              <td>Serial：</td>
              <td><input name="domainserial" type="text" id="domainserial" size="15" value="<?echo createnewserial();?>" />
                <span class="redtext">* 域名版本序号</span></td>
            </tr>
            <tr>
              <td>Refresh：</td>
              <td><input name="domainrefresh" type="text" id="domainrefresh" size="15" value="<?echo $row['dnsrefresh']?>" />
                <span class="redtext">* 秒</span></td>
            </tr>
            <tr>
              <td>Retry：</td>
              <td><label>
                <input name="domainretry" type="text" id="domainretry" size="15" value="<?echo $row['dnsretry']?>" />
                <span class="redtext">* 秒</span></label></td>
            </tr>
            <tr>
              <td>Expire：</td>
              <td><input name="domainexpire" type="text" id="domainexpire" size="15" value="<?echo $row['dnsexpire']?>" />
                <span class="redtext">* 秒</span></td>
            </tr>
            <tr>
              <td>Minimum TTL ：</td>
              <td><input name="domainttl" type="text" id="domainttl" size="15" value="<?echo $row['dnsttl']?>" />
                <span class="redtext">* 秒</span></td>
            </tr>
			<tr>
              <td>备注信息：</td>
              <td><input name="domainremarks" type="text" id="domainremarks" size="40" />
              </td>
            </tr>
           <tr>
          <td  colspan="2"class="footer">
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
