<?php

namespace App\Domain\Entity;

class Income
{
    protected $drink;

    protected $money;

    public function setDrink(string $drink): void
    {
        $this->drink = $drink;
    }

    public function setMoney(float $income): void
    {
        $this->money = $income;
    }

    /**
     * @return string
     */
    public function getDrink(): string
    {
        return $this->drink;
    }

    /**
     * @return float
     */
    public function getMoney(): float
    {
        return $this->money;
    }
}