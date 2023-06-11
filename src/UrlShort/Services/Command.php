<?php

namespace Bisix21\src\UrlShort\Services;

use Bisix21\src\Core\DI\Container;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

class Command
{
	public function __construct(
		protected Validator $validator
	)
	{
	}

	/**
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface|ReflectionException
	 */
	public function run($givenCommand): void
	{
		foreach ($this->validator->allowedCommands() as $key => $command) {
			if ($givenCommand === $key ) {
				Container::getInstance()->get($command)->runAction();
			}
		}
	}
}