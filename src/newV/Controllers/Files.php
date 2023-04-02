<?php

namespace NewV;

use InvalidArgumentException;
use NewV\Interface\FilesInterface;

class Files implements FilesInterface
{
	protected string $filePath;
	protected array $dataArray;

	public function __construct($path)
	{
		$this->filePath = $path;
	}

	public function readFile(): array
	{
		if (!file_exists($this->filePath)) {
			file_put_contents($this->filePath, '');
			throw new InvalidArgumentException('File don\'t exist, rerun code');
		}
		$data = file_get_contents($this->filePath);
		return $this->dataArray = json_decode($data, true) ?? [];
	}

	public function saveToFile($data): void
	{
		if (!empty($data)) {
			$data = json_encode($data, JSON_PRETTY_PRINT);
			file_put_contents($this->filePath, $data);
		}

	}
}