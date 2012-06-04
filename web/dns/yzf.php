<?php
/*
 +-----------------------------------------------------
 * 	2010-3-23
 +-----------------------------------------------------
 *		
 +-----------------------------------------------------
 */

include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();

if(isset($_POST['Submit'])){
	checkac('应用');
   if ($_POST['yzfstate'] == 1){//启用
       //更新domain表中的domaintype字段
       $sql = 'update domain set domaintype=3, domainisapp=0 where domainid='.$_POST['domainid'];
       $db->query($sql);
       
       //记录数据
       $sql = 'select * from yzf where domainid='.$_POST['domainid'];
       $n = $db->num_rows($db->query($sql));
       if ($n == 1){//有记录
           $sql = "update yzf set ip='".$_POST['ip']."' where domainid=".$_POST['domainid'];
           $db->query($sql);
       } else {//没有记录
           $sql = "insert into yzf values(".$_POST['domainid'].",'".$_POST['ip']."')";
           $db->query($sql);
       }
   } else {//停用
        //更新domain表中的domaintype字段
       $sql = 'update domain set domaintype=0, domainisapp=0 where domainid='.$_POST['domainid'];
       $db->query($sql);
       
       //记录数据
       $sql = 'select * from yzf where domainid='.$_POST['domainid'];
       $n = $db->num_rows($db->query($sql));
       if ($n == 1){//有记录
           $sql = "update yzf set ip='".$_POST['ip']."' where domainid=".$_POST['domainid'];
           $db->query($sql);
       } else {//没有记录
           $sql = "insert into yzf values(".$_POST['domainid'].",'".$_POST['ip']."')";
           $db->query($sql);
       }
   }

    writelog($db,'域名管理',"域名转发设置");
	$db->close();
	showmessage('设置成功!','domain.php');
} else {
    $sql = "select domain.domaintype, yzf.* from domain,yzf where domain.domainid=".$_GET['domainid']." and yzf.domainid=".$_GET['domainid'];
    $res = $db->query($sql);
    $row = $db->fetchAssoc($res);
    $state = $row['domaintype'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>日志设置</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<script src="/js/jquery.js"></script>
<script src="/js/ximo_dns.js"></script>

<script language="javascript">
function checkIp(obj)
{
	var exp=/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
	var reg = obj.match(exp);
	if(reg==null)
		return false;
	return true;
} 
function checklogin(){
var ips=document.yzf.ip.value;
    ch = new Array;
    ch = ips.split(";");
    if(ips!=""){
	for(var i=0;i<ch.length;i++){
	if(!checkIp(ch[i]))
		{
			alert("输入地址格式不正确！");
		    document.yzf.ip.select();
			return false;
		}
	}
}
}

</script>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 域名设置 &gt;&gt; 域转发</div>
<div class="content"> 
    <form id="yzf" name="yzf" method="post" action="yzf.php" onsubmit="return checklogin();">
    <table width="500" class="s s_form">
         <tr>
          <td colspan="2"class="caption">域转发</td>
        </tr>
        <tr>
          <td>
          	转发至：
          </td>
          <td>
             <input type="text" name="ip" id="ip" value="<?php echo $row['ip'];?>"/>
          </td>
        </tr>
        <tr>
          <td>状态</td>
          <td>
            <input name="yzfstate" type="radio" value="1" <?php if($state == 3) echo 'checked="checked"';?> />启用
            <input type="radio" name="yzfstate" value="0" <?php if($state != 3)echo 'checked="checked"';?> />停用
          </td>
        </tr>
        <tr>
          <td colspan="2"class="footer">            
              <input type="submit" name="Submit" value="保存设置" />
              <input type="hidden" name="domainid" value="<?php echo $_GET['domainid']?>"/>
    		  
		  </td>
        </tr>      
    </table></form>
</div>
<?
   $db->close();?></div>
<? include "../copyright.php";?>
</body>
</html>