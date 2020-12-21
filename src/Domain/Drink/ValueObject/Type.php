<?php

declare(strict_types=1);

namespace App\Domain\Drink\ValueObject;

use ReflectionClass;
use function Lambdish\Phunctional\reindex;

class Type
{

    protected static array $cache = [];

    public const TEA = 'tea';
    public const COFFEE = 'coffee';
    public const CHOCOLATE = 'chocolate';
    private string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public static function fromString(string $type): self
    {
        return new self($type);
    }

    public function toString(): string
    {
        return $this->type;
    }

    public function __toString(): string
    {
        return $this->type;
    }

    public static function values(): array
    {
        $class = static::class;

        if (!isset(self::$cache[$class])) {
            $reflected           = new ReflectionClass($class);
            self::$cache[$class] = array_values($reflected->getConstants());
        }

        return self::$cache[$class];
    }

}
