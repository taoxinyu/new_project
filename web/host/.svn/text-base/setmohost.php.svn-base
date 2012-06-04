<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();
if(isset($_POST['Submit'])){
    checkac('添加');
	if ($_POST['mtype'] == 'port')
		$url = $_POST['pt']." ".$_POST['tu']; //当类型是port时， url存放   ‘ 端口+空格+T或U ’ ; T:tcp , U:udp
	else if ($_POST['mtype'] == 'server')
		$url = $_POST['fw']." T";
	else 
		$url = $_POST['murl'];
		
	$sql="insert into mhost (mname,mip,mdate,mis,mtype,murl)values('".$_POST['mname']."','".$_POST['mip']."'";
	$sql=$sql.",".$_POST['mdate'].",'".$_POST['mis']."','".$_POST['mtype']."','".$url."')";
	$db->query($sql);
	
	writelog($db,'监控主机管理',"添加监控主机:".$_POST['mname'].$_POST['mip']);
		$db->close();
		showmessage('添加监控主机成功','setmohost.php');
}
if(isset($_GET['ac']))
{
	if($_GET['ac']=='del')
	{
	    checkac('删除');
		//删除
		$db->query("delete from mhost where mid=".$_GET['id']);
		$db->query("delete from mhostacl where maclhostid=".$_GET['id']);
		writelog($db,'监控主机管理',"删除监控主机");
	}
	elseif($_GET['ac']=='pdel')
	{
        checkac('删除');
		if(isset($_POST["todel"])){
		$ids=implode(",",$_POST["todel"]);
		$db->query("delete from mhost where mid in (".$ids.")");
		$db->query("delete from mhostacl where maclhostid in (".$ids.")");
        writelog($db,'监控主机管理',"删除监控主机");
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>监控主机设置</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style>
.title{background:#e7f4ff; width:25%; text-align:right;}
td.foot{text-align:left}
</style>
<script src="/js/jquery.js"  type="text/javascript"charset="utf-8" ></script>
<script src="/js/ximo_dns.js"  type="text/javascript" charset="utf-8"></script>
<script language="javascript">
function s_all(){
	var checkboxs = document.getElementsByName('todel[]');
	for(var i=0;i<checkboxs.length;i++){
		checkboxs[i].checked = true;
		if (checkboxs[i].parentNode.parentNode.bgColor != "#fcdfdf")
			checkboxs[i].parentNode.parentNode.bgColor="#fdffc5";
	}
}
function c_all(){
	var checkboxs = document.getElementsByName('todel[]');
	for(var i=0;i<checkboxs.length;i++){
		checkboxs[i].checked = false;
		if (checkboxs[i].parentNode.parentNode.bgColor != "#fcdfdf")
			checkboxs[i].parentNode.parentNode.bgColor="#ffffff";
	}
}
function checkcolor(bx, color){
	if (bx.checked == true){
		if (bx.parentNode.parentNode.bgColor != "#fcdfdf")
			bx.parentNode.parentNode.bgColor="#fdffc5";
	}
	else{
		if (bx.parentNode.parentNode.bgColor != "#fcdfdf")
		bx.parentNode.parentNode.bgColor=color;
	}
}
function del(cs){
	fm = _g('delform');
	fm.action="?"+cs;
	fm.submit();
}
function checklogin(){

	if(document.mhost.mname.value == ''){	
		alert("请输入监控名称");
		document.mhost.mname.select();
		return false;
	}
	else
	{
		if(!checkSpace(document.mhost.mname.value))
		{
			alert("只能输入英文字母,数字和下划线");
			document.mhost.mname.select();
			return false;
		}
	}
	if(document.mhost.mtype[1].checked && document.mhost.murl.value != ''){	
		if(document.mhost.mip.value != ''){
			if(!checkip(document.mhost.mip.value) && !checkipv6(document.mhost.mip.value))
			{
				alert("输入的IP格式有误");
				document.mhost.mip.select();
				return false;
			}
		}
		if(!checkurl(document.mhost.murl.value ))
		{
			alert("输入的url格式有误");
			document.mhost.murl.select();
			return false;
		}	
	}
	if(document.mhost.mtype[1].checked && document.mhost.murl.value == ''){	
		alert("请输入URL监控方式URL地址");
		document.mhost.murl.select();
		return false;
	}
	if(!document.mhost.mtype[1].checked){
		if(document.mhost.mip.value == ''){	
			alert("请输入监控主机IP");
			document.mhost.mip.select();
			return false;
		}
		else
		{
			if(!checkip(document.mhost.mip.value) && !checkipv6(document.mhost.mip.value))
			{
				alert("输入的IP格式有误");
				document.mhost.mip.select();
				return false;
			}
		}
	}
	
	if(document.mhost.mtype[3].checked && document.mhost.pt.value == ''){	
		alert("请输入端口检测方式端口号");
		document.mhost.pt.select();
		return false;
	}
	else if(document.mhost.mtype[3].checked && !isPort(document.mhost.pt.value))
		{
			alert("请填写有效端口号");
			document.mhost.pt.select();
			return false;
		}
	return true;
}
</script>
</head>

<body>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; 监控主机设置</div>
<div class="content">
 <form id="mhost" name="mhost" method="post" action="setmohost.php" onsubmit="return checklogin();"> 
      <table width="778"    class="s s_form"  >
         <tr>
          <td  colspan="4"  class="caption"  >监控主机设置</td>
        </tr>
         <tr>
           <td >监控名称：</td>
           <td>
             <input name="mname" type="text" id="mname" />
           </td>
           <td  class="title" >监控主机IP：</td>
           <td  >
             <input name="mip" type="text" id="mip" size=30/>
          </td>
         </tr>
         <tr>
          <td >ping检测方式：</td>
          <td>
            <input name="mtype" type="radio" value="ping" checked="checked" />
            启用PING检测方式
          </td>
          <td  class="title" >检测时间间隔：</td>
          <td >
            <select name="mdate" id="mdate">
              <option value="5">5分钟</option>
              <option value="10">10分钟</option>
              <option value="30">30分钟</option>
              <option value="60">60分钟</option>
            </select>
          </td>
         </tr>
        <tr>
          <td >URL检测方式：</td>
          <td>
            <input type="radio" name="mtype" value="url" />
          启用URL方式:
          <input name="murl" type="text" id="murl" size="36" />
          </td>
          <td class="title">是否开启：</td>
          <td  >
            <input name="mis" type="radio" value="1" checked="checked" />
          开启
          <input name="mis" type="radio" value="0" /> 
          关闭
		</td>
        </tr>
        
        <tr>
          <td>服务检测方式：</td>
          <td>
		  <input type="radio" name="mtype" value="server" />
          启用服务检测方式:
            <select name="fw" id="fw">
              <option value="25">smtp</option>
              <option value="53">dns server</option>
			  <option value="80">http</option>
              <option value="109">pop2</option>
              <option value="110">pop3</option>
			  <option value="161">snmp</option>
			  
            </select>
          </td>
          <td></td>
          <td></td>
        </tr>
               <tr>
          <td>端口检测方式：</td>
          <td>
            <input type="radio" name="mtype" value="port" />
          启用端口检测方式:
          <input name="pt" type="text" id="pt" size="6" />
		  <select name="tu" id="tu">
              <option value="T">tcp</option>
              <option value="U">udp</option>
            </select>
          </td>
          <td  ></td>
          <td  ></td>
        </tr>
        
        
        <tr>
          <td  colspan="4"  class="footer">
            <input type="submit" name="Submit" value="保存设置" />
         </td>
        </tr>
      </table></form>  &nbsp; 
<form method="post" id="delform">
 <table width="778"  class="s s_grid" >
	 <tr>
    <td class="caption" colspan="8" >监控主机状态</td>
  </tr>
      <tr >
	    <th></th>
        <th>监控名称</th>
        <th >监控主机IP</th>
        <th>监控方式</th>
        <th>状态</th>
        <th>检测时间</th>
        <th>启用状态</th>
        <th>管理</th>
      </tr>
      <?
    
		$query=$db->query("select * from mhost order by mid desc");
while($row = $db->fetchAssoc($query))
{
?>
      <tr>
	    <td><input type="checkbox" name="todel[]" value="<?=$row['mid'];?>"/></td>
        <td><?echo $row['mname']?></td>
        <td><?echo $row['mip']?></td>
        <td><?if($row['mtype']=='url'){echo "URL:".$row['murl'];}else{echo $row['mtype'];}?></td>
        <td><a href="mohost.php?&ip=<?echo $row['mip']?>&mtype=<?echo $row['mtype']?>&murl=<?echo $row['murl']?>" target="_blank">点击查看</a></td>
        <td><?echo $row['mdate']?>分钟</td>
        <td><?if($row['mis']=="1"){echo "启用中";}else{echo "停用中";}?></td>
        <td><a href="setmohost.php?id=<?echo $row['mid']?>&amp;ac=del" onclick="javascript:return   confirm('真的要删除此监控主机吗，本主机下的监控策略也全部删除？');">删除</a> | <a href="setmohost_mode.php?id=<?echo $row['mid']?>">修改</a></td>
      </tr>
      <?}
      $db->close();?>
	  <td class="foot" colspan="8"><img src="../images/jiantou.png"><a href="javascript:s_all();">全选</a> / <a href="javascript:c_all();">全不选</a> <a href="javascript:del('ac=pdel');">删除选中项</a> </td>
    </table>
 </form>
</div><div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>
