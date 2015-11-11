
<section id="yolk-timeline">
	
	<div>
		<h1>Timers</h1>
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
	</div>

	<div>
		<h1>Script Execution</h1>
		<table>
			<tr>
				<th>&nbsp;</th>
				<th>Step</th>
				<th>Elapsed</th>
				<th>Diff</th>
				<th>Memory</th>
				<th>Diff</th>
			</tr>
			<?php $i = 1; foreach( $report['marks'] as $name => $mark ) { ?>
			<tr>
				<td><?=$i++?></td>
				<td><?=$name?></td>
				<td><?=number_format($mark['elapsed'] * 1000, 3)?> ms</td>
				<td><?=number_format($mark['time_diff'] * 1000, 3)?> ms</td>
				<td><?=number_format($mark['memory'] / 1024 / 1024, 3)?> MB</td>
				<td><?=number_format($mark['memory_diff'] / 1024 / 1024, 3)?> MB</td>
			</tr>
			<?php } ?>
		</table>
	</div>
	
</section>
