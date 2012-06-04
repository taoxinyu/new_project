<?php
include ('../include/comm.php');
$pageaccess=1;
checklogin();
checkac();

$query = $db->query("select * from netface order by facename");
while($row = $db->fetch_array($query)){
$eths[] = $row['facename'];
}
$eth = $eths[0];
if (isset($_GET['eth'])){
$eth = $_GET['eth'];
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta http-equiv="X-UA-Compatible" content="IE=7"/>
<title>无标题文档</title>
<link href="../ximo_dns.css" rel="stylesheet" type="text/css" />

<style>
.STYLE5 {font-size: large}
.s td.whitebg{background:#ffffff; text-align:left;}
</style>
<script type="text/javascript" src="../js/jquery.js"></script>
<script src="../js/checkdays.js"></script>
<script src="../js/setdate.js"></script>
<script type="text/javascript" src="../js/ximo_dns.js"></script>
<script language="javascript">

 TreeNode = function(name, data, parentNode)
 {
  this.name = name;
  this.parentNode = parentNode;
  this.data = data;
  this.childNodes = [];
 
  this.addChildNode = function(node)
  {
   node.parentNode = this;
   this.childNodes.push(node);
   return this;
  }
 
  this.fullSelected = function()
  {
   for(var index=0;index<this.childNodes.length;index++)
   {
    if(!this.childNodes[index].data.checked)
    {
     return;
    }
   }
   this.data.checked = true;
   if(this.parentNode){
    
    this.parentNode.fullSelected();
   }
  }
 
  this.select = function()
  {
   this.data.checked = true;
   var this_length=this.childNodes.length;
   for(var index=0;index<this_length;index++)
   {
    this.childNodes[index].select();
   }
  
   if(this.parentNode)
   {
    this.parentNode.fullSelected();
   }
  
  }
 
  this.cancel = function()
  {
   this.data.checked = false;
   if(this.parentNode)
   {
    this.parentNode.cancel();
   }
  }
 
  this.cancel2 = function()
  {
   this.data.checked = false;
   for(var index=0;index<this.childNodes.length;index++)
   {
    this.childNodes[index].cancel2();
   }
  }
 
  this.init = function()
  {
   var instance = this;
   instance.data.instanceNode = this;
   instance.data.onclick = function()
   {
    if(this.checked == true)
    {
     this.instanceNode.select();
    }
    else
    {
     this.instanceNode.cancel();
     this.instanceNode.cancel2();
    }
   }
  }
 
  this.each = function(itFun)
  {
   itFun(this);
   for(var index=0;index<this.childNodes.length;index++)
   {
    this.childNodes[index].each(itFun);
   }
  }
 
  this.init();
 }
 
function _$(id)
{
 return document.getElementById(id);
}
 
 
 
var allx = null;
function main()
{
 allx = new TreeNode("all", _$('all'));
 
 var a = new TreeNode("a", _$('a'));
 var a1 = new TreeNode("a1", _$('a1'));
 var a2 = new TreeNode("a2", _$('a2'));
 var a3 = new TreeNode("a3", _$('a3'));
 var a4 = new TreeNode("a4", _$('a4'));
 var a5 = new TreeNode("a5", _$('a5'));
 var a6 = new TreeNode("a6", _$('a6'));
  
 a.addChildNode(a1).addChildNode(a2).addChildNode(a3).addChildNode(a4).addChildNode(a5).addChildNode(a6);
 
 var b = new TreeNode("b", _$('b'));
 var b1 = new TreeNode("b1", _$('b1'));
 var b2 = new TreeNode("b2", _$('b2'));
 var b3 = new TreeNode("b3", _$('b3'));
 var b4 = new TreeNode("b4", _$('b4'));
 var b5 = new TreeNode("b5", _$('b5'));
 var b6 = new TreeNode("b6", _$('b6'));
 b.addChildNode(b1).addChildNode(b2).addChildNode(b3).addChildNode(b4).addChildNode(b5).addChildNode(b6);
 
 var c = new TreeNode("c", _$('c'));
 var c1 = new TreeNode("c1", _$('c1'));
 var c2 = new TreeNode("c2", _$('c2'));
 var c3 = new TreeNode("c3", _$('c3'));
 var c4 = new TreeNode("c4", _$('c4'));
 var c5 = new TreeNode("c5", _$('c5'));
 var c6= new TreeNode("c6", _$('c6'));
 c.addChildNode(c1).addChildNode(c2).addChildNode(c3).addChildNode(c4).addChildNode(c5).addChildNode(c6);

 var d = new TreeNode("d", _$('d'));
 var d1 = new TreeNode("d1", _$('d1'));
 var d2 = new TreeNode("d2", _$('d2'));
 var d3 = new TreeNode("d3", _$('d3'));
 var d4 = new TreeNode("d4", _$('d4'));
 var d5 = new TreeNode("d5", _$('d5'));
 var d6= new TreeNode("d6", _$('d6'));
 d.addChildNode(d1).addChildNode(d2).addChildNode(d3).addChildNode(d4).addChildNode(d5).addChildNode(d6);





 allx.addChildNode(a).addChildNode(b).addChildNode(c).addChildNode(d);
}
 
 
 
/** 获得叶子节点的值,以数组返回 */
function getValues(treeNode){
 var values = [];
 var itFun = function(node)
 {
  if(!node.childNodes || node.childNodes.length == 0)
  {
   if(node.data.checked){
    values.push(node.data.value);
   }
  }
 }
 
 treeNode.each(itFun);
 return values;
}




</script>


</head>
<body bgcolor="#f9f9f9" onload="main()">
<script type="text/javascript" src="/js/wz_tooltip.js" ></script>
<script type="text/javascript" src="/js/tip_followscroll.js" ></script>
<div class="wrap">
<div class="position">&nbsp;当前位置:&gt;&gt; 统计报表</div>
<div class="content">
<form  name="form1" method="post" action="../tcpdf/datareport/CopyOfaction.php">
<table width="770" height="266" border="0"  cellpadding="2" cellspacing="1"  class="s s_grid">
    <tr>
      <th  colspan=7 bgcolor="#82C4E8"  class="caption">分类选择</th>
    </tr>
    <tr align="center" bgcolor="#82C4E8">
      <th width="209" height="42" bgcolor="#FFFFFF"><div align="center">项目/时间</div></th>
      <th width="92" bgcolor="#FFFFFF"><div align="center">一小时：</div></th>
      <th width="102" bgcolor="#FFFFFF"><div align="center">六小时：</div></th>
      <th width="78" bgcolor="#FFFFFF"><div align="center">一天：</div></th>
      <th width="78" bgcolor="#FFFFFF"><div align="center">一周：</div></th>
      <th width="78" bgcolor="#FFFFFF"><div align="center">一月：</div></th>
      <th width="97" bgcolor="#FFFFFF"><div align="center">一年： </div></th>
    </tr>
	   
    <tr align="center" bgcolor="#82C4E8">
      <td bgcolor="#FFFFFF" height="37">内存监控：<span class="STYLE5">
        <input type="checkbox" id="a" />
      </span></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" id="a1" name="checkbox[]"  value="1" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" id="a2" name="checkbox[]"  value="2" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" id="a3" name="checkbox[]"  value="3" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" id="a4" name="checkbox[]"  value="4" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" id="a5" name="checkbox[]"  value="5" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" id="a6" name="checkbox[]"  value="6" />
      </div></td>
    </tr>
    <tr align="center" bgcolor="#82C4E8">
      <td height="38" bgcolor="#FFFFFF">CPU报表 ：
        <input type="checkbox" id="b" />      </td>
      <td bgcolor="#FFFFFF"><div align="center" bgcolor="#FFFFFF">
          <input type="checkbox" id="b1" name="checkbox[]" value="7" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" id="b2" name="checkbox[]" value="8" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" id="b3" name="checkbox[]" value="9" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" id="b4" name="checkbox[]" value="10" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" id="b5" name="checkbox[]" value="11" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" id="b6" name="checkbox[]" value="12" />
      </div></td>
    </tr>

    <tr align="center" bgcolor="#82C4E8">
      <td height="28" bgcolor="#FFFFFF">DNS监控 ：<span class="STYLE5">
        <input type="checkbox" id="d" />
      </span></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" name="checkbox[]" id="d1" value="19" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" name="checkbox[]" id="d2" value="20" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" name="checkbox[]" id="d3" value="21" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" name="checkbox[]" id="d4" value="22" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" name="checkbox[]" id="d5" value="23" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" name="checkbox[]" id="d6" value="24" />
      </div></td>
    </tr>
        <tr align="center" bgcolor="#82C4E8">
      <td bgcolor="#FFFFFF" height="35">接口报表：   <select name="port">
      <?php
      foreach ($eths as $v){
      ?>
      <option value="<? echo $v?>" <? if ($v == $eth) echo "selected"?> ><? echo $v?></option>
      <? }?>
      </select><span class="STYLE5">
        <input type="checkbox" id="c" />
      </span></td>
      <td bgcolor="#FFFFFF"><div align="center" bgcolor="#FFFFFF">
          <input type="checkbox" id="c1" name="checkbox[]" value="13" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" id="c2" name="checkbox[]" value="14" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" id="c3" name="checkbox[]" value="15" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" id="c4" name="checkbox[]" value="16" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" id="c5" name="checkbox[]" value="17" />
      </div></td>
      <td bgcolor="#FFFFFF"><div align="center">
          <input type="checkbox" id="c6" name="checkbox[]" value="18" />
      </div></td>
    </tr>
     <tr>
       <td height="35" align="center">统计查询：TopN：
         <select id="pagese" size="1" name="pagese">
  <option value="10" selected=selected>10</option>
  <option value="20" >20</option>
  <option value="30" >30</option>
  <option value="40" >40</option>
  <option value="50" >50</option>
  <option value="60" >60</option>
  <option value="70" >70</option>
  <option value="80" >80</option>
  <option value="90" >90</option>
  <option value="100" >100</option>
  </select></td>
       <td height="38" colspan=7 bgcolor="#FFFFFF" class="footer" >选择日期：
         <input id="start" name="start" type="text" size="13" title="单击弹出日期选择" onclick="fPopCalendar(event,this,this)" onfocus="this.select()" readonly="readonly" />到
  <input id="end" name="end" type="text" size="13" title="单击弹出日期选择" onclick="fPopCalendar(event,this,this)" onfocus="this.select()" readonly="readonly" />
  （如果不选择日期此项不生成报表) </td>
     </tr>
   
     <tr>
      <td height="20" colspan="7" class="whitebg" > 全部选择 :
        <input type="checkbox" id="all" /></td>
    </tr>
    
     <tr>
      <td class="footer" colspan=7 bgcolor="#FFFFFF" ><input type="submit" name="Submit" value="生成报表" /></td>
    </tr>
   
   
  </table>
   </form>
</div>
<div class="push"></div></div>
<? include "../copyright.php";?>
</body>
</html>


