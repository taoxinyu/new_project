// +----------------------------------------------------------------------
// | LengdoFrame - 模块菜单函数库
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://lengdo.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Yangfan Dai <dmlk31@163.com>
// +----------------------------------------------------------------------
// $Id$


/* ------------------------------------------------------ */
// - 模块菜单树
/* ------------------------------------------------------ */

/**
 * 模块相关全局变量
 */
var MODULE_URL       = '';    //激活的模块URL

var MODULE_MTREE_ON  = null;  //选中的模块叶节点对象
var MODULE_MTREE_EXP = null;  //展开的模块根节点对象


/**
 * 点击模块菜单树
 */
function module_mtree_click( e )
{
    /* 事件源对象 */
    var src = e.target || e.srcElement;

	/* 模块项对象 */
	if( src.tagName.toLowerCase() == 'i' ){
		src = src.parentNode;
	}

	/* 选中节点 */
	if( src.className.indexOf('leaf') == 0 ){
        module_mtree_on_unique(src);
		module_mtree_on(src);
	}
	/* 闭合/展开子节点层 */
	else{
		var div = document.getElementById(src.id+'_');

		if( src.className.indexOf('on') == -1 ){
            module_mtree_expand_unique(src);
            module_mtree_expand(div);
			module_mtree_on(src);            
		}else{
            module_mtree_close(div);
			module_mtree_onr(src);
		}
	}
}

/**
 * 模块菜单树节点选中
 *
 * @params obj  obj  节点对象或者ID
 */
function module_mtree_on( obj )
{
	obj = typeof(obj) == 'object' ? obj : document.getElementById(obj);

	var len = obj.className.indexOf(' ');
	var cls = len == -1 ? obj.className : obj.className.substr(0, len);

	obj.className = cls +' '+ cls +'on';
}
/**
 * 模块菜单树恢复节点选中
 *
 * @params obj  obj  节点对象或者ID
 */
function module_mtree_onr( obj )
{
	obj = typeof(obj) == 'object' ? obj : document.getElementById(obj);

	var len = obj.className.indexOf(' ');
	var cls = len == -1 ? obj.className : obj.className.substr(0, len);

	obj.className = cls;
}

/**
 * 模块菜单树叶节点选中(撤销已选中的叶结点)
 *
 * @params obj  obj  要选中的叶节点
 */
function module_mtree_on_unique( obj )
{
    if( window.MODULE_MTREE_ON ){
        window.MODULE_MTREE_ON.className = 'leaf';
    }

    window.MODULE_MTREE_ON = obj;
}

/**
 * 模块菜单树展开
 *
 * @params mix  obj  要展开的层的对象或者ID
 */
function module_mtree_expand( obj )
{
	var obj = typeof(obj) == 'object' ? obj : document.getElementById(obj);
	if( obj ) obj.style.display = 'block';
}
/**
 * 模块菜单树闭合
 *
 * @params mix  obj  要闭合的层的对象或者ID
 */
function module_mtree_close( obj )
{
	var obj = typeof(obj) == 'object' ? obj : document.getElementById(obj);
	if( obj ) obj.style.display = 'none';
}

/**
 * 模块菜单树根节点展开(闭合已展开的根节点)
 *
 * @params obj  obj  要展开的根节点
 */
function module_mtree_expand_unique( obj )
{
    if( obj.className.indexOf('root') == -1 ) return ;

    if( window.MODULE_MTREE_EXP ){
        module_mtree_onr(window.MODULE_MTREE_EXP);
        module_mtree_close(window.MODULE_MTREE_EXP.id+'_');
    }

    window.MODULE_MTREE_EXP = obj;
}


/**
 * 模块请求，设置模块URL
 *
 * @params str  uri       要请求模块的地址
 * @params bol  reload    重新载入，默认false
 * @params fun  complete  显示完成后执行
 */
function module_mtree_request( uri, reload, complete )
{
    /* 获取无搜索参数的URL */
    var url = uri.indexOf('?') == -1 ? uri : uri.substr(0, uri.indexOf('?'));

    /* 获取要请求的模块层 */
    var div = document.getElementById(url);

    /* 初始化参数 */
    reload = reload === true ? true : false;

    /* 请求的模块层已存在并且不重新载入 */
    if( div && reload === false ){
        /* 请求的模块层已显示 */
        if( window.MODULE_URL == url ) return true;

        /* 隐藏已显示的模块层 */
        try{ document.getElementById(window.MODULE_URL).style.display = 'none'; }catch(e){}

        /* 显示请求的模块层 */
        div.style.display = '';

        /* 设置显示层的ID */
        window.MODULE_URL = url;

        /* 执行自定义函数 */
        if( typeof(complete) == 'function' ){
            complete();
        }
    }else{
        /* 回调函数 */
        function callback( result, text ){
            if( div ){
                /* 重新载入模块层内容 */
                div.innerHTML = text;
            }else{
                /* 创建模块层 */
                div = document.createElement('DIV');

                /* 设置ID */
                div.id = url;

                /* 添加模块层内容 */
                div.innerHTML = text;

                /* 追加模块层到容器 */
                document.getElementById('layout-rht').appendChild(div);
            }

            /* 显示追加的模块层 */
            module_mtree_request(url, false, complete);
        }

        /* 请求模块内容(异步等待) */
        Ajax.call(uri, '', callback, 'POST', 'TEXT', true);
    }
}