<?php

namespace NewV;

use NewV\Interface\ISameUrlShort;
use Psr\Log\LoggerInterface;

class SameUrlShorter extends UrlShort implements ISameUrlShort
{
	public function __construct($filePath, LoggerInterface $logger)
	{
		parent::__construct($filePath, $logger);
	}

	public function sameUrLShort(string $url): string
	{
	 $this->setLink($url)->encode();
		// TODO: Implement sameUrLShort() method.
	}
}