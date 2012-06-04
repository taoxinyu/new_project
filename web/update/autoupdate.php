<?//取出地址
include "conset.php";
$dbfile="pdo:database=/ximorun/ximodb/ximodb;";
$binddir="/etc/namedb/";
$db = new SQL($dbfile);
$query=$db->query("select * from setupdate where updateid=1");
$row=$db->fetchAssoc($query);
$url=$row['updateurl'];
$isopen=$row['updateis'];
if($isopen=='1'){
	$query=$db->query("select * from setacl where type=0");
	while($row=$db->fetchAssoc($query)){
		$geturl=$url.$row['aclident'];
		
		if(($cnc=file_get_contents( $geturl ))){
			writeFile($binddir."acl/".$row['aclident']."_M",$cnc);
			
			if (file_exists($binddir."acl/".$row['aclident']."_ADD")){
				$cnc = str_replace("};\n", "",$cnc);
				$cnc = str_replace("};", "",$cnc);
				$cip = file_get_contents($binddir."acl/".$row['aclident']."_ADD");
				$cnc = $cnc.$cip."\n};\n";
			}
			writeFile($binddir."acl/".$row['aclident'],$cnc);			
			$sql="insert into updatelog (updatetime,updateresult,updatecontent)values(datetime('now','localtime'),'".$row['aclident']."更新成功','".$row['aclname']."线路更新成功')";
			$db->query($sql);
		}else 
		{
			$sql="insert into updatelog (updatetime,updateresult,updatecontent)values(datetime('now','localtime'),'".$row['aclident']."更新失败','".$row['aclname']."线路更新失败')";
			$db->query($sql);
		}
	}
}
?>