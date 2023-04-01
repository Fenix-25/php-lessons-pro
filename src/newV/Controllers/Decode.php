<?php

namespace NewV;

use NewV\Interface\IUrlDecoder;

class Decode implements IUrlDecoder
{
	protected string $code;
	protected array $urls;

	public function __construct($code, $urls)
	{
		$this->code = $code;
		$this->urls = $urls;
	}

	public function decode(string $code): string
	{
		return $this->urls[$code];
	}
}