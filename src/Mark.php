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

/**
 * A point-in-time mark to record elapsed time and memory usage.
 * @property-read string $name name of the mark
 * @property-read float  $elapsed elapsed time
 * @property-read float  $memory memory usage
 * @property-read float  $time_diff elapsed time since previous mark
 * @property-read float  $memory_diff memory usage since previous mark
 */
class Mark {

	protected $name;
	protected $elapsed;
	protected $memory;
	protected $time_diff;
	protected $memory_diff;

	public function __construct( $name, $elapsed, $memory, $time_diff, $mem_diff ) {
		$this->name         = $name;
		$this->elapsed      = $elapsed;
		$this->memory       = $memory;
		$this->time_diff    = $time_diff;
		$this->memory_diff  = $mem_diff;
	}

	public function __get( $key ) {
		return $this->$key;
	}

	public function __isset( $key ) {
		return isset($this->key);
	}

}

// EOF