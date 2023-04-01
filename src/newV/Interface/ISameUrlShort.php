<?php

namespace NewV\Interface;

interface ISameUrlShort
{
	/**
	 * @param string $url
	 * @return string
	 */
	public function sameUrLShort(string $url): string;
}