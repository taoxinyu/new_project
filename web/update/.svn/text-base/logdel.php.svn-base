<?//È¡³öµØÖ·
include "conset.php";
$dbfile="pdo:database=/ximorun/ximodb/ximodb;";
$logdir="/xmdns/var/log/logback/";
$logbackdb="pdo:database=/ximorun/ximodb/dnslogdb;";
$db = new SQL($dbfile);
$query=$db->query("select * from logset where logid=1");
$row=$db->fetchAssoc($query);
$logdate=$row['logdate'];
$db->close();
$db=new SQL($logbackdb);
$query=$db->query("select * from dnslog where logname<date('now','localtime','-".$logdate." day')");
while($row=$db->fetchAssoc($query))
{
	$bb="/bin/rm ".$logdir.$row['doname'];
	exec($bb);		
}
$db->query("delete from dnslog where logname<date('now','localtime','-".$logdate." day')");
$db->close();
?>
