<?php
session_start();
if($_SESSION['islogin'] != "1"){
	include 'checkin.php';
} else {
?>
<html>
<head>
<title>智能DNS</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">

<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
<link href="css/common.css" rel="stylesheet" type="text/css" media="screen">

<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery_002.js"></script>

<script language="javascript" src="js/function.js"></script>
<script language="JavaScript" type="text/javascript" src="js/common.js"></script>
<script language="JavaScript" type="text/javascript" src="js/div_menu.js"></script>

<script language="JavaScript">
<!--
function switchSysBar()
{
    var sp = document.getElementById("switchPoint");
    var cp = document.getElementById("copyright");
    if (sp.className=='close')
    {
        sp.className='open';
        cp.colSpan=2;
        document.getElementById("frmTitle").style.display="none";
    }
    else
    {
        sp.className='close';
        cp.colSpan=3;
        document.getElementById("frmTitle").style.display="";
    }
}   
//-->
</script></head>
 

<body id="index" scroll="no">
<iframe name="iframe_data" style="display: none;"></iframe>
<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
    <tr>
        <td class="repeat_x header">
            <div class="left"><a href="#">智能DNS</a></div>
            <div class="right">
                <div>
                    <img src="img/user.gif"><?php echo $_SESSION['loginname']?><!-- 女士使用ico_user_female.gif -->
                </div>
                <div><a href="main.php?mod=member&action=logout" class="font_alert" onclick="return confirm('是否确认要退出登录？')" target="mainframe"><img src="img/logout.gif">退出</a></div>
                <div><a href="docs/gdm/index.html" target="_blank"><img src="img/help.gif">使用帮助</a></div>
            </div>
        </td>
    </tr>
    <tr>
        <td class="mainer">
            <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                <tr>
                    <td id="frmTitle" class="menu_outer" valign="top">
                        <iframe src="menu.php" style="height: 100%; visibility: inherit; width: 100%; z-index: 1; overflow: auto;" frameborder="0" scrolling="auto"></iframe>
                    </td>
                    <td class="switch" onclick="switchSysBar()">
                        <a href="#" id="switchPoint" class="close"></a>
                    </td>
                    <td class="main_outer">
                        <iframe src="main.php?act=sysinfo" style="height: 100%; visibility: inherit; width: 100%; z-index: 1; overflow: auto;" name="mainframe" frameborder="0" scrolling="auto"></iframe>
                    </td>
                </tr>
                <tr>
                    <td id="copyright" class="copyright" colspan="3" valign="middle">
                        <span>版本: 5.0.2-RELEASE[amd64]　<!--a href="usercp.php?module=devlog" target="mainframe">Update {$update_time}</a--></span>
                        Copyright&nbsp;?&nbsp;2011 <font><a href="http://www.forease.net/" target="_blank">实易科技</a>. All rights Reserved </font>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
<?php }?>