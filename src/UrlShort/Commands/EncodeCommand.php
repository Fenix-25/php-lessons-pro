<?php

namespace Bisix21\src\UrlShort\Commands;

use Bisix21\src\UrlShort\Encode;
use Bisix21\src\UrlShort\Interface\CommandInterface;
use Bisix21\src\UrlShort\Repository\DM;
use Bisix21\src\UrlShort\Services\Converter;
use Bisix21\src\UrlShort\Services\Printer;
use Bisix21\src\UrlShort\Services\Validator;
use Doctrine\ORM\Exception\ORMException;

class EncodeCommand implements CommandInterface
{

	public function __construct(
		protected DM        $record,
		protected Encode    $encode,
		protected Converter $arguments,
		protected Validator $validator
	)
	{
	}

	/**
	 * @throws ORMException
	 */
	public function runAction(): void
	{
		//валідує лінк
		$this->validator->link($this->arguments->getArguments());
		//записує в бд
		$this->saveAndPrint();
	}

	/**
	 * @throws ORMException
	 */
	protected function saveAndPrint()
	{
		$codeShort = $this->createArr($this->encode->encode($this->arguments->getArguments()), $this->arguments->getArguments());
		$this->record->saveToDb($codeShort);
		Printer::printString($codeShort['code'] . " => " . $codeShort['url']);
	}

	protected function createArr(string $code, string $url): array
	{
		return [
			'code' => $code,
			'url' => $url,
		];
	}
}