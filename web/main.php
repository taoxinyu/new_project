<?php

$mods = array("domain", "stats", "log", "sys", "view", "pool", "dhcpd", "ifconfig", "route", "firewall", "adv", "tool", "backup", "member");
$lis = array(
	'domain' => array(),
	'stats' => array(),
	'log' => array(),
	'sys' => array(),
	'view' => array(),
	'pool' => array(),
	'dhcpd' => array(),
	'ifocnfig' => array(),
	'route' => array(),
	'firewall' => array(),
	'adv' => array(),
	'tool' => array(),
	'backup' => array(),
	'member' => array()
);

$stats = array(
	'domain' => 'dns/query.php',
	'net' => 'state/reallan.php',
	'list' => 'dns/setdns.php',
);
$member = array(
	'logout' => 'exit.php'
);
$log = array(
	'dns' => 'log/dnslog.php'
);
$view = array(
    'list'=> 'dns/acl.php'
	
	);
$domain = array(
'setdomain' => 'dns/domain.php'
);
$sys = array(
  'sethost' => 'host/sethost.php',
  'setdns' => 'dns/setdns.php'

 );
$map = array(
	'stats' => $stats,
	'member' => $member,
	'log' => $log,
	'domain' => $domain,
	'view' => $view,
	'sys' => $sys,
	'pool' => $pool,
	'dhcpd' => $dhcpd,
	'ifocnfig' => $ifconfig,
	'route' => $route,
	'firewall' => $frewall,
	'adv' => $adv,
	'tool' => $tool,
	'backup' => $backup,
	'member' => member
);

$mod = $_GET['mod'];
$action = $_GET['action'] ? $_GET['action'] : $_GET['act'];
if($mod != '')
	$file = $map[$mod][$action];
else
	$file = $action.'.php';
?>
<html>
<head>
<title> </title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
<link href="css/common.css" rel="stylesheet" type="text/css" media="screen">

<script language="javascript" type="text/javascript" src="js/jquery_002.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<!--script type="text/javascript" src="/img/prototype.js"></script-->
<script language="javascript" src="js/function.js"></script>
<script language="JavaScript" type="text/javascript" src="js/common.js"></script>
<script language="JavaScript" type="text/javascript" src="js/div_menu.js"></script>
<!--[if IE]>
<link href="css/ie.css" rel="stylesheet" type="text/css" media="screen" />
<![endif]-->
</head>
 
<body id="mainframe" scroll="no">
<table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td class="header">
            <?php if($mod == 'domain') {?>
            	<ul class="common_tab">
	            <li><a href="main.php?mod=domain&action=setdomain" class="on"><span>域名列表</span></a></li>
	            </ul>
            	<div class="common_help">域名列表 </div>
            <?php } elseif($mod == 'stats'){ ?>
            	<ul class="common_tab">
	            <li><a href="main.php?mod=stats&action=graph" class="<?php if($action == 'graph') echo 'on'; else echo 'off';?>"><span>统计图</span></a></li>
	            <li><a href="main.php?mod=stats&action=domain" class="<?php if($action == 'domain') echo 'on'; else echo 'off';?>"><span>查询统计</span></a></li>
	            <li><a href="main.php?mod=domain&action=add" class="<?php if($action == '') echo 'on'; else echo 'off';?>"><span>线路统计</span></a></li>
	            <li><a href="main.php?mod=stats&action=net" class="<?php if($action == 'net') echo 'on'; else echo 'off';?>"><span>流量监控</span></a></li>
	            <li><a href="main.php?mod=stats&action=cpu" class="<?php if($action == 'cpu') echo 'on'; else echo 'off';?>"><span>负载监控</span></a></li>
	            </ul>
            	<div class="common_help">线路查询统计</div>            
            <?php } elseif($mod == 'log') {?>
            	<ul class="common_tab">
	            <li><a href="main.php?mod=domain&action=list" class="on"><span>日志记录</span></a></li>
	            </ul>
            	<div class="common_help">日志记录</div>  
            <?php } elseif($mod == 'sys') {?>
            	<ul class="common_tab">
	            <li><a href="main.php?mod=sys&action=sethost" class="on"><span>常规设置</span></a></li>
	            <li><a href="main.php?mod=sys&action=setdns" class="off"><span>DNS设置</span></a></li>
	            <li><a href="main.php?mod=domain&action=add" class="off"><span>SSH服务</span></a></li>
	            <li><a href="main.php?mod=domain&action=search" class="off"><span>SNMP设置</span></a></li>
	            <li><a href="main.php?mod=dimport&action=show" class="off"><span>升级系统</span></a></li>
	           
 </ul>
            	<div class="common_help">常规设置</div>  
            <?php } elseif($mod == 'view') {?>
            	<ul class="common_tab">
	            <li><a href="main.php?mod=view&action=lists" class="on"><span>线路列表</span></a></li>

				
	            </ul>
            	<div class="common_help">线路列表</div>  
            
            <?php } elseif($mod == 'pool') {?>
			    <ul class="common_tab">
	            <li><a href="main.php?mod=domain&action=list" class="on"><span>地址池列表</span></a></li>
	            <li><a href="main.php?mod=domain&action=addRecord" class="off"><span>添加地址池</span></a></li>
	            <li><a href="main.php?mod=domain&action=add" class="off"><span>添加主机</span></a></li>
				
	            </ul>
            	<div class="common_help">地址池列表</div>  
            
            <?php } elseif($mod == 'dhcpd') {?>
            			    <ul class="common_tab">
	            <li><a href="main.php?mod=domain&action=list" class="on"><span>分配列表</span></a></li>
	            <li><a href="main.php?mod=domain&action=addRecord" class="off"><span>WAN接口</span></a></li>
	            <li><a href="main.php?mod=domain&action=add" class="off"><span>LAN接口</span></a></li>
	            <li><a href="main.php?mod=domain&action=list" class="on"><span>MGMT接口</span></a></li>
	            <li><a href="main.php?mod=domain&action=addRecord" class="off"><span>DHCP配置</span></a></li>
	            <li><a href="main.php?mod=domain&action=add" class="off"><span>添加地址段</span></a></li>
	            <li><a href="main.php?mod=domain&action=add" class="off"><span>运行状态</span></a></li>					
	            </ul>
            	<div class="common_help">分配列表</div>  
            <?php } elseif($mod == 'ifconfig') {?>
            
            <?php } elseif($mod == 'route') {?>
            
            <?php } elseif($mod == 'firewall') {?>
            
            <?php } elseif($mod == 'adv') {?>
            
            <?php } elseif($mod == 'tool') {?>
            
            <?php } elseif($mod == 'backup') {?>
            
            <?php } elseif($mod == 'member') {?>
            
            <?php } elseif($mod == '') {?>
            	<ul class="common_tab">
            	<li><a href="main.php?act=sysinfo" class="on"><span>系统首页</span></a></li>
            	</ul>
            	<div class="common_help">系统运行信息</div>
            <?php }?>
            
        </td>
    </tr>
    <tr>
        <td class="mainer">
            <table height="100%" width="100%" border="0" cellpadding="0" cellspacing="0">
                <tbody><tr>
                    <td class="main_outer">
                        <iframe name="frameMain" src="<?php echo $file;?>" style="height: 100%; visibility: inherit; width: 100%; z-index: 1; overflow: auto;" frameborder="0" scrolling="yes"></iframe>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</table>
</body>
</html>