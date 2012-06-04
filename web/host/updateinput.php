<?
include ('../include/comm.php');
define("DB","/ximorun/ximodb/ximodb");
$pageaccess=1;
checklogin();
checkac();
if(isset($_POST['Submit'])){
    checkac('应用');
	$ver=db_exec("select ver from setupdate where updateid=1");
	//进行恢复
	//上传文件处理
	if($_FILES["updatefile"]["type"] == "application/octet-stream" || "application/x-gzip-compressed" == $_FILES["updatefile"]["type"])
	{
		$file_fix=end(explode(".",$_FILES["updatefile"]["name"] ));
		
		if ($_FILES["updatefile"]["error"] > 0 || ($file_fix!='xmpkg'))
			{ showmessage('更新系统升级包错误！','updateinput.php');}
		else {
		  $pkgPath=UPGRADE_PATH. $_FILES["updatefile"]["name"];
		  move_uploaded_file($_FILES["updatefile"]["tmp_name"],$pkgPath);
		  $sh="/xmdns/sh/install_pkg ".$pkgPath." ".($ver?$ver:"20.0.0");
		  exec($sh,$info,$error);
                  //print_r($info);
		  if($error)
          {
          showmessage("安装升级包时发生错误:".iconv("utf8","gbk",array_pop($info)),'updateinput.php');
          }
          exec('awk \'BEGIN{FS="="}/=/{print}\' '.str_replace("xmpkg",'ini',$pkgPath),$pkg_info,$error);
          foreach($pkg_info as $v){
          list($k,$value)=explode("=",$v);
          $pkg_info[$k]=$value;
          };
          $pkg_content=iconv("utf8","gbk",$pkg_info["pkg_info"]);
          $pkgDate=date("Y-m-d H:i:s",$pkg_info["pkgDate"]);
          $pkgType=$pkg_info["pkgType"];
		  $pkgVersion=$pkg_info["pkgVersion"];		  
          $pkgSize=format_size(filesize($pkgPath));
          $sql="insert into updatelog (updatetime,updatecontent,updateresult,version,pkgDate,pkgType,pkgSize,update_type) values ('".date("Y-m-d H:i:s",time())."','$pkg_content',0,'$pkgVersion','$pkgDate','$pkgType','$pkgSize',1);";
          $result=$db->query($sql);
          $result=$db->query("update setupdate set ver='$pkgVersion'"); 
	      writelog($db,'升级系统',"升级系统");
		  $db->close();
		  showmessage('升级系统成功','updateinput.php');
		}
	}	else 
		{
			  showmessage('所上传文件不是系统升级包,请检查！'.$_FILES["updatefile"]["type"],'updateinput.php');
		}
	
		

}
if(isset($_GET['ac']))
{
	if($_GET['ac']=="del")
	{
	    checkac('删除');
		$sql="delete from updatelog where updateid=".$_GET['id'];
		$db->query($sql);
		writelog($db,'系统更新',"删除系统更新日志");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>系统升级</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<script language="javascript">

function checklogin(){
	

	if(document.sysupdate.updatefile.value == ''){	
			alert("请导入升级文件");
			document.sysupdate.updatefile.select();
			return false;
		}
	
	return true;
}

</script>
</head>

<body>
<div class="wrap">
  <div class="position">&nbsp;当前位置:&gt;&gt; 系统升级</div>
<div class="content">
<form action="updateinput.php" method="post" enctype="multipart/form-data" name="sysupdate" id="sysupdate" onsubmit="return checklogin();"> 
      <table width="90%"  class="s s_form">       
         <tr>
          <td colspan="2" class="caption">系统升级</td>
        </tr>
         <tr>
           <td>系统升级包：</td>
           <td>
           <input name="updatefile" type="file" id="updatefile" />
           </td>
         </tr>
         <tr>      
          <td  colspan="2" class="whitebg">升级过程中可能要稍等一会时间，请不要进行其他操作，以免升级失败！</td>
        </tr>        
        <tr>
          <td class="footer" colspan="2">
            <input type="submit" name="Submit" value="进行系统升级" />
          </td>
        </tr>
      </table></form>&nbsp;
	  <table class="s s_grid" border="0" align="center" cellpadding="2" cellspacing="1" >
      <tr>
        <td colspan="9" class="caption">自动更新历史记录  <a href="?ac=all" onclick="javascript:return   confirm('真的要清空所有吗？');">清空所有</a></td>
      </tr>
           <tr bgcolor="#F7FFE8">
             <th width="61" height="25" align="center">序号</th>
			 <th width="203" align="center">更新时间</th>
             <th width="203" align="center">版本号</th>
			 <th width="203" align="center">包类型</th>
             <th width="286" align="center">更新内容</th>
             <th width="197" align="center">更新结果</th>
			 <th width="197" align="center">发布日期</th>
			 <th width="197" align="center">大小</th>
             <th width="81" align="center">删除</th>
        </tr>
          <?php $sql="select * from updatelog where update_type=1 order by updateid desc";
          $query=$db->query($sql);
		  $i=0;
          while($row=$query->fetch())
          {
			  if($row['updateresult']==0)
				  $result="成功";
			  else
				  $result="失败";
			  $i++;
			  ?>
          <tr bgcolor="#ffffff" onMouseOver="javascript:this.bgColor='#fdffc5';" onMouseOut="javascript:this.bgColor='#ffffff';">
            <td height="25" align="center"><?echo $i;?></td>
            <td height="25" align="center"><?echo $row['updatetime']?></td>
			<td align="center"><?=$row["version"]?></td>
			 <td align="center"><?=$pkg_types[$row["pkgType"]]?></td>
            <td height="25" align="center"><?echo $row['updatecontent']?></td>
            <td height="25" align="center"><?echo $result;?></td>
			<td align="center"><?=$row["pkgDate"]?></td>
			 <td align="center"><?=$row["pkgSize"]?></td>
            <td height="25" align="center"><a href="?ac=del&id=<?echo $row['updateid']?>" onclick="javascript:return   confirm('真的要删除自动更新日志吗？');">删除</a></td>
          </tr>
          <?}?>
	</table>
	  </div>
<?$db->close();?></div>
<? include "../copyright.php";?>
</body>
</html>
<?php
function db_exec($sql)
 {
   $sh="echo \"$sql;\"|sqlite3 ".DB;
   return `$sh`;
 }
?>
