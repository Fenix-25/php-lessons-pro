<?php

use NewV\Divider;
use NewV\UrlShort;

require_once __DIR__ . "/../vendor/autoload.php";

$path = __DIR__ . "/../storage/urlNew.json";
try {
	$short = new UrlShort($path);
	$short->setLink("https://phps.net");
	$short->setLength(10);
	$short->shorter();
	$short->setCode("72fe95c557")->deShorter();
} catch (InvalidArgumentException $exception) {
	new Divider('=', 19);
	Divider::printResult($exception->getMessage());
}

//прокинути логи