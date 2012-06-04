  function showOptions(opt) {

    if (opt.style.display == "none")
    {
      opt.style.display = "block";
      //opt.src = "/img/v1/folderopen.gif";
    }else {
      opt.style.display = "none";
      //opt.src = "/img/v1/folder.gif";
    }
    return true;
  }

  function showPage(url) {
    window.parent.location.href="/help/" + url;
  }

  function showMianOptions(opt,imgOpt) {

    if (opt.style.display == "none")
    {
      opt.style.display = "block";
      imgOpt.src = "/img/v2/main_10.gif";
    }else {
      opt.style.display = "none";
      imgOpt.src = "/img/v2/main_15.gif";
    }
    return true;
  }
  
  
/**
 * This array is used to remember mark status of rows in browse mode
 */
var marked_row = new Array;



/**
 * marks all rows and selects its first checkbox inside the given element
 * the given element is usaly a table or a div containing the table or tables
 *
 * @param    container    DOM element
 */
function markAllRows( container_id ) {
    var rows = document.getElementById(container_id).getElementsByTagName('tr');
    var unique_id;
    var checkbox;

    for ( var i = 0; i < rows.length; i++ ) {

        checkbox = rows[i].getElementsByTagName( 'input' )[0];

        if ( checkbox && checkbox.type == 'checkbox' ) {
            unique_id = checkbox.name + checkbox.value;
            if ( checkbox.disabled == false ) {
                checkbox.checked = true;
                if ( typeof(marked_row[unique_id]) == 'undefined' || !marked_row[unique_id] ) {
                    rows[i].className += ' marked';
                    marked_row[unique_id] = true;
                }
            }
        }
    }

    return true;
}

/**
 * marks all rows and selects its first checkbox inside the given element
 * the given element is usaly a table or a div containing the table or tables
 *
 * @param    container    DOM element
 */
function unMarkAllRows( container_id ) {
    var rows = document.getElementById(container_id).getElementsByTagName('tr');
    var unique_id;
    var checkbox;

    for ( var i = 0; i < rows.length; i++ ) {

        checkbox = rows[i].getElementsByTagName( 'input' )[0];

        if ( checkbox && checkbox.type == 'checkbox' ) {
            unique_id = checkbox.name + checkbox.value;
            checkbox.checked = false;
            rows[i].className = rows[i].className.replace(' marked', '');
            marked_row[unique_id] = false;
        }
    }

    return true;
}


        function selectRRType()
        {
            // Confirmation is not required in the configuration file
            // or browser is Opera (crappy js implementation)
            //~ if (typeof(window.opera) != 'undefined') {
                //~ return true;
            //~ }
            //~ var textmsg = '';

            var item = $("#rrType option:selected").val();

            //~ var item = $("select[@name=rrType] option[@selected]").text();

            //~ alert("lslsl"+actionForm.val() + item)
            //~ alert($("select[name=rrType] option[@selected]").text());
			if ( item == "SRV" ) {
				$('#typedesc').html("<font color='#FF0000'>记录值格式：权重 端口 主机名</font>");
			} else {
				$('#typedesc').text("");
			}
            //~ $('#recordData').html("<input class=\"common_input\"  type=text name=\"data\" id=\"rdata\" value=\""+
                //~ ( recordData.length > 0 ? recordData : "" ) +"\" maxlength=255>");
                
            $('#aux').attr('disabled','disabled');
            
            switch( item ) {
                case "A":
                    $('#showRRTypeDesc').text( "IPV4主机地址，格式如：192.168.0.1" );
                    $('#poolId').removeAttr('disabled');
                    //~ $('#recordData').html("<input class=\"common_input\"  type=text name=\"data\" id=\"rdata\" maxlength=255>");
                    
                    break;
                case "AAAA":
                    $('#showRRTypeDesc').text( "老式 IPV6 主机地址，不推荐使用。格式如：FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF" );
                    $('#poolId').attr('disabled','disabled');
                    $('#rdata').removeAttr('disabled');
                    //~ $('#recordData').html("<input class=\"common_input\"  type=text name=\"data\" id=\"rdata\" maxlength=255>");
                    break;
                case "A6":
                    $('#showRRTypeDesc').text( "IPV6 主机地址，格式如：FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF:FFFF" );
                    $('#rdata').removeAttr('disabled');
                    $('#poolId').attr('disabled','disabled');
                    //~ $('#recordData').html("<input class=\"common_input\"  type=text name=\"data\" id=\"rdata\" maxlength=255>");
                    break;
                case "CERT":
                    $('#showRRTypeDesc').text( "保持数字验证" );
                    $('#rdata').removeAttr('disabled');
                    $('#poolId').attr('disabled','disabled');
                    break;
                case "CNAME":
                    $('#showRRTypeDesc').text( "定义规范的别名" );
                    $('#rdata').removeAttr('disabled');
                    $('#poolId').attr('disabled','disabled');
                    //~ $('#recordData').html("<input class=\"common_input\"  type=text name=\"data\" id=\"rdata\" maxlength=255>");
                    break;
                case "DNAME":
                    $('#showRRTypeDesc').text( "于授权反查地址.使用另一个定义的查询名称取代域名.参见 RFC2672" );
                    $('#rdata').removeAttr('disabled');
                    $('#poolId').attr('disabled','disabled');
                    break;
                case "HINFO":
                    $('#showRRTypeDesc').text( "设定一台主机使用的 CPU 和 OS(操作系统)" );
                    $('#rdata').removeAttr('disabled');
                    $('#poolId').attr('disabled','disabled');
                    $('#typedesc').html("<font color='#FF0000'>记录值格式：\"CPU\" \"OS\"</font>");
                    break;
                case "KEY":
                    $('#showRRTypeDesc').text( "储存一个关于 DNS 名称的公共键" );
                    $('#rdata').removeAttr('disabled');
                    $('#poolId').attr('disabled','disabled');
                    break;
                case "MX":
                    $('#showRRTypeDesc').text( "设定域邮件交换.参见 See RFC 974" );
                    $('#rdata').removeAttr('disabled');
                    $('#poolId').attr('disabled','disabled');
                    $('#aux').removeAttr('disabled');
                    //~ $('#recordData').html("<input class=\"common_input\"  type=text name=\"data\" id=\"rdata\" maxlength=255>");
                    break;
                case "NAPTR":
                    $('#showRRTypeDesc').text( "名称授权指针" );
                    $('#rdata').removeAttr('disabled');
                    $('#poolId').attr('disabled','disabled');
                    //~ $('#recordData').html("<textarea name=\"data\" id=\"rdata\">" + ( recordData.length > 0 ? recordData : "" ) +"</textarea>");
                    $('#typedesc').html("<font color='#FF0000'>记录值格式：order pref \"flags\" \"service\" \"regexp\" \"replacement\"</font>");
                    break;
                case "NSAP":
                    $('#showRRTypeDesc').text( "网络服务接入指针" );
                    $('#rdata').removeAttr('disabled');
                    $('#poolId').attr('disabled','disabled');
                    break;
                case "NSAP-PTR":
                    $('#showRRTypeDesc').text( "网络服务接入指针反解地址" );
                    $('#rdata').removeAttr('disabled');
                    $('#poolId').attr('disabled','disabled');
                    break;
                case "NS":
                    $('#showRRTypeDesc').text( "域的授权名称服务器" );
                    $('#rdata').removeAttr('disabled');
                    $('#poolId').attr('disabled','disabled');
                    //~ $('#recordData').html("<input class=\"common_input\"  type=text name=\"data\" id=\"rdata\" maxlength=255>");
                    break;
                case "NXT":
                    $('#showRRTypeDesc').text( "用在 DNSSEC 中以安全的指出 RRS(有一个特定名称域间内的系主名)不在域中" );
                    $('#rdata').removeAttr('disabled');
                    $('#poolId').attr('disabled','disabled');
                    //~ $('#recordData').html("<input class=\"common_input\"  type=text name=\"data\" id=\"rdata\" maxlength=255>");
                    break;
                case "PTR":
                    $('#showRRTypeDesc').text( "指向其他域名空间部分的指针" );
                    $('#rdata').removeAttr('disabled');
                    $('#poolId').attr('disabled','disabled');
                    //~ $('#recordData').html("<input class=\"common_input\"  type=text name=\"data\" id=\"rdata\" maxlength=255>");
                    break;
                case "SIG":
                    $('#showRRTypeDesc').text( "(“签名机制”)在域名安全中的认证信息.细节见 RFC 2535" );
                    $('#rdata').removeAttr('disabled');
                    $('#poolId').attr('disabled','disabled');
                    //~ $('#recordData').html("<input class=\"common_input\"  type=text name=\"data\" id=\"rdata\" maxlength=255>");
                    break;
                case "SRV":
                    $('#showRRTypeDesc').text( "关于熟知的网络服务信息(代替 WKS)" );
                    $('#rdata').removeAttr('disabled');
                    $('#poolId').attr('disabled','disabled');
                    $('#aux').removeAttr('disabled');
                    
                    //~ $('#recordData').html("<input class=\"common_input\"  type=text name=\"data\" id=\"rdata\" maxlength=255>");
                    break;
                case "TXT":
                    $('#showRRTypeDesc').text( "文本记录" );
                    $('#rdata').removeAttr('disabled');
                    $('#poolId').attr('disabled','disabled');
                    //~ $('#recordData').html("<textarea name=\"data\" id=\"rdata\">" + ( recordData.length > 0 ? recordData : "" ) +"</textarea>");
                    break;
                case "URL":
                    $('#showRRTypeDesc').text( "URL转发" );
                    $('#rdata').removeAttr('disabled');
                    $('#poolId').attr('disabled','disabled');
                    //~ $('#recordData').html("<textarea name=\"data\" id=\"rdata\">" + ( recordData.length > 0 ? recordData : "" ) +"</textarea>");
                    break;
                default:
                    $('#showRRTypeDesc').text( "选择您需要添加的记录类型" );
                    break;
                }
                //~ $('#rdata').attr('value', recordData );
            return true;
        } // end of the 'selectCheckType()' function

        function poolSelectCheckAction()
        {
            // Confirmation is not required in the configuration file
            // or browser is Opera (crappy js implementation)

            if ( $("#poolId option:selected").val() == "none" ) {
                $('#rdata').removeAttr('disabled');
            }
            else
            {
                $('#rdata').attr('disabled','disabled');
            }

            return true;
        } // end of the 'poolSelectCheckAction()' function

        
function postFormData( data ) {
    var retval = false;
    //~ alert( "dddddddddddddddddddd"+data );
    if(data){
        jQuery.ajax({
            type:"post",
            url:"/main.php",
            data:data,
            dataType:"json",
            success:function(msg){
                alert(msg.status + ":" + msg.msg );
                if ( msg.url !== null ) {
                    //~ location.reload();
                    //~ document.execCommand('Refresh');
                    location.href = msg.url;
                    //~ alert( msg.url );
                    return msg.url;
                }
            }
        });
    }
    //~ alert( "llllll" );
    return false;
}

function postRemark() {
    //~ alert( "lslslslslsls" );
    var data = jQuery( "#remarkForm" ).dataForAjax(
    {
        showMessage:"showmessage",
        message:{
            "content":"对不起，标记内容不能为空"
            }
    }
    );
    
    var ret = postFormData( data );
    //~ alert( ret );
    //~ if ( ret != false ) {
        //~ alert( "reload...." );
        //~ location.reload(); 
    //~ }
}

function delRemark( id ) {
    if ( id < 1 ) {
        return false;
    }
    if ( confirm("是否要确认删除这条标注吗？") != true ) {
        return false;
    }
    $.ajax({
        type:"get",
        url:"/main.php",
        data:"mod=mark&act=del&id="+id,
        dataType:"json",
        success:function(msg){
            alert(msg.status + ":" + msg.msg);
            if ( msg.url != null ) {
                //~ alert( "llll" );
                window.location.reload(true);
            }
        }
    });
}




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

/**
 * 升级包下载
 * author Jonsen Yang
 * date 2010-10-04
 */
function updateDownload() {
    
    var doCounter = 0;
    var progress = 0;
    (function addDot() {
        setTimeout(function() {
            doCounter++;
            if ( doCounter > 1000 ) {
                $.cookie("download_timeout","true");
                $("#progress").html( "下载超时，请检查网络是否畅通" ); 
                return;
            }
            $.get("/plugins/downstats.php", function(data){
                progress = data;
            }); 
            if (progress <= 100) {
                $("#progress > span").css("width", parseInt(progress) + "%"); 
                $("#progress > span").html(parseInt(progress) + "%"); 
                //~ $('#downmsg').html(progress);
                
                if ( progress == 100 ) {
                    window.location.reload(true);
                }
                addDot();
              
            }
        }, 1500 );
    })();
}

function interfaceCheckAction() {
    var retval = false;
    var inter = $("#interface option:selected").val()
    //~ alert( "dddddddddddddddddddd:  "+ inter );

        jQuery.ajax({
            type:"get",
            url:"/main.php?mod=ifconfig&act=getif&n="+ inter,
            //~ data:data,
            dataType:"json",
            success:function(msg){
                //~ alert(msg.subnet + ":" + msg.mask );
                $("#subnet").attr( "value", msg.subnet);
                $("#mask").attr( "value", msg.mask);
                $("#dns").attr( "value", msg.dns);
                $("#gateway").attr( "value", msg.gateway);
                $("#range1").attr( "value", msg.range1);
                $("#range2").attr( "value", msg.range2);
                
                $("#rangeStart").html( msg.rangeStart);
                $("#rangeEnd").html( msg.rangeEnd);
            },
            error:function() {
              alert( "该接口没有配置IP地址，配置DHCP服务无效" );
              $("#interface").attr( "value", "none");
            }
            
        });

    //~ alert( "llllll" );
    return false;
}

  function testIP(s){  
    var arr=s.match(/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/);  
    if(arr==null)return false;  
    for(i=1;i<arr.length;i++)if(String(Number(arr[i]))!=arr[i]||Number(arr[i])>255)return false;  
    return true;  
  }   

function getIpNetwork() {
    
    var subnet = $("#subnet").val();
    var mask = $("#mask").val();
    var retval = false;
    //~ alert( "dddddddddddddddddddd:  "+ mask + subnet );
    
    if ( ! testIP( subnet ) || ! testIP( mask ) ) {
        //~ alert( subnet + "error" );
        return false;
    }
    
        
    jQuery.ajax({
        type:"get",
        url:"/main.php?mod=ifconfig&act=ipnetwork&net="+ subnet + "&mask=" + mask,
        dataType:"json",
        success:function(msg){
            //~ alert(msg.subnet + ":" + msg.mask );
            $("#subnet").attr( "value", msg.subnet);
            $("#mask").attr( "value", msg.mask);
            $("#range1").attr( "value", msg.range1);
            $("#range2").attr( "value", msg.range2);
        
            $("#rangeStart").html( msg.rangeStart);
            $("#rangeEnd").html( msg.rangeEnd);
        }
    });

    //~ alert( "llllll" );
    return false;
    
}


function getQueryCount() {
    jQuery.ajax({
        type:"get",
        url:"/main.php?act=getQueryCount",
        dataType:"json",
        success:function(msg){
             //~ alert( "llllll success "+msg.success );
            $("#success").text( msg.success);
            //~ $("#referral").text( msg.referral);
            $("#nxrrset").text( msg.nxrrset);
            $("#nxdomain").text( msg.nxdomain);
            $("#recursion").text( msg.recursion);
            $("#duplicate").text( msg.duplicate);
            //~ $("#dropped").text( msg.dropped);
            $("#failure").text( msg.failure);

        }
    });

    //~ alert( "llllll" );
    return false;
    
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
