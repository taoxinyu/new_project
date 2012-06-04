<?php
 include "../include/config.php";
 checklogin();
checkac();
//error_reporting(E_ALL | E_NOTICE);
$t="";
for($i=0;$i<sizeof($syslan);$i++)
{
	$iface_list[$i] = $syslan[$i][0];
	 $iface_title[$syslan[$i][0]] = '½Ó¿Ú'.$syslan[$i][1];
}
 
  
   
    $vnstat_bin ='/usr/local/bin/vnstat';
    $data_dir = '/var/db/vnstat';

    // graphics format to use: svg or png
    $graph_format='png';
    
    // Font to use for PNG graphs
    define('GRAPH_FONT','VeraBd.ttf');

    // Font to use for SVG graphs
    define('SVG_FONT', 'Verdana');

    // color schemes
    // colors are defined as R,G,B,ALPHA quads where R, G and B range from 0-255
    // and ALPHA from 0-127 where 0 is opaque and 127 completely transparent.
    //
    define('DEFAULT_COLORSCHEME', 'light');

    $colorscheme['light'] = array(
         'stylesheet'         => 'vnstat.css',
         'image_background'   => array( 255, 255, 255,   0 ),
	 'graph_background'   => array( 220, 220, 230,   0 ),
	 'graph_background_2' => array( 205, 205, 220,   0 ),
	 'grid_stipple_1'     => array( 140, 140, 140,   0 ),
         'grid_stipple_2'     => array( 200, 200, 200,   0 ),
	 'border'             => array(   0,   0,   0,   0 ),
	 'text'               => array(   0,   0,   0,   0 ),
	 'rx'                 => array( 190, 190,  20,  50 ),
	 'rx_border'	      => array(  40,  80,  40,  90 ),
	 'tx'	              => array( 130, 160, 100,  50 ),
	 'tx_border'          => array(  80,  40,  40,  90 )
     );

    // A red colorscheme based on a contribution by Enrico TrÃ¶ger
    $colorscheme['red'] = array(
         'stylesheet'         => 'vnstat_red.css',
         'image_background'   => array( 225, 225, 225,   0 ),
	 'graph_background'   => array( 220, 220, 230,   0 ),
	 'graph_background_2' => array( 205, 205, 220,   0 ),
	 'grid_stipple_1'     => array( 140, 140, 140,   0 ),
         'grid_stipple_2'     => array( 200, 200, 200,   0 ),
	 'border'             => array(   0,   0,   0,   0 ),
	 'text'               => array(   0,   0,   0,   0 ),
	 'rx'                 => array( 190,  20,  20,  50 ),
	 'rx_border'	      => array(  80,  40,  40,  90 ),
	 'tx'	              => array( 130, 130, 130,  50 ),
	 'tx_border'          => array(  60,  60,  60,  90 )
     );
?>
