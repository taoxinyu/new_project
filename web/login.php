<?
//登陆判断
include('include/comm.php');
include("include/login_lock.class.php");
$Lock=new login_lock();//登陆锁定
if($Lock->is_lock()){
  $_SESSION["login_lock"]["time"]=time();
  showmessage('登录错误次数超过5次,请15分钟后再试',"index.php");
}
$username=$_POST['username'];
$password=md5($_POST['password']);
$sql = "select * from user where username='".$username."' and password='".$password."' and userstate=1 ";
$query=$db->query($sql);
$row = $db->fetchAssoc($query);
$myusergroup=$row['role_id'];
//$myusergroup=1;
/*
if(isset($_POST["vdcode"])&&$_POST["vdcode"]!=$_SESSION["vdcode"]){
Login_error_handler("验证码错误");
}
*/
if($myusergroup!='')
{
	//成功登陆
	$_SESSION['islogin']="1";
	$_SESSION['loginname']=$username;
	$_SESSION['loginip']=$_SERVER["REMOTE_ADDR"];
	$_SESSION['role']=$myusergroup;
	$db->query("insert into userlog (username,userip,userstate,addtime)values('".$username."','".$_SERVER['REMOTE_ADDR']."','成功登陆',datetime('now','localtime'))");
	$Lock->init_times();
	writelog($db,'登陆操作','用户'.$username.'登陆成功');
	Header ("Location:index.php");
}
else 
{
	//登陆失败
	$db->query("insert into userlog (username,userip,userstate,addtime)values('".$username."','".$_SERVER['REMOTE_ADDR']."','登陆失败',datetime('now','localtime'))");
	writelog($db,'登陆操作','用户'.$username.'登陆失败');
	Login_error_handler("用户名密码错误");
}
function Login_error_handler($error){
   global $Lock;
   $lost_times=$Lock->error_handler();
   showmessage(!$lost_times?$error.'！由于登录错误次数超过5次，请15分钟后再来登录!':$error.'！登陆失败,你还有'.$lost_times.'次机会',"index.php");
}
?>