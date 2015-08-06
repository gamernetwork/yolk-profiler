<?php

if( !function_exists('yolk_profiler_dump') ) {
		
	function yolk_profiler_dump( array $data ) {

		$out = "<ul>\n";

		foreach( $data as $k => $v ) {
			$out .= "<li>\n\t<var>{$k}</var>";

			if( is_array($v) ) {
				$out .= yolk_profiler_dump($v);
			}
			else {
				if( is_bool($v) )
					$v = $v ? 'true' : 'false';
				$out .= "<span class=\"value\">{$v}</span>";
			}
			$out .= "\n</li>\n";
		}

		$out .= "</ul>\n";

		return $out;

	}
}

?>

<div id="yolk-debug">

	<header>
		<ul>
			<li title="Yolk Debug Bar" class="btn">
				<i class="fa fa-circle"></i>
			</li>
			<li title="Execution Time" class="tab" data-tab="yolk-timeline">
				<i class="fa fa-clock-o"></i>
				<var><?=number_format($report['duration'] * 1000)?> ms</var>
			</li>
			<li title="Peak Memory">
				<i class="fa fa-signal"></i>
				<var><?=number_format($report['memory'] / 1024 / 1024, 3)?> MB</var>
			</li>
			<li title="Database Queries" class="tab" data-tab="yolk-queries">
				<i class="fa fa-database"></i>
				<var><?=count($report['queries'])?></var>
			</li>
			<li title="Request Parameters" class="tab" data-tab="yolk-request">
				<i class="fa fa-download"></i>
			</li>
			<li title="Twig Info" class="tab" data-tab="yolk-twig">
				<i class="fa fa-file-code-o"></i>
			</li>
			<li title="Configuration" class="tab" data-tab="yolk-config">
				<i class="fa fa-cog"></i>
			</li>
			<li title="Hide" class="btn">
				<i class="fa fa-close"></i>
			</li>
		</ul>
	</header>

	<div id="yolk-debug-body">
		<?php include __DIR__. '/timeline.php'; ?>
		<?php include __DIR__. '/queries.php'; ?>
		<?php include __DIR__. '/config.php'; ?>
	</div>

	<div id="yolk-debug-resize">

	</div>

	<style>
	<?php include __DIR__. '/yolk-profiler.css'; ?>
	/**/
	</style>

	<script>
<?php include __DIR__. '/yolk-profiler.js'; ?>
	</script>

</div>
