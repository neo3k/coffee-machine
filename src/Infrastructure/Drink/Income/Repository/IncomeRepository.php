<?php

namespace App\Infrastructure\Drink\Income\Repository;

use App\Domain\Entity\Income;
use App\Domain\Drink\Drink;
use App\Domain\Drink\Income\Repository\IncomeInterface;
use App\Infrastructure\Drink\Income\Query\GetQuery;
use App\Infrastructure\Drink\Income\Query\StoreQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;

final class IncomeRepository extends ServiceEntityRepository implements IncomeInterface
{
    private ObjectManager $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Income::class);

        $this->em = $registry->getManager();
    }

    public function store(Drink $order): void
    {
        $getQuery = new GetQuery($this->em);

        $incomeEntity = $getQuery->getByDrinkType($order->type());

        if (is_null($incomeEntity)) {
            $incomeEntity = new Income();

            $incomeEntity->setDrink($order->type());
            $incomeEntity->setMoney($order->money());
        }
        
        $incomeEntity->setMoney($getQuery->sumIncome($order->type(), $order->money()));

        (new StoreQuery($this->em))->storeProfit($incomeEntity);
    }
}
