<?php
include "include/comm.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <title>导航菜单</title>
  
   	<link href="zzci.css" rel="stylesheet" type="text/css" />
<style type="text/css">

*{margin:0;padding:0;border:0;}
body {
	background-image: url(images/left_buttomover.gif);
	text-align:left;
	background-repeat: repeat-y;
	
	
}

#nav {
	width:200px;
    line-height: 26px; 
	list-style-type: none;
	text-align:left;
	
    /*定义整个ul菜单的行高和背景色*/
}
/*==================一级目录===================*/
#nav a {
	width: 190px; 
	height:26px;
	display: block;
	padding-left:0px;
	float:center;
	
	

	/*Width(一定要)，否则下面的Li会变形*/
}
#nav li {
	/*background:#CCC; /*一级目录的背景色*/
	
	background:url(images/left_menuback.gif);
    float:center;
	
	/*background:url(images/menubg.gif);
	/*float：left,本不应该设置，但由于在Firefox不能正常显示
	继承Nav的width,限制宽度，li自动向下延伸*/
}
#nav li a:hover{
	/*background:#CC0000;	/*一级目录onMouseOver显示的背景色*/
	
}
#nav a:link  {
	color:#1a4875; 
	text-decoration:none;

}
#nav a {
	color:#35518F ;
	text-decoration:none;
	font-family: Arial,Helvetica,sans-serif,"宋体";
	font-size: 10pt;

}

/*==================二级目录===================*/
#nav li ul {
	list-style:none;
	text-align:left;
	background:url(images/left_back_2.jpg);

}
#nav li ul li{	
    
	background:#ffffff; /*二级目录的背景色*/
	border-bottom:#F9FAF6 1px solid;
	background:url(images/left_back_2.jpg);
	background-position: -24px;
	margin-left:2em;
}
#nav li ul a{
         float:center;
         width:138px;
		 line-height: 26px; 
	/* padding-left二级目录中文字向右移动，但Width必须重新设置=(总宽度-padding-left)*/
}
/*下面是二级目录的链接样式*/
#nav li ul a:link  {
	color:#1a4875; text-decoration:none;
	line-height: 26px; 
}
#nav li ul a:visited  {
	color:#215d07;text-decoration:none;
	line-height: 26px; 

}
#nav li ul a:hover {
	color:#ff7a31;
	
	font-weight:normal;
	background:#FFFFff;
	line-height: 26px; 
	
	
	/* 二级onmouseover的字体颜色、背景色*/
}
/*==============================*/
#nav li:hover ul {
	left: auto;
	
}
#nav li.sfhover ul {
	left: auto;
	
}
#content {
	clear: left; 
	
}
#nav ul.collapsed {
	display: none;
	
}

#PARENT{
	width:200px;
	text-align:center;
	background:url(images/left_buttomover.gif);
}
.STYLE1 {
	font-size: 13px;
	color: #1a4875;
	font-weight: bold;
}
td{
color:#0b7392;
	font-family:  "宋体",Arial, Helvetica, sans-serif;
    font-size: 12px;
}
</style>
<script language="javascript">
function view(viewid){              
  if (viewid.style.display=="none")
     {
	 viewid.style.display="";
 }
    else
     {
	 viewid.style.display="none";
	 }
}
</script>
</head>
<body>
  <table width="200" border="0" cellpadding="0" cellspacing="0">
  <tr>
  	<td height="7"  background="images/left_back.gif" ></td>
  </tr>
  <tr>
    <td height="29" align="center" background="images/left_top.gif" class="STYLE1">DNS功能菜单</td>
  </tr>
  
  <tr>
    <td width="200" align="center" background="images/left_back.gif" >
	<table width="192" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td > 
        <table width="180" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
		    <td  valign="top">
		    <table width="91%" border="0" align="right" cellpadding="0" cellspacing="0">
		      <tr>
		        <td>
		        <TABLE cellSpacing=0 cellPadding=0 width=180 bgColor=#cccccc border=0>
					<TBODY>
					<TR>
						<TD bgColor=#ffffff>
						<DIV id=PARENT>
							<UL id=nav>
							<?php
							$sql = "select * from 'module' where pid is null";
                            $sql .= " order by [order] asc";
                            $rs = $db->query($sql);
							$n = 0;
							while($row = $db->fetchAssoc($rs)){
                            //判断权限
                            $moduleid=$row['module_id'];
                            if (!getPriByUser('access',$_SESSION['loginname'], $row['name'])){
                                continue;
                                
                            }
                        	$n++;
							?>								
							<LI>
								<A onClick="DoMenu('ChildMenu<?php echo $n?>')" href="left.php#Menu=ChildMenu<?php echo $n?>">
								<SPAN class="ccolor">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['name']?></SPAN></A>
								<UL class=collapsed id=ChildMenu<?php echo $n?>>
	                                <LI >
	                                <TABLE cellSpacing=0 cellPadding=0 width=138 align=center border=0>
	                                <TBODY>
										<?php 
										$pid = $moduleid;
										$sql2 = "select * from module where pid = $pid and module_id != 75 order by [order] asc";
										$rs2 = $db->query($sql2);
										while ($row2 = $db->fetchAssoc($rs2)){
    										//判断权限
    									    if (!getPriByUser('access',$_SESSION['loginname'], $row2['name'])){
    									    	continue;   
    									    }
										?>
										<TR align="left" height=20>
		                                	<TD width=116 height=20><A href="<?php echo $row2['url'].'?moduleid='.$row2['module_id'];?>" target="mainFrame">&nbsp;&nbsp;&nbsp;<?php echo $row2['name']?></A></TD>
								  		</TR>
		                                <TR>
		                                	<TD bgColor=#eeeeee colSpan=2 height=1></TD>
										</TR>
										<?php 
										}
										?>				
	                               </TBODY>
	                               </TABLE>
								   </LI>
							   </UL>
							</LI>
							<?php 
							}
							?>							   
							</UL>
						</DIV>
						</TD>
					</TR>
					</TBODY>
				</TABLE>
				</td>
			 </tr>
		    </table>
		    </td>
		  </tr>
    	</table>
    	</td>
  	 </tr> 
	</table>
	</td>
  </tr>
  
  </table>
<script type=text/javascript>
var LastLeftID = "";
function menuFix() {
	var obj = document.getElementById("nav").getElementsByTagName("li");
	
	for (var i=0; i<obj.length; i++) {
		obj[i].onmouseover=function() {
			this.className+=(this.className.length>0? " ": "") + "sfhover";
		}
		obj[i].onMouseDown=function() {
			this.className+=(this.className.length>0? " ": "") + "sfhover";
		}
		obj[i].onMouseUp=function() {
			this.className+=(this.className.length>0? " ": "") + "sfhover";
		}
		obj[i].onmouseout=function() {
			this.className=this.className.replace(new RegExp("( ?|^)sfhover\\b"), "");
		}
	}
}
function DoMenu(emid)
{   
    // document.cookie =  emid; 
	 var objName="mm1";
	 var objValue=emid;
	 var objHours=0;
	 var str = objName + "=" + escape(objValue);
			if(objHours > 0){//为0时不设定过期时间，浏览器关闭时cookie自动消失
				var date = new Date();
				var ms = objHours*3600*1000;
				date.setTime(date.getTime() + ms);
				str += "; expires=" + date.toGMTString();
			}
			document.cookie = str;
			//alert(document.cookie);

	 //addCookie(cookie_name,cookie_value,cookie_expireHours);
	 
	var obj = document.getElementById(emid);	
	obj.className = (obj.className.toLowerCase() == "expanded"?"collapsed":"expanded");
	if((LastLeftID!="")&&(emid!=LastLeftID))	//关闭上一个Menu
	{
		document.getElementById(LastLeftID).className = "collapsed";
	}
	LastLeftID = emid;
}
function GetMenuID()
{
	var MenuID="";
	
	var _paramStr = new String(window.location.href);
	
	//alert (window.location.href);
	var _sharpPos = _paramStr.indexOf("#");
	//var _sharpPos = cookie_array[0];
	
	if (_sharpPos >= 0 && _sharpPos < _paramStr.length - 1)
	{
		_paramStr = _paramStr.substring(_sharpPos + 1, _paramStr.length);
	}
	else
	{
		_paramStr = "";
	}
	
	if (_paramStr.length > 0)
	{
		var _paramArr = _paramStr.split("&");
		if (_paramArr.length>0)
		{
			var _paramKeyVal = _paramArr[0].split("=");
			if (_paramKeyVal.length>0)
			{
				MenuID = _paramKeyVal[1];
			}
		}
		
	}
}  
   
function getCookie(objName){//获取指定名称的cookie的值
	var arrStr = document.cookie.split("; ");
	for(var i = 0;i < arrStr.length;i ++){
		var temp = arrStr[i].split("=");
		if(temp[0] == objName) return unescape(temp[1]);
	} 
}
if (LastLeftID != "")	
{	
	var cookie_name="mm1";
	var mm1ck = getCookie(cookie_name);
	DoMenu(mm1ck);
	GetMenuID();	//*这两个function的顺序要注意一下，不然在Firefox里GetMenuID()不起效果
	menuFix();
}
</script>

</body>
</html>
