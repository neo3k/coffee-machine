<?php

namespace App\Infrastructure\Drink\Income\Query;

class GetQuery extends Init
{
    /**
     * @param string $drinkType
     * @param float $money
     * @return float|null
     */
    public function sumIncome(string $drinkType, float $money): float
    {
        $income = $this->incomeRepository->findOneBy(['drink' => $drinkType]);

        return is_null($income) ? (0.0 + $money) : ($income->getMoney() + $money);
    }

    /**
     * @param string $drinkType
     * @return object|null
     */
    public function getByDrinkType(string $drinkType): ?object
    {
        return $this->incomeRepository->findOneBy(['drink' => $drinkType]);
    }
}