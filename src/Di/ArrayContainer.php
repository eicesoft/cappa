<?php
declare(strict_types=1);

namespace Cappa\Di;


use Cappa\Di\Annotation\Autowiring;
use Cappa\Di\Reflection\ReflectionManager;

/**
 * Class ArrayContainer
 * @package Cappa\Di
 */
class ArrayContainer implements ContainerInterface
{
    /**
     * @var string[]
     */
    private array $values = [];

    public function __construct()
    {
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function get(string $id): mixed
    {
        return $this->values[$id] ?? null;
    }

    public function warp()
    {
        /** @var Proxy $value */
        foreach($this->values as $value) {
            $value->warp();
        }
    }

    /**
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->values[$id]) ?? false;
    }

    /**
     * @param string $id
     * @param array $parameters
     * @return mixed
     */
    public function make($id, array $parameters = [])
    {
        if (!$this->has($id)) {
            $this->values[$id] = ReflectionManager::create($id);
        }

        return $this->values[$id];
    }

    public function put($object)
    {
        $id = $object::class;

        $this->values[$id] = $object;
    }
}