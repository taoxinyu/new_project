<?
checklogin();
checkac();
echo getstate($_GET['ip']);

  function getstate($ip)
      {
   
      		 exec( "/sbin/ping -c3 ".$ip, &$ping);	
      		 $ping = join( "<br>", $ping );
      		 
			 if (stristr($ping,"100.0% packet loss"))
              	{return "不通状态";}else 
             	{return  "正常状态";}
      	}
     
      ?>