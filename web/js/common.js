var userAgent = navigator.userAgent.toLowerCase();
var is_opera  = (userAgent.indexOf('opera') != -1);
var is_saf    = ((userAgent.indexOf('applewebkit') != -1) || (navigator.vendor == "Apple Computer, Inc."));
var is_webtv  = (userAgent.indexOf('webtv') != -1);
var is_ie     = ((userAgent.indexOf('msie') != -1) && (!is_opera) && (!is_saf) && (!is_webtv));

// 取对象
function $()
{
    var elements = new Array();
    for (var i = 0; i < arguments.length; i++)
    {
        var element = arguments[i];
        if (typeof element == 'string')
            element = document.getElementById(element);
        if (arguments.length == 1)
            return element;
        elements.push(element);
    }
    return elements;
}

function InitAjax()
{
    var http_request = false;

    if (window.XMLHttpRequest)
    {
        http_request = new XMLHttpRequest();
        if (http_request.overrideMimeType)
        {
            http_request.overrideMimeType('text/xml');
        }
    }
    else if (window.ActiveXObject)
    {
        try
        {
            http_request = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            try
            {
                http_request = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e)
            {}
        }
    }
    if (!http_request)
    {
        alert('Giving up :( Cannot create an XMLHTTP instance');
        return false;
    }
    return http_request;
}

function gotoBaidu(k)
{
	window.open('http://www.baidu.com/s?wd='+k+'&cl=3');
}

function inputNumber(e)
{
	evt = e ? e : (window.event ? window.event : null);
	var keycode = evt.keyCode || evt.which;
	if (keycode != 13)
	{
		return keycode>=48&&keycode<=57||keycode==46;
	}
}

// 提交
function doSubmit(actionForm, url, msg, target)
{
    if(msg)
    {
        if(confirm(msg ))
        {
            actionForm.form.action = url;
	    if (target)
	    {
		actionForm.form.target = target;
	    }
            actionForm.form.submit();
            return false;
        }
        else
        {
            return false;
        }
    }
    else
    {
	    actionForm.form.action = url;

		if (target)
		{
			actionForm.form.target = target;
		}

        actionForm.form.submit();
    }
}
// 跳转
function gotoUrl(url, msg, target)
{
    if ('' != msg)
    {
        if(confirm(msg))
        {
			if (target)
			{
				window.open(url, target);
			}
			else
			{
				window.location = url;
			}
            return false;
        }
    }
    else
    {
		if (target)
		{
			window.open(url, target);
		}
		else
		{
			window.location = url;
		}
        return false;
    }
}

function removeElement(element)
{
    if (element.parentNode)
    {
        element.parentNode.removeChild(element);
    }
}

function getEvent(e)
{
    e = e || window.event;
    return e;
}

function addEvent(obj, evenTypeName, fn){
    if (obj.addEventListener){
        obj.addEventListener(evenTypeName, fn, true);
        return true;
    } else if (obj.attachEvent){
        return obj.attachEvent("on"+evenTypeName, fn);
    } else {
        return false;
    }
}

function removeEvent(obj, evenTypeName, fn){
    if (obj.removeEventListener){
        obj.removeEventListener(evenTypeName, fn, true);
        return true;
    } else if (obj.detachEvent){
        var r = obj.detachEvent("on"+evenTypeName, fn);
        return r;
    } else {
        alert("Error.");
    }
}

function findPos(obj) {
    this.top=0;
    this.left=0;
    this.width=obj.offsetWidth;
    this.height=obj.offsetHeight;
    if (obj.offsetParent) {
        while (obj.offsetParent) {
            this.top += obj.offsetTop;
            this.left += obj.offsetLeft;
            obj = obj.offsetParent;
        }
    }
}

Number.prototype.NaN0=function(){return isNaN(this)?0:this;}
function getPos(e){
	var a=new Array()
	var t=e.offsetTop;
	var l=e.offsetLeft;
	var w=e.offsetWidth;
	var h=e.offsetHeight;
	while(e=e.offsetParent){
		t+=e.offsetTop + (e.currentStyle?(parseInt(e.currentStyle.borderTopWidth)).NaN0():0);
		l+=e.offsetLeft + (e.currentStyle?(parseInt(e.currentStyle.borderLeftWidth)).NaN0():0);
	}
	a['top']=t;a['left']=l;a['width']=w;a['height']=h;
    return a;
}

/* 取指定对象的x坐标 */
function getX(e)
{
  var l=e.offsetX;
  while(e=e.offsetParent){
    l+=e.offsetX;
    }
  return(l);
}

/* 取指定对象的y坐标 */
function getY(e)
{
  var t=e.offsetY;
  while(e=e.offsetParent){
    t+=e.offsetY;
    }
  return(t);
}

// [Cookie] Sets value in a cookie
function setCookie(cookieName, cookieValue, expires, path, domain, secure) 
{
	document.cookie =
		escape(cookieName) + '=' + escape(cookieValue)
		+ (expires ? '; expires =' + expires.toGMTString() : '')
		+ (path ? '; path=' + path : '')
		+ (domain ? '; domain=' + domain : '')
		+ (secure ? '; secure' : '');
}

// [Cookie] Gets a value from a cookie
function getCookie(cookieName)
{
	var cookieValue = '';
	var posName = document.cookie.indexOf(escape(cookieName) + '=');
	if (posName != -1) {
		var posValue = posName + (escape(cookieName) + '=').length;
		var endPos = document.cookie.indexOf(';', posValue);
		if (endPos != -1) cookieValue = unescape(document.cookie.substring(posValue, endPos));
		else cookieValue = unescape(document.cookie.substring(posValue));
	}
	return (cookieValue);
}

function changeVerifyCode(id, src)
{
    var o = $(id);

    // 随机一个数
    var r = Math.floor(Math.random()*1000+1);

    o.src = src+'#'+r;
}

// 展开
function expandIt(id, img_open, img_close)
{
	var obj_str  = "page_" + id;
	var icon_str = "icon_" + id;

	var pageObj = document.getElementById(obj_str);
	var iconObj = document.getElementById(icon_str);

	if(pageObj.style.display == "none")
	{
		if (iconObj)
		{
			iconObj.src = img_open;
		}
		
		pageObj.style.display = "";
	}
	else
	{
		if (iconObj)
		{
			iconObj.src = img_close;
		}
		
		pageObj.style.display = "none";
	}
}

// 全选
function checkAll(form)
{
    for (var i=0;i<form.elements.length;i++)
    {
        
        var e = form.elements[i];
        if (e.name != 'chkall')
        e.checked = form.chkall.checked;
    }
}

function chooseAllItem(event, formObj,bgcolor)
{
	var trObj;
    for (var i=0;i<formObj.elements.length;i++)
    {
        var e = formObj.elements[i];
        if (e.type == 'checkbox' && e.name != 'chkall')
		{
			e.checked = formObj.chkall.checked;
			trObj = e.parentNode.parentNode;
			if (trObj.nodeName == 'TR')
			{
				var inputs = trObj.getElementsByTagName("input");
				var inputs_num = inputs.length;
				for (var j=0; j<inputs_num ; j++)
				{
					if (inputs[j].type == 'checkbox')
					{
						inputs[j].checked = e.checked;
						if (inputs[j].checked == true)
						{
							trObj.style.backgroundColor=bgcolor;
						}
						else 
						{
							trObj.style.backgroundColor='';
						}
					}
				}
			}
		}
    }
}

// 检测长度
function checkLength(obj, n, viewObj, note)
{
	var n = parseInt(n);
    var num = obj.value.length;
    var arr = obj.value.match(/[^\x00-\x80]/ig);
    if(arr!=null)
	{
		num+=arr.length;
	}

	leave_num = n - num;
	
	if (n - num < 0)
	{
		viewObj.innerHTML = 0;

		if (note)
		{
			alert(note);
		}
		
		// 截取指定长度
		obj.value = obj.value.mb_substr(n);
	
		return false;
	}
	else
	{
		viewObj.innerHTML = leave_num;
	}
}

// 选择
function chooseItem(event,obj,bgcolor)
{
    event.cancelBubble=true;

    if (obj.type != 'checkbox')
    {
        var inputs = obj.getElementsByTagName("input");
        var inputs_num = inputs.length;
        for (var i=0; i<inputs_num ; i++)
        {
            if (inputs[i].type == 'checkbox')
            {
                if (inputs[i].checked == false)
                {
                    inputs[i].checked = true;
                    obj.style.backgroundColor=bgcolor;
                }
                else 
                {
                    inputs[i].checked = false;
                    obj.style.backgroundColor='';
                }
            }
        }
    }
    else
    {
        if (obj.checked == false)
        {
            obj.parentNode.parentNode.style.backgroundColor='';
        }
        else 
        {
            obj.parentNode.parentNode.style.backgroundColor=bgcolor;
        }
    }
}

String.prototype.mb_substr = function(n)
{
	var r = /[^\x00-\xff]/g;
	if(this.replace(r, "mm").length <= n) return this;
	n = n - 3;
	var m = Math.floor(n/2);
	for(var i=m; i<this.length; i++)
	{
		if(this.substr(0, i).replace(r, "mm").length>=n)
		{
			return this.substr(0, i)+'...';
		}
	}
	return this;
};

//表格隔行变色和悬停、选定样式[king]
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      oldonload();
      func();
    }
  }
}
function addClass(element,value) {
  if (!element.className) {
    element.className = value;
  } else {
    newClassName = element.className;
    newClassName+= " ";
    newClassName+= value;
    element.className = newClassName;
  }
}
function stripeTables() {
	var tables = document.getElementsByTagName("table");
	for (var m=0; m<tables.length; m++) {
		if (tables[m].id == "colortbl") {
			var tbodies = tables[m].getElementsByTagName("tbody");
			for (var i=0; i<tbodies.length; i++) {
				var odd = true;
				var rows = tbodies[i].getElementsByTagName("tr");
				for (var j=0; j<rows.length; j++) {
					if (odd == false) {
						odd = true;
					} else {
						addClass(rows[j],"odd");
						odd = false;
					}
				}
			}
		}
	}
}
function highlightRows() {
  if(!document.getElementsByTagName) return false;
  	var tables = document.getElementsByTagName("table");
	for (var m=0; m<tables.length; m++) {
		if (tables[m].id == "colortbl") {
			  var tbodies = tables[m].getElementsByTagName("tbody");
			  for (var j=0; j<tbodies.length; j++) {
				 var rows = tbodies[j].getElementsByTagName("tr");
				 for (var i=0; i<rows.length; i++) {
					   rows[i].oldClassName = rows[i].className
					   rows[i].onmouseover = function() {
						  if( this.className.indexOf("selected") == -1)
							 addClass(this,"highlight");
					   }
					   rows[i].onmouseout = function() {
						  if( this.className.indexOf("selected") == -1)
							 this.className = this.oldClassName
					   }
				 }
			  }
		}
	}
}
function selectRowCheckbox(row) {
	var checkbox = row.getElementsByTagName("input")[0];
	if (checkbox != undefined) {
        if (checkbox.checked == true) {
            checkbox.checked = false;
        } else
        if (checkbox.checked == false) {
            checkbox.checked = true;
        }
    }
}
function lockRow() {
  	var tables = document.getElementsByTagName("table");
	for (var m=0; m<tables.length; m++) {
		if (tables[m].id == "colortbl") {
				var tbodies = tables[m].getElementsByTagName("tbody");
				for (var j=0; j<tbodies.length; j++) {
					var rows = tbodies[j].getElementsByTagName("tr");
					for (var i=0; i<rows.length; i++) {
						rows[i].oldClassName = rows[i].className;
						rows[i].onclick = function() {
							if (this.className.indexOf("selected") != -1) {
								this.className = this.oldClassName;
							} else {
								addClass(this,"selected");
							}
                            selectRowCheckbox(this);
						}
					}
				}
		}
	}
}
window.onload = colorInput;
addLoadEvent(stripeTables);
addLoadEvent(highlightRows);
addLoadEvent(lockRow);

function lockRowUsingCheckbox() {
	var tables = document.getElementsByTagName("table");
	for (var m=0; m<tables.length; m++) {
		if (tables[m].id == "colortbl") {
			var tbodies = tables[m].getElementsByTagName("tbody");
			for (var j=0; j<tbodies.length; j++) {
				var checkboxes = tbodies[j].getElementsByTagName("input");
				for (var i=0; i<checkboxes.length; i++) {
					checkboxes[i].onclick = function(evt) {
						if (this.parentNode.parentNode.className.indexOf("selected") != -1){
							this.parentNode.parentNode.className = this.parentNode.parentNode.oldClassName;
						} else {
							addClass(this.parentNode.parentNode,"selected");
						}
						if (window.event && !window.event.cancelBubble) {
							window.event.cancelBubble = "true";
						} else {
							evt.stopPropagation();
						}
					}
				}
			}
		}
	}
}
addLoadEvent(lockRowUsingCheckbox);

/* 输入框focus等样式 [king] */
function colorInput() {
	var inputs = document.getElementsByTagName("input")
	var i;
	for(i=0;i<inputs.length;i++) {
		if(inputs[i].className == "login_input" || inputs[i].className == "common_input" || inputs[i].className == "common_date_input" || inputs[i].className == "common_num_input") {
			inputs[i].onfocus=function() {
                this.style.borderColor="#7EADD9";
                this.isfocus=true;
			}
            inputs[i].onmouseover=function() {
                this.style.borderColor="#7EADD9";
            }
			inputs[i].onblur=function() {
				this.style.borderColor="#B5B8C8";
                this.isfocus=false;
			}
            inputs[i].onmouseout=function() {
                if (!this.isfocus)
                {
                    this.style.borderColor="#B5B8C8";
                }
            }
		}
	}

    var textareas = document.getElementsByTagName("textarea")
	var i;
	for(i=0;i<textareas.length;i++) {
        textareas[i].onfocus=function() {
            this.style.borderColor="#7EADD9";
            this.isfocus=true;
        }
        textareas[i].onmouseover=function() {
            this.style.borderColor="#7EADD9";
        }
        textareas[i].onblur=function() {
            this.style.borderColor="#B5B8C8";
            this.isfocus=false;
        }
        textareas[i].onmouseout=function() {
            if (!this.isfocus)
            {
                this.style.borderColor="#B5B8C8";
            }
        }
	}
}

// ajax输出
function output(displayObj, url)
{
    var ajax = InitAjax();
    ajax.open("GET", url, true);
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send(null);
    ajax.onreadystatechange = function()
    {
        if (ajax.readyState == 4 && ajax.status == 200)
        {
            if(ajax.responseText)
            {
                displayObj.innerHTML = ajax.responseText;
                
            }
        }
    }
}

//简单表格换色，只有点击效果，不影响选择框的选择
function huanse(o,a,b,c,d){
	var t=document.getElementById(o).getElementsByTagName("tr");
	for(var i=0;i<t.length;i++){
		t[i].className=(t[i].sectionRowIndex%2==0)?a:b;
		t[i].onclick=function(){
			if(this.x!="1"){
				this.x="1";
				this.className=d;
			}else{
				this.x="0";
				this.className=(this.sectionRowIndex%2==0)?a:b;
			}
		}
		t[i].onmouseover=function(){
			if(this.x!="1")this.className=c;
		}
		t[i].onmouseout=function(){
			if(this.x!="1")this.className=(this.sectionRowIndex%2==0)?a:b;
		}
	}
}
