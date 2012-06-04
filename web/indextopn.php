<?php
header("content-type:text/html;charset=gb2312");
?>
<div id="topsn" style="overflow-y:scroll; height:340px; width:390px;">
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#82C4E8">
			       <tr>
			          <td height="22" colspan="5" align="left" background="images/bg_title.gif"><span class="zisefont">解析Top排名（更新周期：10分钟）</span>
		<select id="select" onchange="checkTop(this.value);">
		<option value="10" <?php if($_GET['top']==10) echo "selected"; ?> >10</option>
		<option value="20" <?php if($_GET['top']==20) echo "selected"; ?> >20</option>
		<option value="30" <?php if($_GET['top']==30) echo "selected"; ?> >30</option>
		<option value="40" <?php if($_GET['top']==40) echo "selected"; ?> >40</option>
		<option value="50" <?php if($_GET['top']==50) echo "selected"; ?> >50</option>
		<option value="60" <?php if($_GET['top']==60) echo "selected"; ?> >60</option>
		<option value="70" <?php if($_GET['top']==70) echo "selected"; ?> >70</option>
		<option value="80" <?php if($_GET['top']==80) echo "selected"; ?> >80</option>
		<option value="90" <?php if($_GET['top']==90) echo "selected"; ?> >90</option>
		<option value="100" <?php if($_GET['top']==100) echo "selected"; ?> >100</option>
		</select>
		</td>
			       </tr>
			       <tr>
			       <td width="4%" height="25" align="center" bgcolor="#e7f4ff" class="graytext">排名</td>
			          <td width="35%" height="25" align="center" bgcolor="#e7f4ff" class="graytext">解析记录 Top<?php echo $_GET['top']; ?></td>
			          <td width="13%" height="25" align="center" bgcolor="#e7f4ff" class="graytext">次数</td>
			          <td width="35%" height="25" align="center" bgcolor="#e7f4ff" class="graytext">客户端IP Top<?php echo $_GET['top']; ?></td>
			          <td width="13%" height="25" align="center" bgcolor="#e7f4ff" class="graytext">次数</td>
			       </tr>
			       
			       <?php 
			       		$topn=$_GET['top'];
						$nowtime1=mktime();
						$nowtime2=file_get_contents("/xmdns/var/log/top/date");
						$nowtime3=$nowtime1-$nowtime2;
						if($nowtime3>10){
						exec("/xmdns/sh/tenmin.sh",$av);
					
						}
						$abc=file_get_contents("/xmdns/var/log/top/temp3.txt");
						$rs=explode("\n", $abc);
			       		$domain = array();
			       		$ip = array();
			       		$flag = 0;
			       		foreach ($rs as $r){
			       			if ($r != "===="){
			       				if (!$flag){
			       					$ds = explode(" ", $r);
			       					$domain[] = $ds;
			       				}
			       				else {
			       					$ds = explode(" ", $r);
			       					$ip[] = $ds;
			       				}
			       			}
			       			else{
			       				$flag = 1;
			       			}
			       		}
			       		//$len=(count($domain)>=count($ip))?count($domain):count($ip);
			       		$len=$_GET['top'];
			       		for ($i = 0; $i < $len; $i++){
			       ?>
			       <tr>
			       	  <td width="4%" height="26" align="center"bgcolor="#FFFFFF" class="graytext"><?php echo $i+1; ?></td>
			          <td width="35%" height="26" align="center"bgcolor="#FFFFFF" class="graytext"><?php echo $domain[$i][0]?></td>
			          <td width="13%" height="26" align="center" bgcolor="#FFFFFF" class="graytext"><?php echo $domain[$i][1]?></td>
			          <td width="35%" height="26" align="center" bgcolor="#FFFFFF" class="graytext"><?php echo $ip[$i][0]?></td>
			          <td width="13%" height="26" align="center" bgcolor="#FFFFFF" class="garytext"><?php echo $ip[$i][1]?></td>
			       </tr>
			       <?php }?>
			       </table>
			       </div>
