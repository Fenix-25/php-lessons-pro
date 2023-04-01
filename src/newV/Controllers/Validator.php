<?php

namespace NewV;

use InvalidArgumentException;

class Validator
{
	protected static string $link;

	public function __construct(string $link)
	{
		//delete all spaces
		self::$link = trim($link);
	}

	public static function link(): bool|int
	{
		if (empty(self::$link)){
			throw new InvalidArgumentException('Url is empty');
		}
		// прротокол + доменна назва . домен : порт(якщо існує)/ назва каталогу
		$pattern = '/^https?:\/\/[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})(:[0-9]{1,5})?(\/.*)?$/i';
		return preg_match($pattern, self::$link);
	}
}