<?
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();

//线路应用
function aclapp($db, $binddir){
	    global $logover,$logtemp,$logtemp1,$logtemp2,$logdns10,$logip10,$logurl,$logim,$sqlite3,$dnsdb,$logtimesh,$etcmaster,$logback;
		$sql="update setacl set aclisapp='1'";
		$db->query($sql);
		$sql="update forwarder set app=1";
		$db->query($sql);

		$rc=""; 	//存放ximoacl.conf内容
		$rc1="";	//存放ximozone.conf内容
		
		//DNS线路转发
		/*
		 * forwarder数据表中
		 * zftype: 1 : 全部转此DNS解析;  0 : 本地DNS无法解析，转此DNS解析 
		 * state: 1 : 启用; 0 : 停用
		 * app: 1 : 应用; 0 : 未应用
		 */
		$sql = "select * from forwarder where state=1";
		$query = $db->query($sql);
		while ($row = $db->fetchAssoc($query)){
			if ($row['zftype'] == 1){ //全部转此DNS解析;
				$dnsip = $row['addr'];
				$dnsip = str_replace(";", ";\n", $dnsip);
				$dnsip .= ";";
				
				$rc .= "include \"acl/".$row['ident']."\";\n";    //存入ximoacl.conf的内容
				//存入ximozone.conf的内容
				$rc1 .= "view \"view_".$row['ident']."\" {\nmatch-clients { ".$row['ident']."; };\nallow-query { any; };\n";
				$rc1 .= "allow-recursion { any; };\nallow-transfer { any; };\nrecursion  yes;\n";
				$rc1 .= "forwarders {\n$dnsip\n};\n};\n";
			}
			else { //本地DNS无法解析，转此DNS解析 
				$dnsip = $row['addr'];
				$dnsip = str_replace(";", ";\n", $dnsip);
				$dnsip .= ";\n";
				
				$rc .= "include \"acl/".$row['ident']."\";\n";    //存入ximoacl.conf的内容
				$rc1 .= "view \"view_".$row['ident']."\" {\n";    //存入ximozone.conf的内容
				$rc1 .= "forwarders {\n$dnsip\n};\n};\n";
			}
		}
		//END    DNS线路转发
		
		//添加线路信息
		$sql="select * from setacl where aclis='1' order by aclpri";
		$query=$db->query($sql);
		$i=0;
		while($row=$db->fetchAssoc($query)) //取出系统中的线路
		{
			$rc=$rc."include \"acl/".$row['aclident']."\";\n";
			
			$rc1=$rc1.createaclzone($binddir,$row['aclident'],$db);
			$i++;
		}
		
		if($i>0){//线路个数大于0。有线路
		    $rc1=$rc1.createanyzone($binddir,$db);
		}else {//没有线路
			$rc1=createanyzone($binddir,$db);
		}
		//END    添加线路信息
		
		//写入文件
		writeFile($binddir."ximoacl.conf",$rc);
		writeFile($binddir."ximozone.conf",$rc1);

		//添加区域文件
		
//生成time.sh
$timesh = "";
$strtop ="#!/bin/sh\n";
$strtop .="a=/bin/awk\n";
$strtop .="b=/bin/sort\n";
$strtop .="c=/usr/bin/tail\n";
$strtop .="log=`date +%y%m%d --date=\"-1 day\"`\n";

$strtop .="\$a -F '[ #]' '{print $11,$6,$9}' $logback\$log > $logover\n";

$timesh = $timesh.$strtop;
$sql = "select aclident from setacl where aclisapp='1'";
$rs = $db->query($sql);
while($row = $db->fetchAssoc($rs)){
$flag = $row['aclident'];
$strmid="\$a '/view_$flag/' $logover>$logtemp\n";
$strmid .="\$a '{a[$1]+=1};END{for(i in a){print \"$flag\" \",\" \",\" i \",\" \",\" a[i] \",\" \"'\$log'\"}}' $logtemp > $logtemp1\n";
$strmid .="\$b -n -t, -k5  $logtemp1|\$c -n10 >>$logdns10\n";
$strmid .="\$a '{a[$2]+=1};END{for(i in a){print \"$flag\" \",\" i \",\" \",\" a[i] \",\" \",\" \"'\$log'\"}}' $logtemp> $logtemp1\n";
$strmid .="\$b -n -t, -k5 $logtemp1|\$c -n10 >>$logip10\n";
$strmid .="x=0\n";                                                    
$strmid .="while [ \$x -le 100 ]\n";                                     
$strmid .="do\n";                                                     
$strmid .="x=$((x+1))\n";                                             
$strmid .="url=` grep $flag $logdns10|sed -n ''\$x'p'|awk -F ',' '{print $3}'`\n";
$strmid .="echo \$url\n";
$strmid .="awk '/^'\$url'/' $logtemp>$logtemp2\n";
$strmid .="awk '{a[$2]+=1}END{for(i in a) print a[i]\",\" \"$flag,\" i \",\" \"'\$url'\" \",\" \"'\$log'\"}' $logtemp2 | sort -n|tail -n10>> $logurl\n";
$strmid .="done\n";

$timesh = $timesh.$strmid;
}
$strend ="\$a '/view_ANY/' $logover>$logtemp\n";
$strend .="\$a '{a[$1]+=1};END{for(i in a){print \"ANY\" \",\" \",\" i \",\" \",\" a[i] \",\" \"'\$log'\"}}' $logtemp > $logtemp1\n";
$strend .="\$b -n -t, -k5  $logtemp1|\$c -n10 >>$logdns10\n";
$strend .="\$a '{a[$2]+=1};END{for(i in a){print \"ANY\" \",\" i \",\" \",\" a[i] \",\" \",\" \"'\$log'\"}}' $logtemp> $logtemp1\n";
$strend .="\$b -n -t, -k4 $logtemp1|\$c -n10 >>$logip10\n";
$strend .="x=0\n";                                                    
$strend .="while [ \$x -le 100 ]\n";                                     
$strend .="do\n";                                                     
$strend .="x=$((x+1))\n";                                             
$strend .="url=` grep ANY $logdns10|sed -n ''\$x'p'|awk -F ',' '{print $3}'`\n";
$strend .="echo \$url\n";
$strend .="awk '/^'\$url'/' $logtemp>$logtemp2\n";
$strend .="awk '{a[$2]+=1}END{for(i in a) print a[i]\",\" \"ANY,\" i \",\" \"'\$url'\" \",\" \"'\$log'\"}' $logtemp2 | sort -n|tail -n10>> $logurl\n";
$strend .="done\n";

$strend .="rm $logtemp\n";
$strend .="rm $logtemp1\n";

$strend .="tm=`date +%y%m`\n";
$strend .="dm=`date +%y%m --date=\"-1 day\"`\n";
$strend .="if [ \$tm -ne \$dm ];then\n";
$strend .="tm=\$dm\n";
$strend .="fi\n";

$strend .="echo -e \"create table IF NOT EXISTS dns\$tm(server,ip,domain,ipn int,domn int,time);\">$logim\n";
$strend .="echo -e \".separator \\\",\\\"\" >> $logim\n";
$strend .="echo -e \".import $logip10 dns\$tm\" >>$logim\n";
$strend .="echo -e \".import $logdns10 dns\$tm\" >>$logim\n";

$strend .="echo -e \"create table IF NOT EXISTS url\$tm(num int, flag varchar(10), ip varchar(30), domain varchar(30),time);\" >> $logim\n";
$strend .="echo -e \".import $logurl url\$tm\" >> $logim\n";

$strend .="cat $logim | $sqlite3 $dnsdb\n";
$strend .="#rm -f $logim\n";
$strend .="rm -f $logdns10\n";
$strend .="rm -f $logip10\n";
$strend .="rm -f $logtemp2\n";
$strend .="rm -f $logurl\n";
$strend .="rm -f $logover\n";
$timesh = $timesh.$strend;

writeFile($logtimesh, $timesh);
system("chmod +x ".$logtimesh);	
}


if(isset($_GET['ac']))
{
	if($_GET['ac']=='del')
	{
		checkac('删除');
		$sql="delete from domain where domainid=".$_GET['domainid'];
		$db->query($sql);
		$sql="delete from drecord where ddomain=".$_GET['domainid'];
		$db->query($sql);
		$sql="delete from tongbu where domainid=".$_GET['domainid'];
		$db->query($sql);
		$sql="delete from do_access where domain_id=".$_GET['domainid'];
		$db->query($sql);
		//删除文件
		exec("/bin/rm ".$binddir."master/".$_GET['domainname']."_*");
		exec("/bin/rm ".$binddir."slave/".$_GET['domainname']."_*");
		$sql="update domain set domainisapp='0'";
		$db->query($sql);
		exec("ls $etcmaster",$arrLS,$intErr);
		foreach ($arrLS as $ls)
		{
			$as="a".$ls;
			if (strpos($as,$_GET['domainname'])) {
				exec("rm -rf $etcmaster".$ls);
				//echo "rm -rf $etcmaster".$ls.'<br>';
			}
		}
		writelog($db,'域名管理',"删除域名：".$_GET['domainname']);
	}
	
	if($_GET['ac']=='pdel')
	{		
		checkac('删除');
		$num = count($_POST['todel']);	
		for($i=0;$i<$num;$i++)
		{
			$total=$_POST['todel'][$i];
			$totals=explode(" ", $total);
			$idss[]=$totals[0];
			$names[]=$totals[1];
		}		
		$ids = implode(",", $idss);		
		$sql="delete from domain where domainid in(".$ids.")";
		$db->query($sql);
		$sql="delete from drecord where ddomain in(".$ids.")";
		$db->query($sql);
		$sql="delete from tongbu where domainid in(".$ids.")";
		$db->query($sql);
		$sql="delete from do_access where domain_id in(".$ids.")";
		$db->query($sql);
		//删除文件
		for($i=0;$i<$num;$i++)
		{
			exec("/bin/rm ".$binddir."master/".$names[$i]."_*");
			exec("/bin/rm ".$binddir."slave/".$names[$i]."_*");
			$sql="update domain set domainisapp='0'";
			$db->query($sql);
			exec("ls $etcmaster",$arrLS,$intErr);
			foreach ($arrLS as $ls)
			{
				$as="a".$ls;
				if (strpos($as,$names[$i])) {
					exec("rm -rf $etcmaster".$ls);
					//echo "rm -rf $etcmaster".$ls.'<br>';
				}
			}
			writelog($db,'域名管理',"删除域名：".$names[$i]);
		}
		
	}

	if($_GET['ac']=='app')
	{
		checkac('应用');
		aclapp($db, $binddir); //先应用线路,生成ximozone.conf	
		
		$sql="update domain set domainisapp='1' ";
		$db->query($sql);
		$sql="update drecord set disapp='1' ";
		$db->query($sql);
		//域名写入文件
		createdomain($db,$binddir);
		writelog($db,'域名管理',"应用域名设置到系统");
	}
}
$query=$db->query("select * from domain where domainisapp='0'");
$num=$db->num_rows($query);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>域名管理</title>
<link href="/ximo_dns.css" rel="stylesheet" type="text/css" />
<style>
.s td.foot{text-align:left;}
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
	fm.action="domain.php?"+cs;
	fm.submit();
}
</script>

</head>

<body>
<script src="/js/wz_tooltip.js" ></script>
<script src="/js/tip_followscroll.js" ></script>
<div class="wrap">
<div class="nav">&nbsp;当前位置:&gt;&gt; 域名设置 </div>
<ul class="tab-menu">
	<li class="on"><span>域名管理</span></li>
    <li><a href="domain_add.php">域名添加</a></li>    
    <li><a href="domaingroup.php">域名转发管理</a></li>
	<li><a href="domain_input.php">批量导入</a></li>
    <li><a href="domain_output.php">域名导出</a></li>
	<!--<li><a href="checkzone.php">检测域名记录</a></li-->
    <li><a href="domain.php?ac=app">应用设置到系统</a></li>   
</ul>
<div class="content"> 
<form id="delform" name="delform" method="post">
          <table width="780"  class="s s_grid" align="center">
		   <tr>
          <td  colspan="6" class="caption" >域名管理</td>
        </tr>
              <tr>
			  <th width="20" ></th>
                <th width="238" >域名</th>
                <th width="50" >记录数</th>
                <th width="60" >状态</th>
                <th width="75">版本号</th>
                <th width="210">管理</th>
              </tr>
              <?
		$query=$db->query("select * from domain as d left join do_access as a on d.domainid=a.domain_id and privilege_id=2 and role_id=$_SESSION[role] group by domainname having status=1 order by domainid desc ");
while($row = $db->fetchAssoc($query))
{
?>
              <tr class="<?=$row['domainisapp']=="0"?"bg_red":""?>">
			  <td><input type="checkbox" name="todel[]" id="todel[]" value="<?php echo $row['domainid']." ".$row['domainname'];?>" onclick="checkcolor(this, <?php echo "'$bg'"?>)"/></td>
			  <?php if($row['domainremarks']!=""){ ?>			   
                <td onmouseover="Tip('<?=$row['domainremarks']?>')" onmouseout="UnTip()" > <a href="record.php?domainid=<?echo $row['domainid']?>" ><?echo $row['domainname']?></a></td>
			  <?php }else{ ?>
			  <td > <a href="record.php?domainid=<?echo $row['domainid']?>" ><?echo $row['domainname']?></a></td>
			  <?php } ?>
                <td  ><?echo $row['domainnum']?></td>
                <td ><?if($row['domainis']=="1"){echo "启用中";}else{echo "停用中";}?></td>
                <td ><?echo $row['domainserial']?></td>
                <td ><a href="domain_mode.php?id=<?echo $row['domainid']?>">修改</a>  | <a href="domain.php?ac=del&domainid=<?echo $row['domainid']?>&domainname=<?echo $row['domainname']?>" onclick="javascript:return   confirm('真的要删除本域名吗？');">删除</a> | <a href="record_add.php?domainid=<?echo $row['domainid']?>">添加记录</a> | <a href="tongbu.php?domainid=<?php echo $row['domainid'];?>">同步</a> | <a href="yzf.php?domainid=<?php echo $row['domainid'];?>">域转发</a></td>
              </tr>
              <?}
       ?>
          <tr>
			  	<td colspan="6" class="foot" ><img src="../images/jiantou.png" /><a href="javascript:s_all();">全选</a> / <a href="javascript:c_all();">全不选</a> <a href="javascript:del('<?php echo "ac=pdel";?>');" >删除选中项</a> </td>
			  </tr>
        <tr>
          <td  colspan="6"  class="footer">
          红色背景域名为未应用到DNS系统解析域名，请点击应用设置到系统进行应用！</td>
        </tr>
    
    </table></form></div><div class="push"></div></div>
<?$db->close();?>
<? include "../copyright.php";?>
</body>
</html>
