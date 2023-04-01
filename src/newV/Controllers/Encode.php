<?php

namespace NewV;

use NewV\Interface\IUrlEncoder;

class Encode implements IUrlEncoder
{

	/**
	 * @inheritDoc
	 */
	public function encode(string $url): string
	{
		//select type for gen
		return md5(sha1($url));
	}

	public function sha1(): string
	{
		$url = 1;
		return sha1($url);
	}
}