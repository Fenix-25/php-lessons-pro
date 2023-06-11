<?php

namespace Bisix21\src\Core\DI;

use DiggPHP\Psr11\NotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
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
			return  $this->prepare($id) ??
				throw new NotFoundException("Class {$id} not found!");
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
		$classReflector = new ReflectionClass($id);
		$constructReflector = $classReflector->getConstructor();
		$this->isEmptyArgOrParam($constructReflector, fn () => new $id);
		$arguments = $constructReflector->getParameters();
		$this->isEmptyArgOrParam($arguments, fn () => new $id);
		$arg = [];
		foreach ($arguments as $argument) {
			$argumentType = $argument->getType()->getName();
			$denied = ['array', 'string', 'int'];
			if (in_array($argumentType, $denied)) {
				break;
			}
			$arg[$argument->getName()] = $this->get($argumentType);
		}
		return new $id(...$arg);
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