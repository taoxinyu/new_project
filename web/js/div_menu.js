/* 菜单 */
function DivMenu()
{
    var oM = this;
    this.preBtnObj;

    this.bg_color = "#999";
    this.bg_opacity = 0.5;
    this.shadow_color = "#dddddd";
    this.shadow_offset = 5;

    this.mouseX;
    this.mouseY;
    
    this.bgObj;
    this.divObj;
    this.titleObj;
    this.bgObj;

    this.div_left;
    this.div_top;
    this.div_width;
    this.div_height;

    this.url;
    this.offset_x = 10;
    this.offset_y = 10;
    
    this.ifm;
    this.winObj;
    this.child_frame_id = "";

    // 点击打开一个菜单
    this.openMenu = function(e, menu_id, title, url, w, h, pos_type, is_set_bg, ico_name)
    {
        var evt = getEvent(e);
        this.closeDiv(evt);
        evt.cancelBubble = true; 

        // 如果是从嵌入的iframe中调用，刚要计算相对坐标
        var ifm_x = 0;
        var ifm_y = 0;
        if(oM.child_frame_id!='')
        {
            var ifm_pos = new findPos($(oM.child_frame_id));
            ifm_x = ifm_pos.left;
            ifm_y = ifm_pos.top;
        }

        oM.winObj = document.body?document.body:document.documentElement;
                
        var cw = oM.winObj.clientWidth;
        var ch = oM.winObj.clientHeight;
        var sw = oM.winObj.scrollWidth;
        var sh = oM.winObj.scrollHeight;
        var sl = oM.winObj.scrollLeft;
        var st = oM.winObj.scrollTop;

        this.url = url;                

        if (is_set_bg)
        {
            oM.createBg(cw, ch);
        }
        
        oM.createDiv(menu_id, title, w, h, ico_name);
        oM.output();       

        // 取得菜单层宽高
        this.div_width  = w;
        this.div_height = h;

        // 取得触发点坐标
        var btnObj = is_ie?evt.srcElement:evt.target;
        var posObj = new findPos(btnObj);  

        var div_x, div_y;
        if (!pos_type || pos_type == 0)
        {
            // 取得菜单层位置
            div_x = posObj.left + ifm_x;
            div_y = posObj.top + ifm_y;
        }
        if (pos_type == 2)
        {
            var mouse_x = is_ie?evt.x:evt.clientX;
            var mouse_y = is_ie?evt.y:evt.clientY;
            mouse_x += sl;
            mouse_y += st;

            div_x = mouse_x + ifm_x;
            div_y = mouse_y + ifm_y;
        }

        var btn_offset_h = btnObj.offsetHeight;
        var btn_offset_w = btnObj.offsetWidth;

        var menu_w,menu_h;
        if (h)
        {
            menu_w = parseInt(w);
            menu_h = parseInt(h);
        }
        else
        {
            menu_w = oM.divObj.scrollWidth;
            menu_h = oM.divObj.scrollHeight;
        }
        
        // 定位
        if (pos_type == 1)
        {
            this.div_left = parseInt((cw - menu_w)/2);
            this.div_top  = parseInt((sh - menu_h)/2);
        }
        else if (pos_type == 2)
        {
            this.div_left = (div_x + menu_w + this.offset_x > sw)?(div_x - menu_w - this.offset_x):(div_x + this.offset_x);
            this.div_top  =(div_y + menu_h + this.offset_y > sh)?(div_y - menu_h - this.offset_y):(div_y + this.offset_y);
        }
        else
        {
            this.div_left = (div_x + menu_w + btn_offset_w > cw)? (div_x - menu_w + btn_offset_w -2):(div_x + 1);
            this.div_top  = (div_y + menu_h + btn_offset_h > ch)? (div_y - menu_h - 1):(div_y + 1 + btn_offset_h);
        }

        if (is_ie && this.ifm && this.ifm.style.display == 'none')
        {
            this.ifm.style.display = '';
            this.ifm.style.width    = parseInt(oM.divObj.style.width)  + 'px';
            this.ifm.style.height   = parseInt(oM.divObj.style.height)  + 'px';
            this.ifm.style.left = this.div_left+"px";
            this.ifm.style.top  = this.div_top+"px";
        }

        if (is_ie&&!oM.ifm)
        {
            var ifm = document.createElement("iframe");
            ifm.id             = menu_id+"_iframe";
            ifm.style.display  = '';
            ifm.style.zIndex   = 5;
            ifm.style.position = 'absolute';
            ifm.style.width    = parseInt(oM.divObj.style.width)  + 'px';
            ifm.style.height   = parseInt(oM.divObj.style.height)  + 'px';
            ifm.style.left = this.div_left+"px";
            ifm.style.top  = this.div_top+"px";
            ifm.style.filter  = "alpha(opacity=0)";//ie有效
            ifm.style.opacity = 0;//firefox有效
            ifm.frameBorder = 0;
            oM.winObj.appendChild(ifm);
            oM.ifm = ifm;         
        }      
        // 显示菜单
        oM.divObj.style.left = this.div_left+"px";
        oM.divObj.style.top  = this.div_top+"px";

        addEvent(oM.titleObj, "mousedown", oM.dragDiv);
        return false;
    }

    this.createBg = function(width, height)
    {
        oM.bgObj = document.createElement("div");
        oM.bgObj.style.display = "";
        oM.bgObj.style.position = "absolute";
        oM.bgObj.style.zIndex = 2;
        oM.bgObj.style.backgroundColor = oM.bg_color;
        oM.bgObj.style.filter  = "alpha(opacity="+oM.bg_opacity * 100+")";//ie有效
        oM.bgObj.style.opacity = oM.bg_opacity;//firefox有效
        oM.bgObj.style.width  = width + 'px';
        oM.bgObj.style.height = height + 'px';
        oM.bgObj.style.top    = 0 + 'px';
        oM.bgObj.style.left   = 0 + 'px';
        oM.winObj.appendChild(oM.bgObj);   
    }

    this.createDiv = function(id, title, width, height, ico_name)
    {
        var title_id = id+'_title';
        var content_id = id+'_content';
        if ($(id))
        {
            removeElement($(id));
        }

        // 创建菜单层
        oM.divObj = document.createElement("div");
        oM.divObj.style.display = "";
        oM.divObj.style.position = "absolute";
        oM.divObj.id = id;
        oM.divObj.style.width  = width + 'px';
        oM.divObj.style.height = height + 'px';
        oM.divObj.style.zIndex = 6;
        oM.divObj.innerHTML = '<table border="0" cellpadding="0" cellspacing="0" class="common_pop_tbl" width="'+width+'"><tr><td class="part1" height="25"></td><td class="part2" id="'+title_id+'"><img src="/img/xface/ico/'+ico_name+'.gif"/>'+title+'<a href="#" onclick="DivMenu.closeDiv();"></a></td><td class="part3"></td></tr><tr><td class="part4"></td><td class="part5"><div class="common_tbl_outer" style="height:'+height+'px" id="'+content_id+'"></div></td><td class="part6"></td></tr><tr><td class="part7"></td><td class="part8"></td><td class="part9"></td></tr></table>';
        oM.winObj.appendChild(oM.divObj);

        oM.titleObj = $(title_id);
        oM.contentObj = $(content_id);
    }

    this.output = function()
    {
        var ajax = InitAjax();
        ajax.open("GET", this.url, true);
        ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        ajax.send(null);
        ajax.onreadystatechange = function()
        {
            if (ajax.readyState == 4 && ajax.status == 200)
            {
                if(ajax.responseText)
                {
                    oM.contentObj.innerHTML = ajax.responseText;
                }
            }
        }
    }

    this.dragDiv = function (e)
    {
        var evt = getEvent(e);
        oM.divObj.startDrag=true;

        var elmL = oM.divObj.style.left ? oM.divObj.style.left : 0;
        var elmT = oM.divObj.style.top  ? oM.divObj.style.top  : 0;

        oM.mouseX = evt.clientX - parseInt(elmL);
        oM.mouseY = evt.clientY - parseInt(elmT);

        addEvent(document, "mousemove", oM.startMove);
        addEvent(document, "mouseup", oM.endMove);
    }

    this.startMove = function(e)
    {
        var evt = getEvent(e);

        oM.divObj.style.left = (evt.clientX - oM.mouseX) + "px";
        oM.divObj.style.top  = (evt.clientY - oM.mouseY) + "px";
    
        if (is_ie)
        {
            oM.ifm.style.left = oM.divObj.style.left;
            oM.ifm.style.top  = oM.divObj.style.top;
        }
        return false;
    }

    this.endMove = function(e)
    {
        var evt = getEvent(e);
        oM.divObj.startDrag=false;

        removeEvent(document,"mousemove",oM.startMove);
        removeEvent(document,"mouseup",oM.endMove);
    }

    this.closeDiv = function(e)
    {
        if (oM.divObj)
        {
            oM.divObj.style.display = 'none';
        }

        if (oM.bgObj)
        {
            oM.bgObj.style.display = 'none';
        }
        
        if (oM.ifm)
        {
            oM.ifm.style.display = 'none';
        }
        return false;
    }

    // 关菜单
    this.docCloseDiv = function(e)
    {
        var evt = getEvent(e);

        // 取光标坐标
        var mouse_x = is_ie?evt.x:evt.clientX;
        var mouse_y = is_ie?evt.y:evt.clientY;
        mouse_x += oM.winObj.scrollLeft;
        mouse_y += oM.winObj.scrollTop;

        if (oM.divObj)
        {
            var div_width  = parseInt(oM.divObj.style.width);
            var div_height = parseInt(oM.divObj.style.height);
            var div_left = parseInt(oM.divObj.style.left);
            var div_top  = parseInt(oM.divObj.style.top);

            if(mouse_x < div_left - oM.offset_x 
            || mouse_x > div_left + div_width + oM.offset_x
            || mouse_y < div_top - oM.offset_y 
            || mouse_y > div_top + div_height + oM.offset_y)
            {
                if (oM.divObj)
                {
                    oM.divObj.style.display = 'none';
                }
                if (oM.bgObj)
                {
                    oM.bgObj.style.display = 'none';
                }
                
                if (oM.ifm)
                {
                    oM.ifm.style.display = 'none';
                }                
            }
        }
    }
}

var DivMenu = new DivMenu();
