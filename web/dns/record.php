<?
include ('../include/comm.php');
checklogin();
//checkac();
checkac_do(2);
$query=$db->query("select aclname,aclident from setacl where group_type=1");
$province=array();
while($row = $db->fetchAssoc($query))
{
$province[$row["aclident"]]=$row["aclname"];
}
$page = checkPage();
if(isset($_GET['ac']))
{
	if ($_GET['ac'] == 'pdel'){ //ɾ�����
		//checkac('ɾ��');
		checkac_do(4);
		$ids = implode(",", $_POST['todel']);
		$num = count($_POST['todel']);
		$sql = "delete from drecord where did in (".$ids." )";
		$db->query($sql);
		
		$sql="update domain set domainisapp='0' where domainid=".$_GET['domainid'];
		$db->query($sql);
		$sql="update domain set domainnum=domainnum-$num where domainid=".$_GET['domainid'];
		$db->query($sql);
		writelog($db,'��������',"ɾ����¼��".$_GET['ddomain']);		
	}
	if($_GET['ac']=='del')
	{
		//checkac('ɾ��');
		checkac_do(4);
		$sql="delete from drecord where did=".$_GET['id'];
		$db->query($sql);
		$sql="update domain set domainisapp='0' where domainid=".$_GET['domainid'];
		$db->query($sql);
		$sql="update domain set domainnum=domainnum-1 where domainid=".$_GET['domainid'];
		$db->query($sql);
		writelog($db,'��������',"ɾ����¼��".$_GET['dname2'].".".$_GET['ddomain']);
	}
	if($_GET['ac']=='stop')
	{
		//checkac('Ӧ��');
		checkac_do(6);
		$sql="update drecord set dis='0' where did=".$_GET['id'];
		$db->query($sql);
		$sql="update domain set domainisapp='0' where domainid=".$_GET['domainid'];
		$db->query($sql);
		writelog($db,'��������',"ͣ�ü�¼��".$_GET['dname2'].".".$_GET['domainname']);
	}
	if($_GET['ac']=='start')
	{
		//checkac('Ӧ��');
		checkac_do(6);
		$sql="update drecord set dis='1' where did=".$_GET['id'];
		$db->query($sql);
		$sql="update domain set domainisapp='0' where domainid=".$_GET['domainid'];
		$db->query($sql);
		writelog($db,'��������',"���ü�¼��".$_GET['dname2'].".".$_GET['domainname']);
	}
}
$domainid=$_GET["domainid"];
$query=$db->query("select * from domain where domainid=".$domainid);
$row=$db->fetchAssoc($query);
$domainname=$row['domainname'];

//�ж������Ƿ�Ϊ�����¼
$isptr = false;
if (strstr($domainname, '.arpa') == '.arpa'){
    $isptr = true;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>��������</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style>
.ss td.foot{ text-align:left; height:25px; background-color:#FFFFFF;}
.ss td.graybg{ background:url(images/bg4.jpg); height:28px; font-weight:bold;}
</style>
<script src="/js/jquery.js"></script>
<script src="/js/ximo_dns.js"></script>
<script>
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
	fm = document.getElementById('delform');
	fm.action="record.php?"+cs;
	fm.submit();
}
</script>

</head>

<body>
<script src="/js/wz_tooltip.js" ></script>
<script src="/js/tip_followscroll.js" ></script>
<div class="wrap">
<div class="nav">&nbsp;��ǰλ��:&gt;&gt; ��������:&gt;&gt; ��¼���� </div>
<ul class="tab-menu">
	<li><a href="domain.php">��������</a></li>
    <li  class="on"><span>��¼����</span></li>    
    <li><a href="record_add.php?domainid=<?echo $domainid?>">��¼����</a></li>
	<li><a href="domain_ptr.php?domainid=<?echo $domainid?>" onclick="javascript:return   confirm('���Ҫ�Զ����ɱ������ķ��������¼��');">�Զ����ɱ������������</a></li>

</ul>
<div class="content"> 
<table width="98%" class="s s_grid">
     
        <tr>
          <td colspan="2" class="caption"><?echo $domainname?>������¼����</td>
        </tr>
        <tr>
          <td colspan="2"><form id="search" name="search" method="get" action="record.php">
����������¼��
<label>
<input name="dname" type="text" id="dname" value="<?echo $_GET['dname']?>" size="10" />
</label>
 ���ͣ�
 <label>
 <select name="dtype1" id="dtype1">
  <option value="" <?if($_GET['dtype1']==""){echo "selected";}?>>����</option>
   <?for($i=0;$i<sizeof($dtype);$i++){?>
                <option value="<?echo $dtype[$i]?>" <?if($_GET['dtype1']==$dtype[$i]){echo "selected";}?>><?echo $dtype[$i]?></option>
                <?}?>
 </select>
 </label>          
          <label>
          ��·��
          <select name="dacl1">
          <option value="" <?if($_GET['dacl1']==""){echo "selected";}?>>����</option>
          <option value="ANY" <?if($_GET['dacl1']=="ANY"){echo "selected";}?>>ͨ��</option>
          <?$q=$db->query("select * from setacl");
          while($r=$db->fetchAssoc($q))
          {?>   <option value="<?echo $r['aclident']?>" <?if($_GET['dacl1']==$r["aclident"]){echo "selected";}?>><?echo $r['aclident']?></option>
          <?}?>
          </select>
		 </label> 
		��¼ֵ�� 
		  <label>
<input name="dvalue" type="text" id="dvalue" value="<?echo $_GET['dvalue']?>" size="10" />
</label>


          ״̬��
		  <label>
          <select name="dis1" id="dis1">
            <option value="" <?if($_GET['dis1']==''){echo "selected";}?>>����</option>
            <option value="1"  <?if($_GET['dis1']=='1'){echo "selected";}?>>������</option>
            <option value="0"  <?if($_GET['dis1']=='0'){echo "selected";}?>>ͣ����</option>
          </select>
          <input name="domainid" id="domainid" type="hidden" value="<?echo $domainid?>">
          <input type="submit" name="Submit" value="����" />
		  <input type="submit" name="Submit1" value="ģ������" />
          </label> 
          (��ɫ����ΪδӦ�õ�ϵͳ��   </form>        </td>
        </tr>
       
        <tr>
          <td colspan="2">
          <form id="delform" name="delform" method="post">
          <table width="100%" align="center" cellpadding="1" cellspacing="1" bgcolor="#CCCCCC" class="ss">
              <tr>
              	<th width="5%" ></th>
                <th width="9%">������¼</th>
                <th width="9%">IN</th>
                <th width="9%">����</th>
                <th width="9%">���ȼ�</th>
                <th width="12%" >��·</th>
                <th width="20%" >��¼ֵ</th>
                <th width="10%">״̬</th>
                <th width="17%">����</th>
              </tr>
              <?
               $starnum = ($page-1)*$pagesizenum;
        $keyword="";
		if($_GET['Submit1']!=''){
		$keyword=$keyword."&Submit1=".$_GET['Submit1'];
		}
        $sqld=" 1<2";
         if($_GET['dacl1']!='')
        {
        	$sqld=$sqld." and dacl='".$_GET['dacl1']."'";
        	$keyword=$keyword."&dacl1=".$_GET['dacl1'];
        }
        if($_GET['domainid']!='')
        {
        	$sqld=$sqld." and ddomain=".$_GET['domainid'];
        	$keyword=$keyword."&domainid=".$_GET['domainid'];
        }
		 if($_GET['dis1']!='')
        {
        	$sqld=$sqld." and dis='".$_GET['dis1']."'";
        	$keyword=$keyword."&dis1=".$_GET['dis1'];
        }
		if($_GET['dtype1']!='')
        {
			$ww = $sqld;
        	$sqld=$sqld." and dtype='".$_GET['dtype1']."'";
        	$keyword=$keyword."&dtype1=".$_GET['dtype1'];
        }
		
		if($_GET['dvalue']!='')
        {	
			if($_GET['Submit1']!=''){
			$sqld=$sqld." and dvalue like '%".$_GET['dvalue']."%'";	
			}else{
			$sqld=$sqld." and dvalue='".$_GET['dvalue']."'";
			}
        	$keyword=$keyword."&dvalue=".$_GET['dvalue'];
        }
		
		if($_GET['dname']!='')
        {	
			if($_GET['Submit1']!=''){
			$sqld=$sqld." and dname like '%".$_GET['dname']."%'";	
			}else{
			$sqld=$sqld." and dname='".$_GET['dname']."'";
			}
        	$keyword=$keyword."&dname=".$_GET['dname'];
        }
        $sql = "select count(*) as mycount from drecord where".$sqld;
        
        $query=$db->query($sql);
        $allnum=0;
        while($row=$db->fetchAssoc($query))
        {
        	$allnum=$row['mycount'];
        }
		$w = "";
		if($_GET['Submit1']!='' && $_GET['dtype1']!=''){
			$sql ="select dvalue from drecord where".$sqld." group by dvalue";
			$query = $db->query($sql);
			while($row = $db->fetchAssoc($query)){
				$a = explode(".", $row['dvalue']);
				$zhuji[] = "'".$a[0]."'";
			}
			$w = " or ( ".$ww." and dname in (".implode(',',$zhuji).") )";
			$keyword=$keyword."&Submit1=".$_GET['Submit1'];

			$sql ="select count(*) as mycount from drecord where (".$sqld.") ".$w;
			$query=$db->query($sql);
			while($row=$db->fetchAssoc($query))
			{
				$allnum=$row['mycount'];
			}
		}
        $totalpage=ceil($allnum/$pagesizenum);
	//if($default_record_type!=1){
        $sql ="select * from drecord where (".$sqld.") ".$w." order by dname,dtype,dacl"; 
	$sql=$sql." limit {$starnum},{$pagesizenum}";
$query = $db->query($sql);
$i=0;
while($row = $db->fetchAssoc($query))
{
	$i++;
?>
              <tr class="<?=$row['disapp']=="0"?"bg_red":""?>">
                <td height="25" align="center" class="graytext"><input type="checkbox" name="todel[]" id="todel[]" value="<?php echo $row['did'];?>" onclick="checkcolor(this, <?php echo "'$bg'"?>)"/></td>
                <td height="25" align="center" class="graytext"><? echo $row['dname']?></td>
                <td height="25" align="center" class="graytext">IN</td>
                <td height="25" align="center"  class="graytext"><?echo $row['dtype']?></td>
                <td align="center" class="graytext"><?echo $row['dys']?></td>
                <td align="center" class="graytext"><?if($row['dacl']=='ANY'){echo 'ͨ��';}else{echo $row['dacl'];}?></td>
				<?if($row['remarks']!=""){?>
				 <td align="center" class="graytext" onmouseover="Tip('<?=$row['remarks']?>')" onmouseout="UnTip()" ><?echo stripslashes($row['dvalue'])?></td>
				<?}else{?>
                <td align="center" class="graytext"><?echo stripslashes($row['dvalue'])?></td>
				<?}?>
                <td align="center" class="graytext"><?if($row['dis']=='1'){echo '������';}else{echo 'ͣ����';}?></td>
				
                <td align="center" class="graytext"><?if($row['dis']=='1'){?><a href="record.php?domainid=<?echo $domainid?>&dname2=<?echo $row['dname']?>&domainname=<?echo $domainname?>&id=<?echo $row['did']?>&ac=stop<?echo $keyword?>" onclick="javascript:return   confirm('���Ҫֹͣ��������¼��');">ͣ��</a><?}else{?><a href="record.php?domainid=<?echo $domainid?>&dname2=<?echo $row['dname']?>&domainname=<?echo $domainname?>&id=<?echo $row['did']?>&ac=start<?echo $keyword?>" onclick="javascript:return   confirm('���Ҫ���ý�������¼��');">����</a><?}?> | <a href="record_mode.php?domainid=<?echo $domainid?>&id=<?echo $row['did']?>&ptr=<?php if($isptr) echo 1;?>">�޸�</a> | <a href="record.php?ac=del&id=<?echo $row['did']?>&dname2=<?echo $row['dname']?>&ddomain=<?echo $domainname?>&domainid=<?echo $domainid?><?echo $keyword?>" onclick="javascript:return   confirm('���Ҫɾ������¼��');">ɾ��</a></td>
              </tr>
<?}?>
			  <tr>
			  	<td colspan="10" class="foot" align="left" height="25" bgcolor="#ffffff"><img src="../images/jiantou.png" /><a href="javascript:s_all();">ȫѡ</a> / <a href="javascript:c_all();">ȫ��ѡ</a> <a href="javascript:del('<?php echo  "ac=pdel&dname2=".$row['dname']."&ddomain=".$domainname."&domainid=".$domainid?>');">ɾ��ѡ����</a> </td>
			  </tr>
			  </form>
            </table>
          </td>
        </tr>
        <tr>
          <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="graybg">�� <?echo $allnum?> ����¼����ǰ��<?echo $page?>/<?echo $totalpage?> ҳ ��ʾ�� <? echo $starnum+1?>-<?echo $starnum+$i?> ����¼</td>
        </tr>
        <tr>
          <td height="25" colspan="2" align="center" bgcolor="#FFFFFF" class="graybg"><a href="?page=1<?echo $keyword?>">��ҳ</a> <?if($page>1){?><a href="?page=<?echo $page-1?><?echo $keyword?>">��һҳ</a><?}else{?>��һҳ<?}?> <?if($page<$totalpage){?><a href="?page=<?echo $page+1?><?echo $keyword?>">��һҳ</a><?}else{?>��һҳ<?}?> <a href="?page=<?echo $totalpage?><?echo $keyword?>">ĩҳ</a> ������
      <select onchange="window.location='?page='+this.value+'<?echo $keyword?>'" size="1" name="topage">
        <? for( $i=1;$i<=$totalpage;$i++) 
        {?>
        <option value="<?echo $i?>" <?if($i==$page){echo "selected=selected";}?>><?echo $i?></option>
       <?}?>
      </select>
ҳ���� <?echo $totalpage?>ҳ</td>
        </tr>
    
    </table></div><div class="push"></div></div>
<?$db->close();?>
<? 
include "../copyright.php";?>
</body>
</html>