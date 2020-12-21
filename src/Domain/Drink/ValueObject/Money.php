<?php

declare(strict_types=1);

namespace App\Domain\Drink\ValueObject;

class Money
{
    private float $money;

    public function __construct(float $money)
    {
        $this->money = $money;
    }

    public static function fromFloat(string $money): self
    {
        return new self((float)$money);
    }

    public function toFloat(): float
    {
        return $this->money;
    }

    public function __toFloat(): float
    {
        return $this->money;
    }
}