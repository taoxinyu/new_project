<html>
<head>
<title> </title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
<link href="css/common.css" rel="stylesheet" type="text/css" media="screen">
<script language="javascript" src="js/function.js"></script>
<script language="JavaScript" type="text/javascript" src="js/common.js"></script>
<script language="JavaScript" type="text/javascript" src="js/div_menu.js"></script>
<script language="javascript" src="js/menu.js"></script>
</head>


<body id="menu">
<div class="top">
    <a href="javascript:d.openAll();" title="全部展开"><img src="img/openall.gif">全部展开</a>
    <a href="javascript:d.closeAll();" title="全部关闭"><img src="img/closeall.gif">全部关闭</a>
</div>
<div class="dtree">
<script >
        function confirmReboot() {
            return confirm('是否确认要重启系统？');
            //main.php?mod=sys&act=reboot
        }

        d = new dTree('d');

        d.add(0,-1,'系统首页','main.php?act=sysinfo','','mainframe');

        /* system infomation */
        d.add( 1000, 0, '系统状态', '', '', 'mainframe' );
        d.add( 1001, 1000, '统 计 图', 'main.php?mod=stats&action=graph', '', 'mainframe' );
        /* d.add( 1001, 1000, '统 计 图', '/dnsgraph.php', '', 'mainframe' ); */
        d.add( 1002, 1000, '查询统计', 'main.php?mod=stats&action=domain', '', 'mainframe' );
        d.add( 1003, 1000, '流量监控', 'main.php?mod=stats&action=net', '', 'mainframe' );
        d.add( 1004, 1000, '负载监控', 'main.php?mod=stats&action=cpu', '', 'mainframe' );
        d.add( 1005, 1000, '日志记录', 'main.php?mod=log&action=dns', '', 'mainframe' );
        
        /* services menu */
        d.add( 1100, 0, '服务管理', '', '', 'mainframe' );
        d.add( 1101, 1100, '域名管理', 'main.php?mod=domain&action=setdomain', '', 'mainframe' );
        d.add( 1102, 1100, '重启DNS', 'main.php?mod=sys&action=rebootdns" onclick="return confirm(\'是否确认要重启DNS服务？\');"', '', 'mainframe' );
        d.add( 1103, 1100, '线路管理', 'main.php?mod=view&action=list', '', 'mainframe' );
        d.add( 1104, 1100, 'DNS设置', 'main.php?mod=sys&action=setdns', '', 'mainframe' );
        d.add( 1105, 1100, '地 址 池', 'main.php?mod=pool&action=list', '', 'mainframe' );
        /*d.add( 1106, 1100, '监控报警', 'main.php?mod=alert&action=alert', '', 'mainframe' );*/
        d.add( 1107, 1100, 'DHCP服务', 'main.php?mod=dhcpd&action=list', '', 'mainframe' );
                        
        /* network config */
        d.add( 1200, 0, '网络设置', '', '', 'mainframe' );
        d.add( 1201, 1200, '网络设置', 'main.php?mod=ifconfig&action=general', '', 'mainframe' );
        d.add( 1202, 1200, '路由设置', 'main.php?mod=route&action=list', '', 'mainframe' );
        d.add( 1203, 1200, '安全设置', 'main.php?mod=firewall&action=list', '', 'mainframe' );
        d.add( 1204, 1200, 'SNMP设置', 'main.php?mod=sys&action=snmp', '', 'mainframe' );
        /* d.add( 1205, 1200, 'NAT 转换', 'main.php?mod=firewall&action=nat', '', 'mainframe' ); */
                
        d.add( 1300, 0, '系统功能', '', '', 'mainframe' );
        /* system config */
        d.add( 1301, 1300, '常规设置', 'main.php?mod=sys&action=sethost', '', 'mainframe' );
        d.add( 1302, 1300, '高级配置', 'main.php?mod=adv&action=ha', '', 'mainframe' );
        d.add( 1303, 1300, '实用工具', 'main.php?mod=tool&action=whois', '', 'mainframe' );
        d.add( 1304, 1300, '数据备份', 'main.php?mod=backup', '', 'mainframe' );
        d.add( 1305, 1300, '升级系统', 'main.php?mod=sys&action=update', '', 'mainframe' );
        d.add( 1306, 1300, '用户管理', 'main.php?mod=member&action=list', '', 'mainframe' );
        d.add( 1307, 1300, '重启系统', 'main.php?mod=sys&act=reboot" onclick="return confirm(\'是否确认要重启系统？\');"', '', 'mainframe' );
        d.add( 1308, 1300, '修改密码', 'main.php?mod=member&action=upPass', '', 'mainframe' );
        document.write(d);
        d.openAll();
        //-->
</script>
</div>
</body>
</html>