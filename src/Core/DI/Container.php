<?php

namespace Bisix21\src\Core\DI;

use DiggPHP\Psr11\NotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;

class Container implements ContainerInterface
{
	private static ?Container $instance = null;
	private array $dependencies;

	private function __construct($dependencies = [])
	{
		$this->dependencies = $dependencies;
	}

	public static function getInstance($dependencies = []): self
	{
		if (null === self::$instance) {
			self::$instance = new self($dependencies);
		}
		return self::$instance;
	}

	/**
	 * @throws NotFoundExceptionInterface
	 * @throws NotFoundException
	 * @throws ReflectionException
	 * @throws ContainerExceptionInterface
	 */
	public function get($id)
	{
			return  $this->prepare($id);
	}

	public function has($id): bool
	{
		return array_key_exists($id, $this->dependencies);
	}

	/**
	 * @throws ReflectionException
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	protected function prepare(string $id)
	{
		$arguments = [];
		$refClass = new \ReflectionClass($id);
		$refConstruct = $refClass->getConstructor();
		$this->isEmptyArgOrParam($refConstruct, fn () => new $id);
		$refArgument = $refConstruct->getParameters();
		foreach ($refArgument as $argument)
		{
			$argumentType = $argument->getType()->getName();
			$denied = ['array', 'string', 'int'];
			if(in_array($argumentType, $denied))
			{
				break;
			}
			$arguments[$argument->getName()] = $this->get($argumentType);;
		}
		return new $id(...$arguments);
	}

	protected function isEmptyArgOrParam($condition, $callback)
	{
		$res = null;
		if (empty($condition)) {
			$res =  call_user_func($callback);
		}
		return $res;
	}
}