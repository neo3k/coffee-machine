<?php

namespace App\Tests\Infrastructure\Drink\Income\Repository;

use App\Domain\Entity\Income;
use App\Infrastructure\Drink\Income\Query\GetQuery;
use App\Infrastructure\Drink\Income\Repository\IncomeRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

class IncomeRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function store_income_works(): void
    {
        $income = new Income();
        $income->setDrink('coffee');
        $income->setMoney(15);

        $incomeRepository = $this->createMock(ObjectRepository::class);

        $incomeRepository->expects($this->any())
            ->method('findOneBy')
            ->willReturn($income);

        $objectManager = $this->createMock(ObjectManager::class);
        $objectManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($incomeRepository);

        $getIncomeQuery = new GetQuery($objectManager);

        $query = $getIncomeQuery->getByDrinkType($income->getDrink());

        self::assertEquals($income, $query);
        self::assertEquals($income->getMoney(), $query->getMoney());
    }
}
