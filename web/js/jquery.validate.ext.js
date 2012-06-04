//字符验证         
jQuery.validator.addMethod("stringCheck", function(value, element){         
    return this.optional(element) || /^[\u0391-\uFFE5\w]+$/.test(value);         
}, "只能包括中文字、英文字母、数字和下划线");     
    
// 中文字两个字节         
jQuery.validator.addMethod("byteRangeLength", function(value, element, param) {         
    var length = value.length;         
    for(var i = 0; i < value.length; i++){         
        if(value.charCodeAt(i) > 127){         
        length++;         
        }         
    }         
    return this.optional(element) || ( length >= param[0] && length <= param[1] );         
}, "请确保输入的值在3-15个字节之间(一个中文字算2个字节)");     
    
// 身份证号码验证         
jQuery.validator.addMethod("isIdCardNo", function(value, element) {         
    return this.optional(element) || isIdCardNo(value);         
}, "请正确输入您的身份证号码");      
       
// 手机号码验证         
jQuery.validator.addMethod("isMobile", function(value, element) {         
    var length = value.length;     
    var mobile = /^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/;     
    return this.optional(element) || (length == 11 && mobile.test(value));         
}, "请正确填写您的手机号码");         
       
// 电话号码验证         
jQuery.validator.addMethod("isTel", function(value, element) {         
    var tel = /^\d{3,4}-?\d{7,9}$/;    //电话号码格式010-12345678     
    return this.optional(element) || (tel.test(value));         
}, "请正确填写您的电话号码");     

// 联系电话(手机/电话皆可)验证     
jQuery.validator.addMethod("isPhone", function(value,element) {     
    var length = value.length;     
    var mobile = /^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/;     
    var tel = /^\d{3,4}-?\d{7,9}$/;     
    return this.optional(element) || (tel.test(value) || mobile.test(value));     
    
}, "请正确填写您的联系电话");     

// 邮政编码验证         
jQuery.validator.addMethod("isZipCode", function(value, element) {         
    var tel = /^[0-9]{6}$/;         
    return this.optional(element) || (tel.test(value));         
}, "请正确填写您的邮政编码");
//IP地址验证
jQuery.validator.addMethod("isip", function(value, element) {         
    var tel = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
    return this.optional(element) || (tel.test(value));         
}, "请正确填写您的IP地址");
//IP和url地址验证
jQuery.validator.addMethod("isipurl", function(value, element) {         
    var ip = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
    var url= /^(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/;
	return this.optional(element) ||(ip.test(value))||(url.test(value));         
}, "IP或url地址格式错误(不要加http)");
//标识符验证
jQuery.validator.addMethod("mark", function(value, element) {         
    var tel = /^\w+$/;
    return this.optional(element) || (tel.test(value));         
}, "只能输入英文字母,数字和下划线");
jQuery.validator.addMethod("isips", function(value, element){
	var tel_ip = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
	var ips = value.split(",");
	var rs = true;
	for(var i = 0; i < ips.length; i++) {
		if(tel_ip.test(ips[i])){
			rs = true;
		}else{
			rs = false;
			break;
		}
	}
    return this.optional(element) || (rs);
}, "请输入正确的ip段");
jQuery.validator.addMethod("isipg", function(value, element){
	var tel_ip = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
	var tel_ipd = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\/(\d|1\d|2\d|3[0-2])$/;
	var ips = value.split("\n");
	var rs = true;
	for(var i = 0; i < ips.length; i++) {
		if(tel_ip.test(ips[i]) || tel_ipd.test(ips[i]) || ips[i]==""){
			rs = true;
		}else{
			rs = false;
			break;
		}
	}
    return this.optional(element) || (rs);
}, "请输入ip段,每行一个IP或一个IP段,格式如192.168.0.0/24或192.168.0.32");
jQuery.validator.addMethod("isport", function(value, element){
	var tel_port =/^[0-9]*[1-9][0-9]*$/;	
	var ports = value.split(",");
	//alert(ports[1]);
	var rs = true;
	for(var i = 0; i < ports.length; i++) {
		if(ports[i]>0 && ports[i]<65535 && tel_port.test(ports[i])){
			rs = true;
		}else{
			rs = false;
			break;
		}
	}
    return this.optional(element) || (rs);
}, "端口格式错误");
jQuery.validator.addMethod("isipm", function(value, element){
	var tel_ip = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
	var tel_mac = /^([0-9A-Fa-f]{2})(-[0-9A-Fa-f]{2}){5}|([0-9A-Fa-f]{2})(:[0-9A-Fa-f]{2}){5}$/;
	var values = value.split("\n");
	var rs = true;
	for(var i = 0; i < values.length; i++) {
		var va = values[i].split(" ");
		if(tel_ip.test(va[0]) && tel_mac.test(va['1']) || values[i]==""){
			rs = true;
		}else{
			rs = false;
			break;
		}
	}
    return this.optional(element) || (rs);
}, "请输入ip段,每行一个IP或一个IP段,格式如192.168.0.0/24或192.168.0.32");
jQuery.validator.addMethod("isipd", function(value, element){
	var tel_ip = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
	var tel_ipd = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])-(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/;
	var ips = value.split("\n");
	var rs = true;
	for(var i = 0; i < ips.length; i++) {
		if(tel_ip.test(ips[i]) || tel_ipd.test(ips[i]) || ips[i]==""){
			rs = true;
		}else{
			rs = false;
			break;
		}
	}
    return this.optional(element) || (rs);
}, "请输入ip段");
jQuery.validator.addMethod("isurl", function(value, element){
	var tel_url = /^([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
	var urls = value.split("\n");
	var rs = true;
	for(var i = 0; i < urls.length; i++) {
		if(tel_url.test(urls[i]) || urls[i]==""){
			rs = true;
		}else{
			rs = false;
			break;
		}
	}
    return this.optional(element) || (rs);
}, "请输入URL,<br>例如:<br>www.***.com<br>www.****.cn");
jQuery.validator.addMethod("isftype", function(value, element){
	var tel_ftype = /^\*\.(\w)+$/;
	var ftypes = value.split("\n");
	var rs = true;
	for(var i = 0; i < ftypes.length; i++) {
		if(tel_ftype.test(ftypes[i]) || ftypes[i]==""){
			rs = true;
		}else{
			rs = false;
			break;
		}
	}
    return this.optional(element) || (rs);
}, "文件类型格式不正确");
jQuery.validator.addMethod("daxiao", function(value, element, param){
	var target = $(param).unbind(".validate-daxiao").bind("blur.validate-daxiao", function() {
		$(element).valid();
	});
	return value <= target.val();
}, "保证带宽小于最大带宽");
jQuery.extend(jQuery.validator.messages, {
        required: "必填字段",
		remote: "请修正该字段",
		email: "请输入正确格式的电子邮件",
		url: "请输入合法的网址",
		date: "请输入合法的日期",
		dateISO: "请输入合法的日期 (ISO).",
		number: "请输入合法的数字",
		digits: "只能输入整数",
		creditcard: "请输入合法的信用卡号",
		equalTo: "请再次输入相同的值",
		accept: "请输入拥有合法后缀名的字符串",
		maxlength: jQuery.validator.format("请输入一个长度最多是 {0} 的字符串"),
		minlength: jQuery.validator.format("请输入一个长度最少是 {0} 的字符串"),
		rangelength: jQuery.validator.format("请输入一个长度介于 {0} 和 {1} 之间的字符串"),
		range: jQuery.validator.format("请输入一个介于 {0} 和 {1} 之间的值"),
		max: jQuery.validator.format("请输入一个最大为 {0} 的值"),
		min: jQuery.validator.format("请输入一个最小为 {0} 的值")
});
$.validator.errorPlacement=function(error, element) {
			// the errorPlacement has to take the table layout into account
            if( element.is(':radio') || element.is(':checkbox') ) {
            	//这里按实际项目变动
                error.appendTo(element.parent().parent().find('.status:first'));                   
            } else {
            	element.parent().next().find("span").remove();
                error.appendTo(element.parent().next());   
            }
        }
