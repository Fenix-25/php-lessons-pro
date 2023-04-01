<?php

namespace NewV;


use InvalidArgumentException;

class UrlShort
{
	protected string $filePath, $link, $code;
	protected array $urls;
	protected int $length;

	public function __construct($filePath)
	{
		$this->filePath = $filePath;
	}

	/**
	 * @param string $code
	 * @return UrlShort
	 */
	public function setCode(string $code): static
	{
		$this->code = $code;
		return $this;
	}

	/**
	 * @param int $length
	 */
	public function setLength(int $length): void
	{
		$this->length = $length;
	}

	/**
	 * @param string $link
	 */
	public function setLink(string $link): void
	{
		$this->link = $link;
	}

	public function shorter(): void
	{
		$this->urls = (new Files($this->filePath))->readJsonFile();
		if (!(new Validator($this->link))->link()) {
			throw new InvalidArgumentException('Invalid Url');
		}
		$code = (new Encode())->encode($this->link);
		$code = substr($code, 0, $this->length);
		$this->urls[$code] = $this->link;
		(new Files($this->filePath))->saveToFile($this->urls);
		if (!empty($this->urls)) {
			$this->showUrls();
		}
	}

	protected function showUrls(): void
	{
		new Divider('=', 32);

	}

	/**
	 * @return array
	 */
	public function getUrls(): array
	{
		return $this->urls;
	}

	public function deShorter(): void
	{
		$res = (new Decode($this->code, $this->urls))->decode($this->code);
		new Divider('=', 19);
		Divider::printResult("Your code: {$this->code} equal: $res");
	}
}