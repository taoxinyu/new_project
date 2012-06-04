<?
date_default_timezone_set('PRC');
require_once('class.phpmailer.php');
set_mail_subject_ext();//设置邮件后缀
function sendMail($host,$sendName,$sendPWD,$sendAd,$subject,$body,$recAd)
{
	$mail = new PHPMailer();
	$mail->Mailer="smtp";
	$mail->CharSet = "GB2312"; // 设置编码
	$mail->IsSMTP();  // 使用SMTP
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Host       = $host; 	   // 设置 SMTP 服务器
	$mail->Port       = 25;                    // 设置端口
	$mail->Username   = $sendName; 	   			   // SMTP 用户名
	$mail->Password   = $sendPWD;                    // SMTP 密码
	
	$mail->Setfrom($sendAd);		//发件人地址
	$mail->Subject    = $subject.MAIL_SUBJECT_EXT;			//标题
	$mail->MsgHTML($body);    //内容
	$mail->AddAddress($recAd);   //收件人地址
	if(!$mail->Send()) {
		//echo "邮件发送的发件箱用户名或密码错误!";//echo "Mailer Error: " . $mail->ErrorInfo;
		//return false;
	} else {
		//echo "邮件发送失败，请确定DNS开启，并检查邮件设置!";
		//return true;
	}
}
//设置邮件后缀
function set_mail_subject_ext(){
global $db;
$query=$db->query("select * from setdns where dnsid=1");
$info=$db->fetch($query);
define('MAIL_SUBJECT_EXT',"-".$info['dnsdomain']."-".$info['dnsip']);
}
?>
