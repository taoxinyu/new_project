<?php
include ('../include/comm.php');
include ('../mail/sendmail.php');
$rowmail=$db->fetchAssoc($db->query("select * from setmail"));


if($rowmail['dnShape']==1)
{
	exec( $rndccmd." status", $dnsstatus );	
	$dnsstatus = join( "<br>", $dnsstatus );
	//var_dump($dnsstatus);
	if($dnsstatus!=""){
		echo "DNS正常运行中....";
	}else 
	{
		$subject='DNS服务状态';
		$body='您的DNS服务目前处于关闭状态，特发此邮件通知。';
		$sendName=split('@',$rowmail['recMail']);
		sendMail($rowmail['recSmtp'],$sendName[0],$rowmail['recPWD'],$rowmail['recMail'],$subject,$body,$rowmail['sendMail']);
	}
}
?>