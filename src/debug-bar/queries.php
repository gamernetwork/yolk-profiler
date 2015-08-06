
<section id="yolk-queries">
	
	<h1>Database Queries</h1>
	
	<table>
		<thead>
			<tr>
				<th>#</th>
				<th>Query</th>
				<th>Parameters</th>
				<th>Duration</th>
			</tr>
		</thead>
		<tbody>
			<?php $i = 1; $total = 0; foreach( $report['queries'] as $query ) { ?>
			<tr>
				<td><?=$i++?></td>
				<td class="sql"><?=nl2br($query['query'])?></td>
				<td>
					<?php foreach( $query['params'] as $k => $v ) { ?>
					<?="<var>{$k}</var> {$v}<br />\n"?>
					<?php } ?>
				</td>
				<td><?=number_format($query['duration'] * 1000, 3)?> ms<?php $total += $query['duration']?></td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="3" class="caption">Total:</td>
				<td><?=number_format($total * 1000, 3)?> ms</td>
			</tr>
		</tbody>
	</table>
	
</section>
