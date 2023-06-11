<?php

namespace Bisix21\src\UrlShort\Repository;

use Bisix21\src\Core\Config;
use Bisix21\src\UrlShort\Interface\DBInterface;
use InvalidArgumentException;

class Files implements DBInterface
{
	protected array $dataArray;
	protected string $pathUrls;

	public function __construct(
	)
	{
		$this->pathUrls = Config::instance()->get('config.urls');
		$this->dataArray = $this->getData();
	}

	protected function getData(): array
	{
		return json_decode(file_get_contents($this->pathUrls), true);
	}

	public function read(string $code): string|null
	{
		if (!file_exists($this->pathUrls)) {
			file_put_contents($this->pathUrls, '');
			throw new InvalidArgumentException('File don\'t exist, rerun code');
		}
		return $this->dataArray[$code];
	}

	public function saveToDB($data): void
	{
		if (array_search($data['url'], $this->dataArray)) {
			throw new InvalidArgumentException("You have same record: {$data['code']} => {$data['url']}");
		}
		$this->dataArray[$data['code']] = $data['url'];
		if (!empty($data)) {
			file_put_contents(
				$this->pathUrls,
				json_encode(
					$this->dataArray,
					JSON_PRETTY_PRINT
				)
			);
		}
	}
}