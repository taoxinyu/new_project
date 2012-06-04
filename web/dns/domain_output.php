<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>域名导出设置</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<script src="/js/jquery.js"></script>
<script src="/js/ximo_dns.js"></script>
<script language="javascript">

function checklogin(){
	

	if(document.domainoutput.domain.value == ''){	
			alert("请选择域名");
			//document.domaininput.domain.select();
			return false;
		}
	return true;
}

</script>
</head>

<body>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 域名设置&gt;&gt; 域名导出</div>
<ul class="tab-menu">
    <li><a href="domain.php">域名管理</a></li>
	<li><a href="domain_add.php">域名添加</a></li>   
    <li><a href="domaingroup.php">域名转发管理</a></li>
	<li><a href="domain_input.php">批量导入</a></li>
    <li  class="on"><span>域名导出</span></li>
	<!--li><a href="checkzone.php">检测域名记录</a></li-->
    <li><a href="domain.php?ac=app">应用设置到系统</a></li> 
  
</ul>
<div class="content">
      <form id="domainoutput" name="domainoutput" method="post" action="domain_output.php" onsubmit="return checklogin();">
      
		  <table width="696" align="center" class="s s_form">
		  <tr>
          <td colspan="2" class="caption">域名导出</td>
        </tr>
            <tr>
              <td>选择要导出的域名：</td>
              <td>
               <select name="domain" id="domain">
                <?$q=$db->query("select * from domain");
                while($r=$db->fetchAssoc($q))
                {?>
                <option value="<?echo $r['domainid']?>" <?if($_POST['domain']==$r['domainid']){echo "selected";}?>><?echo $r['domainname']?></option>
                <?}?>
                </select>
              </td>
            </tr>
           

            <tr>
              <td>请选择要导出的线路：</td>
              <td><select name="dacl" id="dacl">
              <option value="ANY" <?if($_POST['dacl']=="ANY"){echo "selected";}?>>通用</option>
               <?$q=$db->query("select * from setacl");
                while($r=$db->fetchAssoc($q))
                {?>
                <option value="<?echo $r['aclident']?>" <?if($_POST['dacl']==$r['aclident']){echo "selected";}?>><?echo $r['aclident']?></option>
                <?}?>
              </select></td>
            </tr><?if(isset($_POST['Submit'])){?>
            <tr>
              <td colspan="2" class="caption"   style="background: none repeat scroll 0 0 #FFFFFF;">
                 <?php $sql="select * from drecord where ddomain=".$_POST["domain"]." and dacl='".$_POST['dacl']."' order by dname,dtype";
                
                $query=$db->query($sql);
                $s="";
                while($row=$db->fetchAssoc($query))
                {
                	$s=$s.$row['dname']."     IN     ".$row['dtype'];
                	if($row['dtype']=="MX" || $row['dtype'] == "A6")
                	{
                		$s=$s."   ".$row['dys'];
                	}
					if($row['remarks']==""){
						$s=$s."    ".$row['dvalue']."\n";
					}else{
						$s=$s."    ".$row['dvalue'];
						$s=$s."    ;".$row['remarks']."\n";
					}
                }
                ?><textarea name="test" cols="80" rows="30" id="test"><?echo $s?>               
                </textarea>
              </td>
              </tr>
           <?}?>
		    <tr>
          <td colspan="2" class="footer"><label>
          <input type="submit" name="Submit" value="导出" />
</label></td>
        </tr>
          </table>        
       
      </form>
</div><div class="push"></div></div>
     <?
      $db->close();?>
<? include "../copyright.php";?>
</body>
</html>
