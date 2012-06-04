<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();
if($_POST['doit']=="back")
{
	//进行备份
	$db1 = new SQL($dbfile);
	$mybackfile='dns'. date("Y-m-d-H-i-s") . '.xmdns';	
	$sql="insert into backlog (backtime,backroot,backfile,backmemo)values(datetime('now','localtime'),'".$_SESSION['loginname']."','".$mybackfile."','".$_POST['backmemo']."')";
    
	$db1->query($sql);
	$cmd=$rundir."backup.sh ".$mybackfile;
	exec($cmd);		
    
	 writelog($db,'数据备份','备份:'.$mybackfile);
	 $db1->close();
	 showmessage('数据备份成功！','backup.php');
	
}
if($_POST['doit']=="rest")
{
	//进行恢复
	//上传文件处理
	if($_FILES["backfile"]["type"] == "application/octet-stream")
	{
		$file_fix=end(explode(".",$_FILES["backfile"]["name"] ));//
		if($file_fix=="xmdns" ){
    		if ($_FILES["backfile"]["error"] > 0)
            { 
    		    showmessage('文件错误！','backup.php');
    		}
    		else 
    		{
        	    move_uploaded_file($_FILES["backfile"]["tmp_name"],$backup_upload. $_FILES["backfile"]["name"]);
                $cmd=$rundir."rest.sh upload/".$_FILES["backfile"]["name"];
        	    exec($cmd);
        	    exec("/bin/rm ".$backup_upload.$_FILES["backfile"]["name"]);
        	    writelog($db,'数据恢复','恢复备份');
        	    showmessage('数据恢复成功！','backup.php');
    		}
		}
		else 
		{
		    showmessage('所上传文件不是备份文件,请检查！','backup.php');
		}
		
	}	
	else 
	{
		  showmessage('所上传文件不是备份文件,请检查！','backup.php');
	}
}

if($_GET['ac']=="del")
{
	//删除备份
	$db1 = new SQL($dbfile);
	
	$sql="delete from backlog where id=".$_GET['id'];
	$db1->query($sql);
	$db1->close();
	exec("/bin/rm ".$backup_back.$_GET['filename']);
	writelog($db,'数据备份','删除备份');
}
if($_GET['ac']=="rest")
{
	//删除备份
	$cmd=$rundir."rest.sh back/".$_GET['filename'];
	
	exec($cmd);
	writelog($db,'数据恢复','恢复备份');
	showmessage('数据恢复成功！','backup.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>备份设置</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<script src="/js/jquery.js"  type="text/javascript"charset="utf-8" ></script>
<script src="/js/ximo_dns.js"  type="text/javascript" charset="utf-8"></script>

<script language="javascript">

function checklogin(){
	

	if(document.backup.backmemo.value == ''){	
			alert("请输入备份备注");
			document.backup.backmemo.select();
			return false;
		}else{
			if(!checkname(document.backup.backmemo.value)){
				alert("备份备注只能是汉字，数字，字母，下划线！");
				document.backup.backmemo.select();
				return false;
			}
		
		}
	
	return true;
}
function checklogin1(){
	

	if(document.backup1.backfile.value == ''){	
			alert("请导入备份文件");
			document.backup1.backfile.select();
			return false;
		}
	
	return true;
}
</script>
</head>

<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; 数据备份与恢复</div>
<div class="content">

      <table width="768"  class="s s_form">
        <tr>
          <td colspan="2" class="caption">数据备份与恢复</td>
        </tr>
         <tr>
           <td>系统数据备份备注：</td>
           <td ><form action="backup.php" method="post"  name="backup" id="backup" onsubmit="return checklogin();">
             <input name="backmemo" type="text" id="backmemo" size="50" />
			 <input type="hidden" name="doit" id="doit" value="back" />
             <input type="submit" name="Submit" value="我要备份" /></form>
           </td>
         </tr>
         <tr>
          <td colspan="2" class="footer"><span class="yeetext">注意：数据备份将备份系统所有的配置文件以及数据设置，日志文件不在备份范围！           
          </span>           </td>
          </tr>
         <tr>
          <td>系统数据恢复：</td>
          <td><form action="backup.php" method="post"  name="backup1" enctype="multipart/form-data" id="backup1" onsubmit="return checklogin1();">
            <input type="file" name="backfile" />
             <input type="hidden" name="doit" id="doit" value="rest" />
            <span class="graybg">
            <input type="submit" name="Submit" value="我要恢复备份" />
            </span></form></td>
        </tr>
        <tr>
          <td colspan="2" class="footer">注意：数据恢复将恢复到备份文件当时的配置以及数据设置，日志文件不在恢复范围！(重启后生效) </td>
          </tr>
  </table>&nbsp;
          <table width="768" class="s s_grid">
		      <tr>
          <td colspan="6" class="caption">数据备份历史</td>
        </tr>
            <tr >
              <th>序号</th>
              <th>备份日期</th>
              <th>备份用户</th>
              <th>备份备注</th>
              <th>备份文件下载</th>
              <th>备份删除/恢复</th>
            </tr>
            <?$db1 = new SQL($dbfile);
            $sql="select * from backlog order by id desc";
            $query=$db1->query($sql);
            while($row=$db1->fetchAssoc($query))
            {?>
            <tr>
              <td><?echo $row['id']?></td>
              <td><?echo $row['backtime']?></td>
              <td><?echo $row['backroot']?></td>
              <td><?echo $row['backmemo']?></td>
              <td><a href="/back/<?echo $row['backfile']?>">点击下载</a></td>
              <td><a href="backup.php?ac=del&id=<?echo $row['id']?>&filename=<?echo $row['backfile']?>" onclick="javascript:return   confirm('真的要删除本备份吗？');">删除</a> &nbsp;<a href="backup.php?ac=rest&id=<?echo $row['id']?>&filename=<?echo $row['backfile']?>" onclick="javascript:return   confirm('真的要恢复本备份吗？');">恢复</a></td>
            </tr>
            <?}
            $db1->close();?>
           
          </table><div class="push"></div></div></div>
<? include "../copyright.php";?>
</body>
</html>
