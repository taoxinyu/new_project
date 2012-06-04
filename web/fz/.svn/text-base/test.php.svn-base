<?
checklogin();
checkac();
include("../include/comm.php");
$aclfile="/etc/namedb/ximozone.conf";
	$acon=read_file($aclfile);
	
	//for($i=0;$i<=sizeof($dacl);$i++)
	//{
	//$sacl="CNC";
	//$dacl="EDU";
	$cacl="TELECOM";
		//½øÐÐÌæ»»
		//$a1="/".$sacl." /";
		//view \"view_".$cacl."\" {\\nmatch-clients { .* };\\n /";
		$a1="/view \"view_".$cacl."\" {\\nmatch-clients { .* };\\n/";
		$a2="\nview \"view_".$cacl."\" { \n match-clients1 { ".$cacl."; };\n";
		//$b1='/\\nmatch-clients { '.$dacl.' };\\n /';
		//echo $a1;
	//	$acon=preg_replace('/'.$sacl.';/',"none;", $acon);
		//$acon=preg_replace('/'.$dacl.';/',$dacl.";".$sacl.";", $acon);
		//$acon=preg_replace('/'.$cacl.';/',"none;", $acon);
	//	$acon=preg_replace('/'.$dacl.';/',$dacl.";".$cacl.";", $acon);
		$acon=preg_replace('/'.$cacl.';/','', $acon);
		$acon=preg_replace($a1,$a2, $acon);
	//}
	echo $a1."<br>".$a2."<BR>";
	echo $acon;
?>