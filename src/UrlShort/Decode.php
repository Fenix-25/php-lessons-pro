<?php

namespace Bisix21\src\UrlShort;

use Bisix21\src\UrlShort\Entity\Short;
use Bisix21\src\UrlShort\Interface\IUrlDecoder;
use Bisix21\src\UrlShort\ORM\Models\UrlShort;
use Bisix21\src\UrlShort\Repository\Files;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\NotSupported;


class Decode implements IUrlDecoder
{
	public function __construct(
		protected EntityManager|UrlShort|Files $short,
	)
	{
	}

	public function decode(string $code): string
	{
		return $this->decodeFromFile($code);
	}

	/**
	 * @throws NotSupported
	 */
	protected function decodeFromDM(string $code)
	{
		$shortRep = $this->short->getRepository(Short::class);
		$short = $shortRep->getUrlByCode($code);
		return $short->getUrl();
	}

	protected function decodeFromAR(string $code)
	{
		$res = $this->short->getUrlByCode($code);
		return $res->url;
	}
	protected function decodeFromFile(string $code)
	{

		return $this->short->read($code);
	}
}