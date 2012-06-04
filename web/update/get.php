<?
 //exec( "/sbin/ping -c5 192.168.0.1", &$ping );
	
 //if (stristr($ping,"100% packet loss"))
//              	{echo "false";}else 
 //             	{echo "success";}
$url="http://www.zzci.com";
if(!(file($url))){die("<br><font color=red>不能连接服务器，请稍后再试!!</font>");}




?>