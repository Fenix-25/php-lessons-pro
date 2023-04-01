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

	public static function printString(string $string): void
	{
		self::divider();
		echo $string . "\n";
		self::divider();
		echo "\n";
	}

	protected static function divider(): void
	{
		for ($i = 0; $i < self::$length; $i++) {
			echo self::$symbol;
		}
		echo "\n";
	}

	public static function printArray(array $data): void
	{
		self::divider();
		foreach ($data as $key => $value) {
			echo  $key . " => " . $value . "\n";
		}
		self::divider();
		echo "\n";
	}
}