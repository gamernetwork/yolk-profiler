
# Yolk Profiler

A simple profiling library for benchmarking code execution speed, memory usage and database queries.

## Requirements

This library requires only PHP 5.4 or later and the Yolk Contracts package (```gamernetwork/yolk-contracts```).

## Installation

It is installable and autoloadable via Composer as ```gamer-network/yolk-profiler```.

Alternatively, download a release or clone this repository, and add the \yolk\profiler namespace to an autoloader.

## License

Yolk Profiler is open-sourced software licensed under the MIT license

## Quick Start

```php
use yolk\profiler\Profiler;

$profiler = new Profiler();

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

// get a report
print_r(
	$profiler->getData()
);
```

## Profiler Method Reference

reset( $time = null, $memory = null );

start( $timer, $reset = false, $time = null );

stop( $timer = null );

isRunning( $timer = '' );

getElapsed( $timer = '' );

mark( $name = '' );

query( $query, $parameters, $duration );

meta( $key, $value );

getQueries();

getData();
