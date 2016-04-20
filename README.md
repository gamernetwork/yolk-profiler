# Yolk Profiler

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gamernetwork/yolk-profiler/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/gamernetwork/yolk-profiler/?branch=develop)

A simple profiling library for benchmarking code execution speed, memory usage and database queries.

## Requirements

This library requires only PHP 5.4 or later and the Yolk Contracts package (`gamernetwork/yolk-contracts`).

## Installation

It is installable and autoloadable via Composer as `gamer-network/yolk-profiler`.

Alternatively, download a release or clone this repository, and add the `\yolk\profiler` namespace to an autoloader.

## License

Yolk Profiler is open-sourced software licensed under the MIT license.

## Quick Start

```php
use yolk\profiler\GenericProfiler;

$profiler = new GenericProfiler();

$profiler->start('Op 1');
lengthyOperation1();
$profiler->stop('Op 1');

$profiler->start('Op 2');
lengthyOperation2();
$profiler->stop('Op 2');

// profile a query
$profiler->start('Query1');
doDatabaseQuery($sql, $params);
$profiler->stop('Query1');

$profiler->query($sql, $params, $profiler->getElapsed('Query1'));

// add some additional info
$profiler->meta('get', $_GET);
$profiler->meta('post', $_POST);

$profiler->stop();

// assign a configuration object to the profiler to be included in the report
$profiler->config(Config $config);

// get a report
print_r(
	$profiler->getData()
);
```

## Timers

`GenericProfiler` makes use of the `GenericTimer` class, which may also be used independently
to record periods of time at microsecond resolution.

```php
use yolk\profiler\GenericTimer;

$t = new GenericTimer();

$t->start();
$t->isRunning();	// returns true
$t->getElapsed();	// returns microseconds since last call to start()
$t->stop();
$t->isRunning();	// returns false
$t->getTotalElapsed();	// returns microseconds between all calls to start()/stop()
```

## Debug Bar

An HTML debug bar is provided that can be rendered to a web page and provide a
pretty representation of the Profiler's data.

The relevant HTML can be obtained by calling the `getHTML()` method on the profiler
and can then be inserted into a template, send to the client, etc.

The debug bar source is self-contained and is designed to be placed just before the
closing `</body>` tag.
