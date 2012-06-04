<?
include ('../include/comm.php');
include ('../include/upgrade_inc.php');
checklogin();
checkac();
if(isset($_POST['updatedate'])){
	$sql="update setupdate set updateurl='".$_POST['updateurl']."',updatedate=".$_POST['updatedate']." where updateid=1";
	$db->query($sql);
	
	writelog($db,'自动更新设置',"设置自动更新");
		showmessage('自动更新设置成功','setupdate.php');

}
if(isset($_GET['ac']))switch($_GET["ac"])
{
	case"del":
		$sql="delete from updatelog where updateid=".$_GET['id'];
		$db->query($sql);
		writelog($db,'自动更新设置',"删除自动更新日志");
        break;
	case"all":
		$sql="delete from updatelog ";
		$db->query($sql);
        break;
        case"checkver":
        exec("/xmdns/sh/php/update checkver",$check_info,$error);
        if($error)
        {
        showmessage(array_pop($check_info));
        }else{
        echo array_pop($check_info);
        }
        exit;
        break;
        case"update":
        exec("/xmdns/sh/php/update",$update_info,$error);
        if($error)
        {
        showmessage(array_pop($update_info));
        }
        echo array_pop($update_info)."<script>window.location.reload();</script>";
        exit;
        break;
        default:
        sleep(10);
        exit;
        break;
}

$query=$db->query("select * from setupdate where updateid=1");
$row=$db->fetch($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>自动更新设置</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<script src="/js/jquery.js"  type="text/javascript"charset="utf-8" ></script>
<script src="/js/ximo_dns.js"  type="text/javascript" charset="utf-8"></script>
 <script language="javascript">
function checklogin(){
var check_config={
     url:document.autoupdate.updateurl.value.replace(/https?:\/\//,""),
     date:document.autoupdate.updatedate.value
    }	

	if(check_config.url == ''||check_config.url.split(":").length>2||(!checkip(check_config.url.split(":")[0])&&!checkurl(check_config.url.split(":")[0]))){	
			alert("请输入正确的更新地址");
			document.autoupdate.updateurl.select();
			return false;
		}
       if(check_config.url.indexOf(":")!=-1){
         var port=check_config.url.split(":").pop();
           if(Number(port).toString()!=port||port>65535||port<0){
			alert("请输入正确的端口号");
			document.autoupdate.updateurl.select();
			return false;
                 }
                }
	if(check_config.date == ''||Number(check_config.date).toString()!=check_config.date||0>=check_config.date){	
			alert("请输入正确的更新天数");
			document.autoupdate.updatedate.select();
			return false;
		}	
	return true;
}
//检查版本
function checkver(){
	var versions=$("#versions").val();     //隐藏域的值，存储最新版本号
	$("#vers").html("更新中……请等待").addClass("load");
        $.get("?ac=checkver",{ver:versions},function(html){
	$("#vers").html(html).removeClass("load");
        });
}
//更新
function checkupdate(){
	if($("#vers").html()=="已经是最新版本"){
       alert("当前已是最新版本,无需更新!");
	}else{
	var versions=$("#versions").val();     //隐藏域的值，存储最新版本号
	$("#vers").html("更新中……请等待").addClass("load");
        $.get("?ac=update",{ver:versions},function(html){
	$("#vers").html(html).removeClass("load");
        });
	}
}
</script>
</head>

<body>
<div class="wrap">
			<div class="position">当前位置：系统管理 >> 自动更新设置</div>
<div class="content">
<form id="autoupdate" name="autoupdate" method="post" onsubmit="return checklogin();" >
      <table width="768" class="s s_form" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#82C4E8">

        <tr>
          <td colspan="4" class="caption">自动更新设置</td>
        </tr>
         <tr>
            <td  class="title">当前版本：</td> 
            <td height="25" align="left" width="15%" bgcolor="#FFFFFF"><span id="ver"><?php echo $row['ver'];?></span>
			<input type="hidden" id="versions" name="ver" value="<?=$row['ver']?$row['ver']:"20.0.1";?>" />
			</td>
            <td class="title">最新版本：</td> 
            <td height="25" align="left" width="15%" bgcolor="#FFFFFF"><span id="vers"></span>
            <input type="hidden" id="versions" name="versions" value="<?php echo $row['version'];?>" /></td>

         </tr> 
         <tr>
         <td class="footer" colspan="4"> 
               &nbsp;&nbsp;<input type="button" class="button" name="check" id="check" value="检查" onclick="checkver();" />&nbsp;&nbsp;
               <input type="button" class="button" name="update" id="update" value="立即更新" onclick="checkupdate();" />
            </td>
            </tr>
		<?php
		foreach($pkg_types as $k=>$v){
		$sql="select max(pkgDate) as pkgVersion from updatelog where pkgType=".$k." limit 1";
		$rs=$db->fetch($db->query($sql));
		?>
	    <tr>
          <td ><?=$v?>版本：</td>
          <td height="25" colspan="3" align="left" bgcolor="#FFFFFF"><label>
          <?=date("YmdHis",strtotime($rs["pkgVersion"]?$rs["pkgVersion"]:"2011-6-1"));?>
          </label></td>
        </tr>
		<?php
		}
		?>
        <tr>
          <td >自动更新URL地址：</td>
          <td height="25" colspan="3" align="left" bgcolor="#FFFFFF"><label>
            <input name="updateurl" type="text" id="updateurl" value="<?echo $row['updateurl']?>" size="60" />
          </label></td>
        </tr>
         <tr>
           <td >设置自动更新时间：</td>
           <td height="25" colspan="3" align="left" bgcolor="#FFFFFF"><label>
             <input name="updatedate" type="text" id="updatedate" size="8" value="<?echo $row['updatedate'];?>" />
           天</label></td>
         </tr>
        
        
        <tr>
          <td class="footer" colspan="4" >
            <input type="submit" name='submit' id='submit' />
			</td>
        </tr>
        </table>
		</form> &nbsp; 
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
          <?php $sql="select * from updatelog where update_type<>1 order by updateid desc";
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
</div><div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
