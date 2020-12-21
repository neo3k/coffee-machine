<?php

namespace App\Infrastructure\Drink\Income\Query;

use App\Domain\Entity\Income;

class StoreQuery extends Init
{
    public function storeProfit(Income $income): void
    {
        $this->em->persist($income);

        $this->em->flush();
    }
}