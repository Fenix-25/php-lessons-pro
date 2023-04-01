<?php

namespace NewV;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;


class UrlShort
{
	protected string $filePath, $link, $code;
	protected array $urls;
	protected int $length;
	protected LoggerInterface $logger;

	public function __construct($filePath, LoggerInterface $logger)
	{
		$this->filePath = $filePath;
		$this->logger= $logger;
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
		$this->logger->log('info','Set length of code');
		$this->length = $length;
	}

	/**
	 * @param string $link
	 */
	public function setLink(string $link): void
	{
		$this->logger->log('info','Set link for encode');
		$this->link = $link;
	}

	public function shorter(): void
	{
		$this->urls = (new Files($this->filePath))->readJsonFile();
		if (!(new Validator($this->link))->link()) {
			$msg = "Invalid Url";
			$this->logger->log('error', $msg);
			throw new InvalidArgumentException($msg);
		}
		$this->logger->log('info','Encode url');
		$code = (new Encode())->encode($this->link);
		$code = substr($code, 0, $this->length);
		$this->urls[$code] = $this->link;
		$this->logger->log('info','Save urls to file');
		(new Files($this->filePath))->saveToFile($this->urls);

	}

	public function showUrls(): void
	{
		new Divider('=', 32);
		Divider::printArray($this->getUrls());
	}

	/**
	 * @return array
	 */
	public function getUrls(): array
	{
		$this->logger->log('error','Encode url');
		return $this->urls;
	}

	public function deShorter(): void
	{
		$this->logger->log('error','Decode url');
		$res = (new Decode($this->code, $this->urls))->decode($this->code);
		new Divider('=', 19);
		Divider::printString("Your code: {$this->code} equal: $res");
	}
}