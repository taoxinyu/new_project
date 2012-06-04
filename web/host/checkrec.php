<?php
include("../mail/mailchecker.php");
header('Content-Type:text/html;charset=GB2312');
$mail=new email_validation_class($_GET['mail']);
if($mail->check())
{
	echo "<img src='../images/yes.gif' />恭喜您！邮件可用";
}
else 
{
	echo "<img src='../images/no.gif' />邮件不可用，请更换其他邮件";
}
?>
