<?php

use DI\Container;
use NewV\App;
use NewV\Config;
use NewV\Divider;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

const ROOT = __DIR__ . "/../";
require_once ROOT . "src/bootstrap.php";
$services = Config::instance()->get("services");
try {
	Container::instance($services);
	$di = Container::instance()->get(App::class);
	$di->handle("https://github.com/Bisix21/php-lessons-p/", "54ac4c9efe");
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
	Divider::printString($e->getMessage());
} catch (InvalidArgumentException $argumentException) {
	Divider::printString($argumentException->getMessage());
}