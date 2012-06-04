<?php
    //
    // vnStat PHP frontend 1.4.1 (c)2006-2008 Bjorge Dijkstra (bjd@jooz.net)
    //
    // This program is free software; you can redistribute it and/or modify
    // it under the terms of the GNU General Public License as published by
    // the Free Software Foundation; either version 2 of the License, or
    // (at your option) any later version.
    //
    // This program is distributed in the hope that it will be useful,
    // but WITHOUT ANY WARRANTY; without even the implied warranty of
    // MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    // GNU General Public License for more details.
    //
    // You should have received a copy of the GNU General Public License
    // along with this program; if not, write to the Free Software
    // Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
    //
    //
    // see file COPYING or at http://www.gnu.org/licenses/gpl.html 
    // for more information.
    //
if(isset($_GET['if']))
{
$if=$_GET['if'];
}else
{
$if="em0";
}
    require 'config.php';
    require 'vnstat.php';

    function write_side_bar()
    {
        global $iface, $page, $graph, $script, $style;
        global $iface_list, $iface_title;   
        global $page_list, $page_title;
        
        $p = "&amp;graph=$graph&amp;style=$style";

        print "<ul class=\"iface\">\n";
        foreach ($iface_list as $if)
        {
            print "<li class=\"iface\">";
            if (isset($iface_title[$if]))
            {
                print $iface_title[$if];
            }
            else
            {
                print $if;
            }
            print "<ul class=\"page\">\n";
            foreach ($page_list as $pg)
            {
                print "<li class=\"page\"><a href=\"$script?if=$if$p&amp;page=$pg\">".$page_title[$pg]."</a></li>\n";
            }
            print "</ul></li>\n";
	    
        }
        print "</ul>\n"; 
    }
    

    function kbytes_to_string($kb)
    {
        $units = array('TB','GB','MB','KB');
        $scale = 1024*1024*1024;
        $ui = 0;

        while (($kb < $scale) && ($scale > 1))
        {
            $ui++;
            $scale = $scale / 1024;
        }   
        return sprintf("%0.2f %s", ($kb/$scale),$units[$ui]);
    }
    
    function write_summary()
    {
        global $summary,$top,$day,$hour,$month;
     if(isset($summary['totalrxk'])){
        $trx = $summary['totalrx']*1024+$summary['totalrxk'];
        $ttx = $summary['totaltx']*1024+$summary['totaltxk'];
}else
{ $trx = 0;
        $ttx = 0;
}
        //
        // build array for write_data_table
        //
        $sum[0]['act'] = 1;
        $sum[0]['label'] = '本小时';
        $sum[0]['rx'] = $hour[0]['rx'];
        $sum[0]['tx'] = $hour[0]['tx'];

        $sum[1]['act'] = 1;
        $sum[1]['label'] = '本天';
        $sum[1]['rx'] = $day[0]['rx'];
        $sum[1]['tx'] = $day[0]['tx'];

        $sum[2]['act'] = 1;
        $sum[2]['label'] = '本月';
        $sum[2]['rx'] = $month[0]['rx'];
        $sum[2]['tx'] = $month[0]['tx'];

        $sum[3]['act'] = 1;
        $sum[3]['label'] = '所有时间';
        $sum[3]['rx'] = $trx;
        $sum[3]['tx'] = $ttx;

        write_data_table('总计', $sum);
        print "<br/>\n";
        write_data_table('最大的十天', $top);
    }
    
    
    function write_data_table($caption, $tab)
    {
        print "<table width=\"100%\" cellspacing=\"0\">\n";
        print "<caption>$caption</caption>\n";
        print "<tr height=25>";
        print "<th class=\"label\" height=25 style=\"width:180px;\">&nbsp;</th>";
        print "<th class=\"label\" height=25 align=right>流入</th>";
        print "<th class=\"label\" height=25 align=right>流出</th>";
        print "<th class=\"label\" height=25 align=right>总计</th>";  
        print "</tr>\n";

        for ($i=0; $i<count($tab); $i++)
        {
            if ($tab[$i]['act'] == 1)
            {
                $t = $tab[$i]['label'];
                $rx = kbytes_to_string($tab[$i]['rx']);
                $tx = kbytes_to_string($tab[$i]['tx']);
                $total = kbytes_to_string($tab[$i]['rx']+$tab[$i]['tx']);
                $id = ($i & 1) ? 'odd' : 'even';
                print "<tr height=25>";
                print "<td class=\"label_$id\" height=25>$t</td>";
                print "<td class=\"numeric_$id\" height=25>$rx</td>";
                print "<td class=\"numeric_$id\" height=25>$tx</td>";
                print "<td class=\"numeric_$id\" height=25>$total</td>";
                print "</tr>\n";
             }
        }
        print "</table>\n";
    }

    validate_input();
    get_vnstat_data();

    //
    // html start

   // print '<?xml version="1.0"
   ?>
   <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="refresh" content="300" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="cache-control" content="no-cache" />
<title>流量监控</title>
<link href="../divstyle.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?php echo $colorscheme[$style]['stylesheet']; ?>"/>

</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="28" align="left" background="../images/bg_topbg.gif">&nbsp;当前位置:&gt;&gt; 网络流量监控 </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <table width="768" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#82C4E8">
        <tr>
          <td width="757" height="25" colspan="2" align="center" bgcolor="#D7F5F9" class="greenbg"><?php print $iface_title[$iface].' ('.$iface.')';?>网络接口流量监控</td>
        </tr>
         <tr>
          <td width="757" height="25" colspan="2" align="left" bgcolor="#D7F5F9" class="graybg">请选择网络接口：
            <select onchange="window.location='?graph=large&style=light&page=d&if='+this.value" size="1" name="if">
       <?include "../include/config.php";
       for($i=0;$i<sizeof($syslan);$i++){?>
        <option value="<?echo $syslan[$i][0]?>" <? if($if==$syslan[$i][0]){echo "selected=selected";}?>><?echo $syslan[$i][1]?></option>
        <?}?>
     
      </select> <a href="?if=<? echo $if?>">总统计</a> <a href="?if=<? echo $if?>&graph=large&style=light&page=h">小时统计</a> <a href="?if=<? echo $if?>&graph=large&style=light&page=d">按日统计</a> <a href="?if=<? echo $if?>&graph=large&style=light&page=m">按月统计</a> </td>
        </tr>
        
        <tr>
		
          <td height="200" colspan="2" align="left" valign="top" bgcolor="#FFFFFF" class="graytext"> <div id="main"> <?php
    $graph_params = "if=$iface&amp;page=$page&amp;style=$style";
    if ($page != 's')
        if ($graph_format == 'svg') {
	     print "<object type=\"image/svg+xml\" width=\"692\" height=\"297\" data=\"graph_svg.php?$graph_params\"></object>\n";
        } else {
	     print "<img src=\"graph.php?$graph_params\" alt=\"graph\"/>\n";	
        }

    if ($page == 's')
    {
        write_summary();
    }
    else if ($page == 'h')
    {   
        write_data_table('最近24小时统计', $hour); 
    }
    else if ($page == 'd')
    {
        write_data_table('最近30天统计', $day);	
    }
    else if ($page == 'm')
    {
        write_data_table('最近12个统计', $month);   
    }
    ?></div></td>
        </tr>
        
      </table>
       
    </td>
  </tr>
</table><? include "../include/config.php";?><? include "../copyright.php";?>
</body>
</html>
