<?php

namespace App\Domain\Drink\Income\Repository;

use App\Domain\Drink\Drink;

interface IncomeInterface
{
    public function store(Drink $drink): void;
}
