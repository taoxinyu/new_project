<?php
/*
 +-----------------------------------------------------
 * 	2010-6-8
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
    if ($_POST['tbstate'] == 1){//启用
        //更新domain表中的domaintype字段
        $type = 0;
        if ($_POST['zf'] == 1){//主
            $type = 1;
        } else {
            $type = 2;
        }
        $sql = "update domain set domaintype=$type, domainisapp=0 where domainid=".$_POST['domainid'];
        $db->query($sql);
    } else {//停用
        //更新domain表中的domaintype字段
        $sql = 'update domain set domaintype=0, domainisapp=0 where domainid='.$_POST['domainid'];
        $db->query($sql);
    }
    
    
    //查看记录情况
    $sql = "select * from tongbu where domainid=".$_POST['domainid'];
    $rst = $db->query($sql);
    $n = $db->num_rows($rst);
    $sql = "";
    if ($n == 1){ //有记录，更新。update
        if ($_POST['zf'] == 1){//主
            $dnsip = $_POST['fuip'];
        }
        else {
            $dnsip = $_POST['zhuip'];
        }
        
        
        $sql = "update tongbu set tbtype=".$_POST['zf']." , tbzip='".$dnsip."' , tbstate=".$_POST['tbstate']." where domainid=".$_POST['domainid'];
    } else { //没有记录，添加。insert
        if ($_POST['zf'] == 1){//主
            $dnsip = $_POST['fuip'];
        }
        else {
            $dnsip = $_POST['zhuip'];
        }
        $sql = "insert into tongbu values(".$_POST['domainid'].",".$_POST['zf'].",'".$dnsip."','',".$_POST['tbstate'].")";
        
    }
    //echo $sql;
    $db->query($sql);
    
	writelog($db,'域名管理',"域名同步设置");
	$db->close();
	showmessage('设置成功!','domain.php');

} else {//读取信息
    $sql = "select * from tongbu where domainid=".$_GET['domainid'];
    $res = $db->query($sql);
    $r = $db->fetchAssoc($res);
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

function checklogin(){
	if(document.tongbu.zhuip.value != ''){
	
			if(!checkip(document.tongbu.zhuip.value))
			{
				alert("IP格式有误");
				document.tongbu.zhuip.select();
				return false;
			}
		}
		if(document.tongbu.fuip.value != ''){
	
			if(!checkip(document.tongbu.fuip.value))
			{
				alert("IP格式有误");
				document.tongbu.fuip.select();
				return false;
			}
		}
		return true;
	//alert(document.getElementsByName('tbstate').value);
}
function zhufu(rd){
	div1 = document.getElementById('zhu');
	div2 = document.getElementById('fu');
	if (rd.id == 'zf1' && rd.checked == true){//主
		div1.style.display="block";	
		div2.style.display="none";	
	}
	else {
		div1.style.display="none";	
		div2.style.display="block";
	}
}
function checkip(ip){
	var reg = /^\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b$/; 
	if (!reg.test(ip)) { 
		
	return false; 
	} 
	return true; 
}
</script>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 域名设置 &gt;&gt; 域名同步</div>
<div class="content"> 

    <form id="tongbu" name="tongbu" method="post" action="tongbu.php" onsubmit="return checklogin();">
    <table width="450"  class="s s_form">
      
        <tr>
          <td colspan="2" class="caption">域名同步设置</td>
        </tr>
        <tr>
          <td colspan="2" class="whitebg">
              <input type="radio" name="zf" id="zf1" value="1" <?php if (!isset($r['tbtype']) || $r['tbtype'] == 1) echo 'checked="checked"';?> onclick="javascript:zhufu(this);"/>主域名
              <input type="radio" name="zf" id="zf0" value="2" <?php if (isset($r['tbtype']) && $r['tbtype'] == 2) echo 'checked="checked"';?> onclick="javascript:zhufu(this);" />辅域名 
          </td>
        </tr>
        <tr>
          <td colspan="2" class="bluebg">
             <!-- 辅 -->        
          <div id="fu" style="display: <?php if (!isset($r['tbtype']) || $r['tbtype'] == 1 ) echo 'none'?>">
          <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#82c4e8">
          	<tr>
          	  <td height="25" align="right" bgcolor="#e7f4ff">主DNS地址：</td>
          	  <td width="300" height="30" align="left" bgcolor="#FFFFFF"><input type="text" name="zhuip" id="zhuip" value="<?php echo $r['tbzip'];?>" /></td>	
          	</tr>
          </table>
          </div> 
          <!-- 主 -->
          <div id="zhu" style="display: <?php if (isset($r['tbtype']) && $r['tbtype'] == 2) echo 'none'?>">
          <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#82c4e8">
            <tr>
          	  <td height="25" align="right" bgcolor="#e7f4ff">辅DNS地址：</td>
          	  <td width="300" height="30" align="left" bgcolor="#FFFFFF"><input type="text" name="fuip" id="fuip" value="<?php echo $r['tbzip'];?>" /></td>	
          	</tr>
          </table>
          </div>   
          
       
                   
        </td>
        </tr>
        <tr>
          <td>状态：</td><td>
            <input name="tbstate" type="radio" value="1" <?php if ($r['tbstate'] == 1) echo 'checked="checked"';?> />启用
            <input type="radio" name="tbstate" value="0" <?php if ($r['tbstate'] == 0) echo 'checked="checked"';?> />停用
          </td>
        </tr>
        <tr>
          <td colspan="2" class="footer">
              
              <input type="submit" name="Submit" value="保存设置" />
              <input type="hidden" name="domainid" value="<?php echo $_GET['domainid'];?>"/>
    		  
		  </td>
        </tr>
     
    </table> </form></div></div>
  
<? include "../copyright.php";?>
</body>
</html>