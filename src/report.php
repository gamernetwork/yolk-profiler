
<style id="yolk-profiler" type="text/css">
#yolk-container {
	clear:both;
	color: #dddddd;
	background: #323A42;
	overflow: hidden;
	margin-bottom: 20px;
	font-family:"Lucida Grande", Tahoma, Arial, sans-serif;
	margin: 0 auto;
	display: none;
}

#yolk-container .green { color:#588E13 !important; }
#yolk-container .blue { color:#3769A0 !important; }
#yolk-container .purple { color:#953FA1 !important; }
#yolk-container .orange { color:#D28C00 !important; }
#yolk-container .red { color:#B72F09 !important; }

#yolk-container .yolk-box {
	width: 960px;
	padding:20px;
	clear: left;
}

#yolk-container .yolk-box > h4 {
	font-size: 20px;
	margin:0 0 10px 0;
}

#yolk-container .yolk-box table {
	border-collapse: collapse;
	border-top: 1px solid #888888;
	width: 100%;
}

#yolk-container .yolk-box table tr {
	border-bottom: 1px solid #888888;
}

#yolk-container .yolk-box table th,
#yolk-container .yolk-box table td {
	padding: 5px 10px;
	text-align: right;
	vertical-align: top;
}

#yolk-container .yolk-box table .center {
	text-align: center;
}

#yolk-container .yolk-box table .left {
	text-align: left;
}

#yolk-container .yolk-box table td {
	color: #ffffcc;
}

#yolk-container .yolk-box table th,
#yolk-container .yolk-box table .caption {
	color: #ffffff;
}

#yolk-metrics {
	overflow: hidden;
	padding:0;
}

#yolk-metrics div {
	float:left;
	width: 200px;
	color:#588E13;
	text-align: center;
	cursor: pointer;
	border-bottom: 5px solid #888888;
	margin-right: 2px;
}

#yolk-metrics div:hover {
	border-color: #ffffff;
}

#yolk-metrics div var {
	font-style: normal;
	font-size: 24px;
}

#yolk-metrics div h4 {
	color: #eeeeee;
	font-size: 14px;
	margin:5px 0 0 0;
	font-weight: normal;
}


#yolk-timing table th,
#yolk-timing table td {
	white-space: nowrap;
}

#yolk-queries {
	width: auto !important;
}

#yolk-queries table tr td,
#yolk-queries table tr th {
	max-width: 800px !important;
}

#yolk-timing,
#yolk-queries,
#yolk-includes {
	display: none;
}
</style>

<div id="yolk-container">
	<script type="text/javascript">
		
		addEvent(window, 'load', loadYolkCSS);
		
		function loadYolkCSS() {
			var sheet = document.getElementById('yolk-profiler');
			sheet.parentNode.removeChild(sheet);
			document.getElementsByTagName("head")[0].appendChild(sheet);
			setTimeout(function(){document.getElementById("yolk-container").style.display = "block"}, 10);
		}
		
		function addEvent( obj, type, fn ) {
			if ( obj.attachEvent ) {
				obj["e"+type+fn] = fn;
				obj[type+fn] = function() { obj["e"+type+fn]( window.event ) };
				obj.attachEvent( "on"+type, obj[type+fn] );
			} 
			else{
				obj.addEventListener( type, fn, false );	
			}
		}
		
		function showYolkPane( id ) {
			document.getElementById('yolk-timing').style.display = 'none';
			document.getElementById('yolk-queries').style.display = 'none';
			document.getElementById('yolk-includes').style.display = 'none';
			document.getElementById(id).style.display = 'block';
		}
		
	</script>
	<div id="yolk-metrics" class="yolk-box">
	
		<div class="blue" onclick="showYolkPane('yolk-timing')">
			<var><?=number_format($report['duration'] * 1000, 3)?> ms</var>
			<h4>Execution Time</h4>
		</div>
	
		<div class="purple" onclick="showYolkPane('yolk-queries')">
			<var><?=count($report['queries'])?> Queries</var>
			<h4>Database</h4>
		</div>
	
		<div class="orange" onclick="showYolkPane('yolk-timing')">
			<var><?=number_format($report['memory'] / 1024 / 1024, 3)?> MB</var>
			<h4>Peak Memory</h4>
		</div>
	
		<div class="red" onclick="showYolkPane('yolk-includes')">
			<var><?=count($report['includes'])?> Files</var>
			<h4>Included</h4>
		</div>
	</div>

	<div id="yolk-timing" class="yolk-box">
		
		<h4 class="blue">Timers</h4>
		<table>
			<tr>
				<th class="left caption">Name</th>
				<th>Elapsed</th>
			</tr>
			<?php foreach( $report['timers'] as $name => $elapsed ) { ?>
			<tr>
				<td class="left caption"><?=$name?></td>
				<td><?=number_format($elapsed * 1000, 3)?> ms</td>
			</tr>
			<?php } ?>
		</table>
		
		<h4 class="blue">Script Execution</h4>
		<table>
			<tr>
				<th>&nbsp;</th>
				<th class="left">Step</th>
				<th>Elapsed</th>
				<th>Diff</th>
				<th>Memory</th>
				<th>Diff</th>
			</tr>
			<?php $i = 1; foreach( $report['marks'] as $name => $mark ) { ?>
			<tr>
				<td class="center caption"><?=$i++?></td>
				<td class="left caption"><?=$name?></td>
				<td><?=number_format($mark['elapsed'] * 1000, 3)?> ms</td>
				<td><?=number_format($mark['time_diff'] * 1000, 3)?> ms</td>
				<td><?=number_format($mark['memory'] / 1024 / 1024, 3)?> MB</td>
				<td><?=number_format($mark['memory_diff'] / 1024 / 1024, 3)?> MB</td>
			</tr>
			<?php } ?>
		</table>
		
	</div>

	<div id="yolk-queries" class="yolk-box">
		
		<h4 class="purple">Database Queries</h4>
		
		<table>
			<tr>
				<th>&nbsp;</th>
				<th class="left caption">Query</th>
				<th class="left">Parameters</th>
				<th style="width: 120px">Duration</th>
			</tr>
			<?php $i = 1; $total = 0; foreach( $report['queries'] as $query ) { ?>
			<tr>
				<td class="center caption"><?=$i++?></td>
				<td class="left caption sql"><?=nl2br($query['query'])?></td>
				<td class="left caption">
					<?php foreach( $query['params'] as $k => $v ) { ?>
					<?="{$k} => {$v}<br />\n"?>
					<?php } ?>
				</td>
				<td><?=number_format($query['duration'] * 1000, 3)?> ms<?php $total += $query['duration']?></td>
			</tr>
			<?php } ?>
			<tr>
				<td  colspan="3" class="caption">Total:</td>
				<td><?=number_format($total * 1000, 3)?> ms</td>
			</tr>
		</table>
		
	</div>

	<div id="yolk-includes" class="yolk-box">
		
		<h4 class="red">Included Files</h4>
		
		<ol>
			<?php sort($report['includes']); foreach( $report['includes'] as $file ) { ?>
			<li><?=$file?></li>
			<?php } ?>
		</ol>
		
	</div>
</div>
