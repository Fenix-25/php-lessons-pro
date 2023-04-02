<?php

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use NewV\Divider;
use NewV\UrlShort;

require_once __DIR__ . "/../vendor/autoload.php";

$pathUrl = __DIR__ . "/../storage/urlNew.json";
$pathLogger = __DIR__ . "/../storage/newLogger.log";
$link = "https://google.com";

$logger = new Logger('new_url_shorter');
$logger->pushHandler(new StreamHandler($pathLogger, Level::Info));

try {
	$short = new UrlShort($pathUrl, $logger);
	$short->setLength(10);
	$short->setLink($link)->encode();
	$short->setCode("ac405aa6be")->decode();
	$short->showUrls();
} catch (InvalidArgumentException $exception) {
	new Divider('=', 19);
	Divider::printString($exception->getMessage());
}