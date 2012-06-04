<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();
$bindquerylog=$querylog;
$page = checkPage();
//如果删除日志
if($_GET['op']=='deldns')
{
    checkac('删除');
	//按日期删除文件
	if($_GET['logfile']=="all")
	{
		exec("echo \"\" > $querylog;");
		$sql="select doname from dnslog";
		$sql2="delete  from dnslog";
	}else
	{
		$sql="select doname from dnslog where doname='".$_GET['logfile']."'";
		$sql2="delete from dnslog where doname='".$_GET['logfile']."'";
	}
	$newdb=new SQL($logbackdb);
	$query=$newdb->query($sql);
	while($row=$newdb->fetchAssoc($query))
	{		//删除文件
		$bb="/bin/rm ".$logback.$row['doname'];
		exec($bb);		
	}
	$newdb->query($sql2);
	$newdb->close();
	writelog($db,'删除DNS解析日志','删除'.$_GET['logfile'].'DNS解析日志');
	showmessage('DNS解析日志按日期删除成功','logdel.php');
}
//按日期删除解析日志
if($_GET['op']=='deldnsdate')
{
    checkac('删除');
	//按日期删除文件
	if($_GET['start']!=""&&$_GET['end']!='')
	{
	
		$sql="select doname from dnslog where logname>='".$_GET['start']."' and logname<='".$_GET['end']."'";
		$sql2="delete from dnslog  where logname>='".$_GET['start']."' and logname<='".$_GET['end']."'";
			$newdb=new SQL($logbackdb);
	$query=$newdb->query($sql);
	while($row=$newdb->fetchAssoc($query))
	{		//删除文件
		$bb="/bin/rm ".$logback.$row['doname'];
		exec($bb);		
	}
	$newdb->query($sql2);
	$newdb->close();
	writelog($db,'删除DNS解析日志','删除从'.$_GET['start'].'到'.$_GET['end'].'时间段的DNS解析日志');
	showmessage('DNS解析日志按日期删除成功','logdel.php');
	}else 
	{
		showmessage('时间段输入不正确','logdel.php');
	}

}
//清空状态日志
if($_GET['op']=='dnsstate')
{
    checkac('删除');
	
		$bb=$truecmd." > ".$bindgenerallog;
		exec($bb);		
	writelog($db,'清空DNS状态日志','清空DNS状态日志');
	showmessage('DNS状态日志清空成功','logdel.php');

}
if($_GET['op']=='today')
{
	checkac('删除');
		$bb=$truecmd." > ".$bindquerylog;
		exec($bb);		
	writelog($db,'清空DNS当天日志','清空DNS当天日志');
	showmessage('DNS当天日志清空成功','logdel.php');

}
//按日期删除操作日志
if($_GET['op']=='deloplog')
{
    checkac('删除');
	//按日期删除文件
	if($_GET['start2']!=""&&$_GET['end2']!='')
	{
		$sql="delete from dorecord  where date(addtime)>='".$_GET['start2']."' and date(addtime)<='".$_GET['end2']."'";
			
	$db->query($sql);	
	writelog($db,'删除管理操作日志','删除从'.$_GET['start2'].'到'.$_GET['end2'].'时间段的管理操作日志');
	showmessage('DNS管理操作日志按日期删除成功','logdel.php');
	}else 
	{
		showmessage('时间段输入不正确','logdel.php');
	}

}
//按日期删除登陆日志
if($_GET['op']=='dellogin')
{
    checkac('删除');
	//按日期删除文件
	if($_GET['start3']!=""&&$_GET['end3']!='')
	{
		$sql="delete from userlog  where date(addtime)>='".$_GET['start3']."' and date(addtime)<='".$_GET['end3']."'";
			
	$db->query($sql);	
	writelog($db,'删除管理操作日志','删除从'.$_GET['start3'].'到'.$_GET['end3'].'时间段的管理登陆日志');
	showmessage('DNS登陆日志按日期删除成功','logdel.php');
	}else 
	{
		showmessage('时间段输入不正确','logdel.php');
	}

}

//清空dns解析日志
if ($_GET['op']=='dnslogs') {
	checkac('删除');
	exec("cat /dev/null >".$bindquerylog);
	writelog($db,'清空DNS解析日志','清空DNS解析日志');
	showmessage('DNS解析日志清空成功','logdel.php');
}


//清空防火墙日志
if ($_GET['op']=='firewall') {
	checkac('删除');
	exec("cat /dev/null >".$ipfwlog);
	writelog($db,'清空防火墙日志','清空防火墙日志');
	showmessage('防火墙日志清空成功','logdel.php');
}
if ($_GET['op']=='safe') {
	checkac('删除');
	exec("echo \"\"> /var/log/wtmp;");
	writelog($db,'清空安全日志','清空安全日志');
	showmessage('安全日志清空成功','logdel.php');
}

if ($_GET['op']=='alldel') {
	checkac('删除');

	$bb=$truecmd." > ".$bindgenerallog;
	exec($bb);		
	writelog($db,'清空DNS状态日志','清空DNS状态日志');

	$bb=$truecmd." > ".$bindquerylog;
	exec($bb);		
	writelog($db,'清空DNS当天日志','清空DNS当天日志');
			
	$db->query("delete from userlog");	
	writelog($db,'删除管理操作日志','清空管理登陆日志');

	exec("cat /dev/null >".$bindquerylog);
	$newdb=new SQL($logbackdb);
	$query=$newdb->query("select doname from dnslog");
	while($row=$newdb->fetchAssoc($query))
	{		//删除文件
		$bb="/bin/rm ".$logback.$row['doname'];
		exec($bb);		
	}
	$newdb->query("TRUNCATE dnslog");
	$newdb->close();
	writelog($db,'清空DNS解析日志','清空DNS解析日志');

	exec("cat /dev/null >".$ipfwlog);
	writelog($db,'清空防火墙日志','清空防火墙日志');

	exec("echo \"\"> ".$log_wtmp.";");
	writelog($db,'清空安全日志','清空安全日志');
	
	$db->query("delete from dorecord");
	writelog($db,'删除管理操作日志','清空管理操作日志');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>登陆日志</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style>td{text-indent:5px;}</style>
<script src="/js/jquery.js"></script>
<script src="../js/checkdays.js"></script>
<script src="../js/setdate.js"></script>


</head>

<body>
<div class="wrap">
    <div class="position">&nbsp;当前位置:&gt;&gt; 日志删除 </div>
    <div class="content"><form id="dnsdel" name="dnsdel" method="get" action="logdel.php"><table width="768" class="s ">
      <tr>
        <td class="caption">日志删除</td>
      </tr>
      <tr>
        <td height="25" align="left" bgcolor="#FFFFFF">
          当前DNS解析日志记录：
                                                <label>
                                                <select name="logfile" id="logfile">
                                                  <option value="all">所有日志</option>
                                                  <? $newdb=new SQL($logbackdb);
                                                  $query=$newdb->query('select * from dnslog order by addtime desc');
                                                  while($row=$newdb->fetchAssoc($query)){?>
                                                  <option value="<? echo $row['doname'];?>"><? echo $row['logname'].'解析日志';?></option>
                                                  <?}
                                                  $newdb->close();?>
                                                </select>
                                                </label>
                                                <label>
                                                <input name="op" type="hidden" id="op" value="deldns" />
                                                <input type="submit" name="Submit" value="删除选择的DNS解析日志" onclick="javascript:return   confirm('要删除选择的DNS解析日志吗？');" />
                                                </label>
                  </td>
      </tr></form>
     <form id="dnslogdel" name="dnslogdel" method="get" action="logdel.php"> <tr>
        <td height="25" align="left" background="../images/abg.gif" bgcolor="#D7F5F9" class="graybg">
          按日期删除DNS解析日志：
              <label>
              <input name="start" type="text" id="start" size="13" onclick="fPopCalendar(event,this,this)" onfocus="this.select()" readonly="readonly" value="<?echo $_GET['start']?>" title="双击弹出日期选择" />
              </label>
      <label>
 到
 <input name="end" type="text" id="end" size="13" onclick="fPopCalendar(event,this,this)" onfocus="this.select()" readonly="readonly" value="<?echo $_GET['end']?>" title="双击弹出日期选择" />      
 <input name="op" type="hidden" id="op" value="deldnsdate" /><input type="submit" name="Submit2" value="删除本时间段的日志文件" onclick="javascript:return   confirm('要删除选择的日期段里DNS解析日志吗？');"/>
      </label>
                </td>
      </tr></form>
      <tr>
        <td height="25" align="left" bgcolor="#FFFFFF">清空dns状态日志：<a href="logdel.php?op=dnsstate" onclick="javascript:return   confirm('要清空DNS的状态日志吗？');">我要清空</a><!-- <a href="?op=today">&gt;&gt;清空当天日志</a> --> </td>
      </tr><form id="oplog" name="oplog" method="get" action="logdel.php">
      <tr>
        <td height="25" align="left" background="../images/abg.gif" bgcolor="#D7F5F9" class="graybg">
          按日期删除操作日志：
              <label>
      <input name="start2" type="text" id="start2" size="13" onclick="fPopCalendar(event,this,this)" onfocus="this.select()" readonly="readonly" value="<?echo $_GET['start2']?>" title="双击弹出日期选择" />
      </label>
      <label> 到
        <input name="end2" type="text" id="end2" size="13" onclick="fPopCalendar(event,this,this)" onfocus="this.select()" readonly="readonly" value="<?echo $_GET['end2']?>" title="双击弹出日期选择" />
      <input name="op" type="hidden" id="op" value="deloplog" /> <input type="submit" name="Submit22" value="删除本时间段的操作日志" onclick="javascript:return   confirm('要删除本时间段的操作日志吗？');" />
      </label>
        </td>
      </tr></form>
      <form id="loginlog" name="loginlog" method="get" action="logdel.php"><tr>
        <td height="25" align="left" bgcolor="#FFFFFF">
          按日期删除登陆日志：
            <label>
      <input name="start3" type="text" id="start3" size="13" onclick="fPopCalendar(event,this,this)" onfocus="this.select()" readonly="readonly" value="<?echo $_GET['start3']?>" title="双击弹出日期选择" />
      </label>
      <label> 到
        <input name="end3" type="text" id="end3" size="13" onclick="fPopCalendar(event,this,this)" onfocus="this.select()" readonly="readonly" value="<?echo $_GET['end3']?>" title="双击弹出日期选择" />
      <input name="op" type="hidden" id="op" value="dellogin" /> <input type="submit" name="Submit222" value="删除本时间段的登陆日志" onclick="javascript:return   confirm('要删除本时间段的登陆日志吗？');" />
      </label>
        </td>
      </tr></form>
      
      <tr>
        <td height="25" align="left" bgcolor="#FFFFFF">清空dns解析日志：<a href="logdel.php?op=dnslogs" onclick="javascript:return   confirm('要清空DNS的解析日志吗？');">我要清空</a></td>
      </tr>
      <!--<tr>
        <td height="25" align="left" bgcolor="#FFFFFF">清空防火墙日志：<a href="logdel.php?op=firewall" onclick="javascript:return   confirm('要清空防火墙日志吗？');">我要清空</a></td>
      </tr>-->
	        <tr>
        <td height="25" align="left" bgcolor="#FFFFFF">清空安全日志：<a href="logdel.php?op=safe" onclick="javascript:return   confirm('要清空安全日志吗？');">我要清空</a></td>
      </tr>
	  <tr>
        <td height="25" align="left" bgcolor="#FFFFFF">
		<form id="alllog" name="alllog" method="get" action="logdel.php">
			<input name="op" type="hidden" value="alldel" />
			<input type="submit" value="一键删除日志" onclick="javascript:return confirm('要删除所有日志吗？');" />
		</form>
		</td>
      </tr>

    </table></td>
  </tr>
</table></div><div class="push"></div></div>

<? include "../copyright.php";?>
</body>
</html>
