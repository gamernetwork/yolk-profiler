<?php
/*
 * This file is part of Yolk - Gamer Network's PHP Framework.
 *
 * Copyright (c) 2014 Gamer Network Ltd.
 *
 * Distributed under the MIT License, a copy of which is available in the
 * LICENSE file that was bundled with this package, or online at:
 * https://github.com/gamernetwork/yolk-profiler
 */

namespace yolk\profiler;

use yolk\contracts\profiler\ProfilerInterface;

/**
 * Simple profiler class for recording code execution time, memory usage and database queries.
 */
class Profiler implements ProfilerInterface {

	/**
	 * Array of timer instances.
	 * @var Timer[]
	 */
	protected $timers;

	/**
	 * Array of mark instances.
	 * @var Mark[]
	 */
	protected $marks;

	/**
	 * Array of query information.
	 * @var array
	 */
	protected $queries;

	/**
	 * Key/value store of additional data.
	 * @var array
	 */
	protected $meta;

	public function __construct( $time = null, $memory = null ) {
		$this->reset($time, $memory);
	}

	public function reset( $time = null, $memory = null ) {

		$memory = isset($memory) ? memory_get_usage() : $memory;

		// create and start internal timer
		$this->timers = [
			'' => new Timer('internal')
		];

		$this->timers['']->start($time);

		$this->marks['start'] = new ProfilerMark(
			'start',
			0,
			$memory,
			0,
			0
		);

		$this->queries = [];
		$this->meta    = [];

	}

	public function start( $timer, $reset = false, $time = null ) {

		// not directly accessible
		if( !$timer ) return;

		if( !isset($this->timers[$timer]) || $reset ) {
			$this->timers[$timer] = new Timer($timer);
		}

		$this->timers[$timer]->start($time);

		return $this;

	}

	public function stop( $timer = null ) {

		if( $timer === null ) {
			// stop user-defined timers
			foreach( $this->timers as $name => $timer ) {
				if( $name && $timer->isRunning() ) {
					$timer->stop();
				}
			}
			// stop the internal timer last and mark the elapsed time
			$this->timers['']->stop();
			$this->mark('end');
		}
		elseif( $timer )  {
			$timer = isset($this->timers[$timer]) ? $this->timers[$timer] : false;
			if( $timer && $timer->isRunning() ) {
				$timer->stop();
			}
		}

		return $this;

	}

	public function isRunning( $timer = '' ) {
		return isset($this->timers[$timer]) ? $this->timers[$timer]->isRunning() : false;
	}

	public function getElapsed( $timer = '' ) {
		return isset($this->timers[$timer]) ? $this->timers[$timer]->getElapsed() : 0;
	}

	public function mark( $name = '' ) {

		$prev    = end($this->marks);
		$elapsed = $this->timers['']->getElapsed();
		$memory  = memory_get_usage();

		$this->marks[$name] = new ProfilerMark(
			$name,
			$elapsed,
			$memory,
			$elapsed - $prev->elapsed,
			$memory - $prev->memory
		);

		return $this;

	}

	public function query( $query, $parameters, $duration ) {
		$this->queries[] = [
			'query'    => $query,
			'params'   => $parameters,
			'duration' => round($duration, 6),
		];
		return $this;
	}

	public function meta( $key, $value ) {
		if( $value === null )
			unset($this->meta[$key]);
		else
			$this->meta[$key] = $value;
		return $this;
	}

	public function getQueries() {
		return $this->queries;
	}

	public function getData() {

		$report = [
			'duration' => round($this->timers['']->getElapsed(), 6),
			'memory'   => memory_get_peak_usage(),
			'timers'   => [],
			'marks'    => $this->marks,
			'queries'  => $this->queries,
			'meta'     => $this->meta,
			'includes' => get_included_files()
		];

		foreach( $this->timers as $name => $timer ) {
			$report['timers'][$name] = round($timer->getElapsed(), 6);
		}
		unset($report['timers']['']);
		ksort($report['timers']);

		return $report;

	}

}

// EOF