<?php

declare(strict_types=1);

namespace App\Domain\Drink\ValueObject;

final class Price
{
    private array $drinkPrices;

    public function __construct()
    {
        $this->getPrices();
    }

    public function getPrices(): array
    {
        $this->drinkPrices = [
            ['name' => Type::TEA, 'price' => 0.4],
            ['name' => Type::COFFEE, 'price' => 0.5],
            ['name' => Type::CHOCOLATE, 'price' => 0.6]
        ];

        return $this->drinkPrices;
    }

    public function getPriceByType($type): float
    {
        $key = array_search($type, array_column($this->drinkPrices, 'name'));
        return $this->drinkPrices[$key]['price'];
    }

}