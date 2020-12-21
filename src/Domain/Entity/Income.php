<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Income
 * @ORM\Entity(repositoryClass=\App\Infrastructure\Drink\Income\Repository\IncomeRepository::class)
 */
class Income
{
    /**
     * @ORM\Column(type="string", length=100)
     * @ORM\Id
     */
    protected $drink;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
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