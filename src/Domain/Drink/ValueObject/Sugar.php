<?php

declare(strict_types=1);

namespace App\Domain\Drink\ValueObject;

class Sugar
{
    private int $sugar;
    private array $qtyAllowedRange = [0, 2];

    public function __construct(int $sugar)
    {
        $this->sugar = $sugar;
    }

    public static function fromInt(string $sugar): self
    {
        return new self((int)$sugar);
    }

    public function toInt(): int
    {
        return $this->sugar;
    }

    public function __toInt(): int
    {
        return $this->sugar;
    }

    public function getAllowedQty(): array
    {
        return $this->qtyAllowedRange;
    }
}