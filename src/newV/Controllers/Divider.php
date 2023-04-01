<?php

namespace NewV;

class Divider
{
	protected static string $symbol;
	protected static int $length;

	public function __construct($symbol, $length)
	{
		self::$symbol = $symbol;
		self::$length = $length;
	}

	public static function printResult($result): void
	{
		self::divider();
		echo "\n" . $result . "\n";
		self::divider();
		echo "\n";
	}

	protected static function divider(): void
	{
		for ($i = 0; $i < self::$length; $i++) {
			echo self::$symbol;
		}
	}
}