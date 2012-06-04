/*
 * jQuery dataForAjax plug-in 1.0
 *
 * http://www.biuuu.com/
 * http://plugins.jquery.com/project/dataForAjax
 *
 * Copyright (c) 2009 biuuu.com
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
jQuery.fn.dataForAjax = function(options){
	var message = [];
	var error = [];
	var searchKey = '';
	var key;
	var data = '';
	var status = false;
	var id = "#"+this.get()[0].id;
	setting = jQuery.extend({
		showMessage:'showmessage',
		message:message
	},options);
	
	
	jQuery("#"+setting.showMessage).empty();
	
	for(key in setting.message){
		searchKey +=key+',';
	}
	
	jQuery( id+ "  :text").each(function(){
		var name = jQuery(this).attr("name");
		var value = jQuery(this).attr("value");
		if(((searchKey.indexOf(name)) != -1) && (value == '')){
			error.push(setting.message[name]);
			jQuery(this).focus(); 
			status = true;
			return false;
		}
		data += '&'+name+'='+value; 
	});
	
	jQuery( id+ "  :password").each(function(){
		var name = jQuery(this).attr("name");
		var value = jQuery(this).attr("value");
		if(((searchKey.indexOf(name)) != -1) && (value == '')){
			error.push(setting.message[name]);
			jQuery(this).focus(); 
			status = true;
			return false;
		}
		data += '&'+name+'='+value; 
	});
	
	jQuery( id+ "  textarea").each(function(){
		var name = jQuery(this).attr("name");
		var value = jQuery(this).val();
		if(((searchKey.indexOf(name)) != -1) && (value == '')){
			error.push(setting.message[name]);
			jQuery(this).focus(); 
			status = true;
			return false;
		}
		data += '&'+name+'='+value; 
	});	
	
	jQuery( id+ "  :radio:checked").each(function(){
		var name = jQuery(this).attr("name");
		var value = jQuery(this).attr("value");
		if(((searchKey.indexOf(name)) != -1) && (value == '')){
			error.push(setting.message[name]);
			jQuery(this).focus(); 
			status = true;
			return false;
		}
		data += '&'+name+'='+value; 
	});
	
	jQuery( id+ "  :checkbox:checked").each(function(){
		var name = jQuery(this).attr("name");
		var value = jQuery(this).attr("value");
		if(((searchKey.indexOf(name)) != -1) && (value == '')){
			error.push(setting.message[name]);
			jQuery(this).focus(); 
			status = true;
			return false;
		}
		data += '&'+name+'='+value; 
	});
	
	jQuery( id+ "  select option:selected").each(function(){
		var name = jQuery(this).parent("select").attr("name");
		var value = jQuery(this).attr("value");
		if(((searchKey.indexOf(name)) != -1) && (value == '')){
			error.push(setting.message[name]);
			jQuery(this).focus(); 
			status = true;
			return false;
		}
		data += '&'+name+'='+value; 
	});	
	
	jQuery( id+ "  :hidden").each(function(){
		var name = jQuery(this).attr("name");
		var value = jQuery(this).attr("value");
		if(((searchKey.indexOf(name)) != -1) && (value == '')){
			error.push(setting.message[name]);
			jQuery(this).focus(); 
			status = true;
			return false;
		}
		data += '&'+name+'='+value; 
	});	
	if(status){
		jQuery("#"+setting.showMessage).html(error.join(","));
		return '';
	}
	return data;
}