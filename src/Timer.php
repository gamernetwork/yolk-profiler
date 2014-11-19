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

use yolk\contracts\profiler\TimerInterface;

/**
 * Simple timer implementation.
 */
class Timer implements TimerInterface {

	/**
	 * Time last started.
	 * @var float
	 */
	protected $started;

	/**
	 * Total elapsed time
	 * @var float
	 */
	protected $elapsed;

	public function __construct() {
		$this->started = 0;
		$this->elapsed = 0;
	}

	/**
	 * Start the timer.
	 * @param  float $time optional starting point (microtime)
	 * @return self
	 */
	public function start( $time = null ) {

		if( !$this->started )
			$this->started = $time ?: microtime(true);

		return $this;

	}

	/**
	 * Stop the timer and add the duration to the total elapsed time.
	 * @return self
	 */
	public function stop() {

		if(  $this->started ) {
			$this->elapsed += microtime(true) - $this->started;
			$this->started = 0;
		}

		return $this;

	}

	/**
	 * Determine if the timer is currently running.
	 * @return boolean
	 */
	public function isRunning() {
		return (bool) $this->started;
	}

	/**
	 * Return the elapsed time from last start.
	 * @return float
	 */
	public function getElapsed( $total = false ) {
		return $this->started ? (microtime(true) - $this->started) : 0;
	}

	/**
	 * Return the total elapsed time.
	 * @return float
	 */
	public function getTotalElapsed() {

		$elapsed = $this->elapsed;

		if( $this->started )
			$elapsed += (microtime(true) - $this->started);

		return $elapsed;

	}

}

// EOF