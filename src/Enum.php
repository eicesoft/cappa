<?php
declare(strict_types=1);

namespace Cappa;


use Cappa\Di\Reflection\ReflectionManager;
use Cappa\Exception\ErrorException;
use JetBrains\PhpStorm\Pure;
use ReflectionException;

class Enum
{
    /**
     * @var mixed
     */
    private $value;

    private array $values;

    /**
     * @param mixed $value
     * @return static
     */
    public static function valueOf($value): self
    {
        $cls = get_called_class();
        return new $cls($value);
    }

    /**
     * Enum constructor.
     * @param mixed $value
     * @throws ErrorException
     * @throws ReflectionException
     */
    private function __construct(mixed $value)
    {
        $reflection = ReflectionManager::get(static::class);

        $this->values = $reflection->getConstants();
        if (in_array($value, $this->values)) {
            $this->value = $value;
        } else {
            throw new ErrorException(static::class . ' 不存在枚举值: ' . $value);
        }
    }

    /**
     * @return mixed
     */
    public function value(): mixed
    {
        return $this->value;
    }

    public function values(): array
    {
        return array_keys($this->values);
    }

    /**
     * @param mixed $val
     * @return bool
     */
    #[Pure] public function compare(mixed $val): bool
    {
        if ($val instanceof Enum) {
            return $val->value() === $this->value;
        } elseif (is_scalar($val)) {
            return $val === $this->value;
        } else {
            return false;
        }
    }

    public function __toString(): string
    {
        return $this->value;
    }


}