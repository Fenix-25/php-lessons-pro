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
		$this->logger = $logger;
	}

	/**
	 * @param string $code
	 * @return UrlShort
	 */
	public function setCode(string $code): static
	{
		$this->logger->info('Set code for decode', ['code' => $code]);
		$this->code = $code;
		return $this;
	}

	/**
	 * @param int $length
	 */
	public function setLength(int $length): void
	{
		$this->logger->info('Set length of code', ['length' => $length]);
		$this->length = $length;
	}

	/**
	 * @param string $link
	 */
	public function setLink(string $link): static
	{
		$this->logger->info('Set link for encode', ['link' => $link]);
		$this->link = $link;
		return $this;
	}

	public function encode(): void
	{
		$this->urls = (new Files($this->filePath))->readJsonFile();
		if (!(new Validator($this->link))->link()) {
			$msg = "Invalid Url";
			$this->logger->error($msg, ['url' => $this->link]);
			throw new InvalidArgumentException($msg);
		}
		$this->logger->info('Encode url', ['url' => $this->link]);
		$code = (new Encode())->encode($this->link);
		$code = substr($code, 0, $this->length);
		$this->urls[$code] = $this->link;
		$this->logger->info('Save urls to file', ['file' => $this->filePath]);
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
		$this->logger->error('Get Urls');
		return $this->urls;
	}

	public function decode(): void
	{
		$this->logger->info('Decode code', ['code' => $this->code]);
		$res = (new Decode($this->code, $this->urls))->decode($this->code);
		new Divider('=', 60);
		Divider::printString("Your code: {$this->code} equal: $res");
	}
}