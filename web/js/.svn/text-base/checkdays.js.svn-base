
/*-----------开始开始开始开始开始开始开始开始开始开始开始开始开始开始开始开始开始开始------------------*/
//写入当月的起始天数
function creatMonth(str,start,end)
{
	var mDay=creatday(document.getElementById(str).value); 
	//var dayOfWeek=nowDayOfWeek(day);
	//var day=nowDay(day);
	//var month=nowMonth(day);
	//var year=nowYear(day);
	//alert(day);
	document.getElementById(start).value=getMonthStartDate(mDay);
	document.getElementById(end).value=getMonthEndDate(mDay);
}

//写入天
function creatOneDay(str,start,end)
{
	var strDay=document.getElementById(str).value;
	document.getElementById(start).value=strDay;
	document.getElementById(end).value=strDay;
	
}

//写入年
function creatYear(str,start,end)
{
	var yDay=creatday(document.getElementById(str).value);
	document.getElementById(start).value=getYearStartDay(yDay);
	document.getElementById(end).value=getYearEndDay(yDay);	
}

//写入周
function creatWeek(str,start,end)
{
	var wDay=creatday(document.getElementById(str).value);
	document.getElementById(start).value=getWeekStartDay(wDay);
	document.getElementById(end).value=getWeekEndDay(wDay);
}

//写入季度
function creatQuarter(str,start,end)
{
	var qDay=creatday(document.getElementById(str).value);
	document.getElementById(start).value=getQuarterStartDay(qDay);
	document.getElementById(end).value=getQuarterEndDay(qDay);
}

//获得本月的开始日期       
function getMonthStartDate(day){
    //var monthStartDate = new Date(nowYear(day),nowMonth(day),1);
    return formatDate(new Date(nowYear(day),nowMonth(day),1));      
}       

//获得本月的结束日期       
function getMonthEndDate(day){       
    //var monthEndDate = new Date(nowYear(day), nowMonth(day), getMonthDays(nowMonth(day),day));        
    return formatDate(new Date(nowYear(day), nowMonth(day), getMonthDays(nowMonth(day),day)));       
}

//获得本年的开始日期
function getYearStartDay(day){
	return formatDate(new Date(nowYear(day),0,1));
}

//获得本年的结束日期
function getYearEndDay(day){
	return formatDate(new Date(nowYear(day),11,31));
}
    
//获得本周的开始日期       
function getWeekStartDay(day) {        
    var weekStartDate = new Date(nowYear(day), nowMonth(day), nowDay(day)-nowDayOfWeek(day)+1);        
    return formatDate(weekStartDate);       
}        
     
//获得本周的结束日期       
function getWeekEndDay(day) {        
    var weekEndDate = new Date(nowYear(day), nowMonth(day), nowDay(day) + (7 - nowDayOfWeek(day)));        
    return formatDate(weekEndDate);       
}        

//获得本季度的开始日期       
function getQuarterStartDay(day){       
           
    var quarterStartDate = new Date(nowYear(day), getQuarterStartMonth(day), 1);        
    return formatDate(quarterStartDate);       
}  
     
//获得本季度的结束日期       
function getQuarterEndDay(day){       
    var quarterEndMonth = getQuarterStartMonth(day) + 2;       
    var quarterStartDate = new Date(nowYear(day), quarterEndMonth, getMonthDays(quarterEndMonth,day));      
    return formatDate(quarterStartDate);       
}

//获得某月的天数       
function getMonthDays(myMonth,day){       
    var monthStartDate = new Date(nowYear(day), myMonth, 1);        
    var monthEndDate = new Date(nowYear(day), myMonth + 1, 1);        
    var    days    =    (monthEndDate    -    monthStartDate)/(1000    *    60    *    60    *    24);  
    return    days;        
}       

//根据字符串创建日期
function creatday(str)
{
	var arys = new Array();
	arys = str.split('-');
	var day = new Date(arys[0],arys[1]-1,arys[2]);
	return day;
}

//获得周
function nowDayOfWeek(day)
{
	return day.getDay();
}

//获得日
function nowDay(day)
{
	return day.getDate(); 
}

//获得月
function nowMonth(day)
{
	return day.getMonth();
}

//获得年
function nowYear(day)
{
	theYear = day.getYear();
	theYear += (theYear < 2000) ? 1900 : 0;
	return theYear;
}
   
//获得本季度的开始月份       
function getQuarterStartMonth(day){       
    var quarterStartMonth = 0;       
    if(nowMonth(day)<3){       
        quarterStartMonth = 0;       
     }       
    if(2<nowMonth(day) && nowMonth(day)<6){       
        quarterStartMonth = 3;       
     }       
    if(5<nowMonth(day) && nowMonth(day)<9){       
        quarterStartMonth = 6;       
     }       
    if(nowMonth(day)>8){       
        quarterStartMonth = 9;       
     }       
    return quarterStartMonth;       
}       

//格式化日期：yyyy-MM-dd       
function formatDate(date) {        
    var myyear = date.getFullYear();       
    var mymonth = date.getMonth()+1;       
    var myweekday = date.getDate();           
    if(mymonth < 10){       
         mymonth = "0" + mymonth;       
     }        
    if(myweekday < 10){       
         myweekday = "0" + myweekday;       
     }       
    return (myyear+"-"+mymonth + "-" + myweekday);        
}