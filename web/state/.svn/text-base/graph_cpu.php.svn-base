<?php


header( "Content-type: image/svg+xml" );
$nb_plot = 120;
$fetch_link = "../cgi-bin/cpu.cgi";
$attribs['axis'] = "fill=\"#FFFFFF\" stroke=\"black\"";
$attribs['cpu'] = "fill=\"#ff0505\" font-family=\"SimSun,Tahoma, Verdana, Arial, Helvetica, sans-serif\" font-size=\"7\"";
$attribs['graph_cpu'] = "fill=\"none\" stroke=\"#2eff05\" stroke-opacity=\"0.8\"";
$attribs['legend'] = "fill=\"#ff0505\" font-family=\"SimSun,Tahoma, Verdana, Arial, Helvetica, sans-serif\" font-size=\"4\"";
$attribs['grid_txt'] = "fill=\"#e5ff05\" font-family=\"SimSun,Tahoma, Verdana, Arial, Helvetica, sans-serif\" font-size=\"6\"";
$attribs['grid'] = "stroke=\"#88feff\" stroke-opacity=\"0.5\"";
$attribs['error'] = "fill=\"red\" font-family=\"SimSun\" font-size=\"6\"";
$attribs['collect_initial'] = "fill=\"#69ff05\" font-family=\"SimSun,Tahoma, Verdana, Arial, Helvetica, sans-serif\" font-size=\"6\"";
$height = 100;
$width = 200;
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n"; ?>
<svg width="100%" height="100%" viewBox="0 0 <?php echo $width;?> <?php echo $height;?>" preserveAspectRatio="none" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" onload="init(evt);">
	<g id="graph">
		<rect id="bg" x1="0" y1="0" width="100%" height="100%" fill="#000000"/>
		<line id="axis_x" x1="0" y1="0" x2="0" y2="100%" <?php echo $attribs['axis'];?>/>
		<line id="axis_y" x1="0" y1="100%" x2="100%" y2="100%" <?php echo $attribs['axis'];?>/>
		<polygon id="axis_arrow_x" <?php echo $attribs['axis']?> points="<?php echo ($width) . "," . ($height)?> <?php echo ($width-2) . "," . ($height-2)?> <?php echo ($width-2) . "," . $height?>"/>
		<path id="graph_cpu" d="" <?php echo $attribs['graph_cpu'];?>/>	
		<path id="grid" d="M0 <?php echo $height / 4 * 1;?> L <?php echo $width;?> <?php echo $height / 4 * 1;?> M0 <?php echo $height / 4 * 2;?> L <?php echo $width;?> <?php echo $height / 4 * 2;?> M0 <?php echo $height / 4 * 3;?> L <?php echo $width;?> <?php echo $height / 4 * 3;?>" <?php echo $attribs['grid'];?>/>
		<text id="grid_txt1" x="100%" y="25%" <?php echo $attribs['grid_txt'];?> text-anchor="end">75%</text>
		<text id="grid_txt2" x="100%" y="50%" <?php echo $attribs['grid_txt'];?> text-anchor="end">50%</text>
		<text id="grid_txt3" x="100%" y="75%" <?php echo $attribs['grid_txt'];?> text-anchor="end">25%</text>
		<text id="graph_cpu_txt" x="4" y="8" <?php echo $attribs['cpu'];?> > </text>
		<text id="error" x="50%" y="50%"  visibility="hidden" <?php echo $attribs['error'];?> text-anchor="middle">系统负载数据采集出错!</text>
		<text id="collect_initial" x="50%" y="50%"  visibility="hidden" <?php echo $attribs['collect_initial'];?> text-anchor="middle">系统负载数据采集中...</text>
	</g>
	<script type="text/ecmascript">
	<![CDATA[
/**
 * getURL is a proprietary Adobe function, but it's simplicity has made it very
 * popular. If getURL is undefined we spin our own by wrapping XMLHttpRequest.
 */
 if (typeof getURL == 'undefined') {
  getURL = function(url, callback) {
    if (!url)
      throw 'No URL for getURL';

    try {
      if (typeof callback.operationComplete == 'function')
        callback = callback.operationComplete;
    } catch (e) {}
    if (typeof callback != 'function')
      throw 'No callback function for getURL';

    var http_request = null;
    if (typeof XMLHttpRequest != 'undefined') {
      http_request = new XMLHttpRequest();
    }
    else if (typeof ActiveXObject != 'undefined') {
      try {
        http_request = new ActiveXObject('Msxml2.XMLHTTP');
      } catch (e) {
        try {
          http_request = new ActiveXObject('Microsoft.XMLHTTP');
        } catch (e) {}
      }
    }
    if (!http_request)
      throw 'Both getURL and XMLHttpRequest are undefined';

    http_request.onreadystatechange = function() {
      if (http_request.readyState == 4) {
        callback( { success : true,
                    content : http_request.responseText,
                    contentType : http_request.getResponseHeader("Content-Type") } );
      }
    }
    http_request.open('GET', url, true);
    http_request.send(null);
  }
}

var SVGDoc = null;
var last_cpu_total = 0;
var last_cpu_idle = 0;
var diff_cpu_total = 0;
var diff_cpu_idle = 0;
var cpu_data = new Array();

var max_num_points = <?php echo $nb_plot;?>;

// maximum number of plot data points
var step = <?php echo $width;?> / max_num_points;  // plot X division size
var scale = <?php echo $height;?> / 100;

function init(evt) {
  SVGDoc = evt.target.ownerDocument;
  fetch_data();
}

function fetch_data() {
  getURL('<?php echo $fetch_link;?>', plot_cpu_data);
}

function plot_cpu_data(obj) {
  if (!obj.success)
    return handle_error();  // getURL failed to get current CPU load data

  var cpu = parseInt(obj.content);
  if (!isNumber(cpu))
    return handle_error();

  switch (cpu_data.length) {
  case 0:
    SVGDoc.getElementById("collect_initial").setAttributeNS(null, 'visibility', 'visible');
    cpu_data[0] = cpu;
    fetch_data();
    return;
  case 1:
    SVGDoc.getElementById("collect_initial").setAttributeNS(null, 'visibility', 'hidden');
    break;
  case max_num_points:
    // shift plot to left if the maximum number of plot points has been reached
    var i = 0;
    while (i < max_num_points) {
      cpu_data[i] = cpu_data[++i];
    }
    --cpu_data.length;
  }

  cpu_data[cpu_data.length] = cpu;

  var path_data = "M 0 " + (<?php echo $height;?> - (cpu_data[0] * scale));
  for (var i = 1; i < cpu_data.length; ++i) {
    var x = step * i;
    var y_cpu = <?php echo $height;?> - (cpu_data[i] * scale);
    path_data += " L" + x + " " + y_cpu;
  }

  SVGDoc.getElementById("error").setAttributeNS(null, 'visibility', 'hidden');
  SVGDoc.getElementById('graph_cpu_txt').firstChild.data ='CPU系统负载实时情况:'+ cpu + '%';
  SVGDoc.getElementById('graph_cpu').setAttributeNS(null, "d", path_data);

  setTimeout('fetch_data()',2000);
}

function handle_error() {
  SVGDoc.getElementById("error").setAttributeNS(null, 'visibility', 'visible');
  fetch_data();
}

function isNumber(a) {
  return typeof a == 'number' && isFinite(a);
}

	]]>
  </script>
</svg>
