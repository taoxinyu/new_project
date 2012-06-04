<?
//清除登陆的cook
include ('include/comm.php');
checklogin();
writelog($db,'退出操作','用户'.$_SESSION['loginname'].'退出成功');
unset($_SESSION['islogin']); 
unset($_SESSION['loginname']); 
unset($_SESSION['loginip']); 
//unset($_SESSION['reboot']); 
//  这种方法是销毁整个 Session 文件
session_destroy();

$db->close();
showmessage('退出成功!','index.php');

?>
