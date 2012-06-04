// JavaScript Document
/*
作者：蓝浩勇
功能：页面输入检测
*/


//判断是否为邮件
function checkMail(mail)
{
	var exp=/(\S)+[@]{1}(\S)+[.]{1}(\w)+/;
    var reg = mail.value.match(exp);
    //var ErrMsg="您的输入有误，请于光标所在的输入框填写正确的邮箱地址！";   
	var ErrMsg="您的输入格式有误！";
    if(reg==null)
    {
        alert(ErrMsg);
		mail.value="";
		mail.focus();
		return true;
    }
    else
    {
		return false;
    }
	return false;
}

//判断是否为IP
function checkIP(ip)
{/*
	var exp=/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
    var reg = ip.value.match(exp);
    //var ErrMsg="您的输入IP有误，请于光标所在的输入框填写正确的IP地址！";  
	var ErrMsg="请正确填写您的IP地址";
    if(reg==null)
    {
        alert(ErrMsg);
		ip.value="";
		ip.focus();
		return true;
    }
    else
    {
		return false;
    }*/
	return false;
}

//判断是否为正整数
function checkInt(inputInt)
{
	var newPar=/^[0-9]*[1-9][0-9]*$/;
	if(newPar.test(inputInt.value))
	{
		return false;
	}
	else
	{
		//alert("您的输入有误，请于光标所在的输入框填写正整数！");
		alert("请填写正确的格式");
		inputInt.value="";
		inputInt.focus();
		return true;
	}
    return false;
}

//测试是否加载上
function aaa()
{
	alert("22222");
}

//判断是否有空格
function checkSpace(inputSpace)
{
	var checkInputSpace=inputSpace.value;
	if(checkInputSpace.indexOf(' ')>=0)
	{
		//alert("您的输入有误，光标所在位置的输入不能带有空格！");
		alert("请填写正确的格式");
		inputSpace.focus();
		return true;
	}
}