<?php
$Devversion='5000';
$topimg="images/frame/top".$Devversion.".jpg";
$dnsimg="images/frame/dns".$Devversion.".gif";
$netfacecss="css/dns".$Devversion.".css";
$loginimg="images/frame/login".$Devversion.".gif";
//$netface=array();
if($Devversion=='3000'){
$netface=array(1 => 'LAN1', 2 => 'LAN2', 3 => 'LAN3', 4 => 'LAN4', 5 => 'LAN5', 6 => 'LAN6' );
}else if($Devversion=='5000'){
$netface=array(0 => 'LAN0', 1 => 'LAN1', 2 => 'LAN2', 3 => 'LAN3', 4 => 'LAN4', 5 => 'LAN5' );	
}else if($Devversion=='6000'){
$netface=array(0 => 'ETH1', 1 => 'ETH2', 2 => 'ETH3', 3 => 'ETH4', 4 => 'GTH5', 5 => 'GTH6' );	
}if($Devversion=='8000'){
$netface=array(0 => 'GTH4', 1 => 'GTH5', 2 => 'GTH6', 3 => 'GTH7', 4 => 'ETH0', 5 => 'ETH1', 6 => 'ETH2', 7 => 'ETH3' );
}
?>
