<?php

namespace App\Tests\Domain\Drink;

use App\Domain\Drink\Drink;
use App\Domain\Drink\Exception\CriteriaException;
use App\Domain\Drink\Income\Repository\IncomeInterface;
use App\Domain\Drink\ValueObject\Money;
use App\Domain\Drink\ValueObject\Order;
use App\Domain\Drink\ValueObject\Sugar;
use App\Domain\Drink\ValueObject\Type;
use App\Infrastructure\Drink\Specification\AllowedTypeSpecification;
use App\Infrastructure\Drink\Specification\EnoughMoneySpecification;
use App\Infrastructure\Drink\Specification\QuantitySugarSpecification;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

class DrinkTest extends TestCase
{
    protected Drink $drink;
    protected $outputInterfaceMock;
    protected $typeSpecificationMock;
    protected $moneySpecificationMock;
    protected $sugarSpecificationMock;
    protected $orderMock;
    protected $incomeRepositoryInterfaceMock;

    /**
     * @test
     */
    public function new_order_success(): void
    {
        $type = new Type('coffee');
        $money = new Money(0.4);
        $sugar = new Sugar(2);

        $this->orderMock->method('getType')->willReturn($type);
        $this->orderMock->method('getMoney')->willReturn($money);
        $this->orderMock->method('getSugar')->willReturn($sugar);
        $this->orderMock->method('getExtraHot')->willReturn(true);
        $this->typeSpecificationMock->method('ensureIsAllowedDrinkType')->willReturn(true);
        $this->moneySpecificationMock->method('ensureHaveEnoughMoney')->willReturn(true);
        $this->sugarSpecificationMock->method('ensureSugarIsBetweenAllowedQty')->willReturn(true);

        $order = $this->drink->create(
            $this->outputInterfaceMock,
            $this->orderMock,
            $this->typeSpecificationMock,
            $this->moneySpecificationMock,
            $this->sugarSpecificationMock,
            $this->incomeRepositoryInterfaceMock,
        );

        self::assertEquals(Command::SUCCESS, $order);
    }

    /**
     * @test
     */
    public function new_order_fails(): void
    {
        $type = new Type('fanta');
        $money = new Money(0.15);
        $sugar = new Sugar(20);

        $this->orderMock->method('getType')->willReturn($type);
        $this->orderMock->method('getMoney')->willReturn($money);
        $this->orderMock->method('getSugar')->willReturn($sugar);
        $this->orderMock->method('getExtraHot')->willReturn(true);
        $this->typeSpecificationMock->method('ensureIsAllowedDrinkType')->willThrowException(
            new CriteriaException('error')
        );
        $this->moneySpecificationMock->method('ensureHaveEnoughMoney')->willThrowException(
            new CriteriaException('error')
        );
        $this->sugarSpecificationMock->method('ensureSugarIsBetweenAllowedQty')->willThrowException(
            new CriteriaException('error')
        );

        $order = $this->drink->create(
            $this->outputInterfaceMock,
            $this->orderMock,
            $this->typeSpecificationMock,
            $this->moneySpecificationMock,
            $this->sugarSpecificationMock,
            $this->incomeRepositoryInterfaceMock,
        );

        self::assertEquals(Command::FAILURE, $order);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->outputInterfaceMock = $this->createMock(OutputInterface::class);
        $this->typeSpecificationMock = $this->createMock(AllowedTypeSpecification::class);
        $this->moneySpecificationMock = $this->createMock(EnoughMoneySpecification::class);
        $this->sugarSpecificationMock = $this->createMock(QuantitySugarSpecification::class);
        $this->incomeRepositoryInterfaceMock = $this->createMock(IncomeInterface::class);
        $this->orderMock = $this->createMock(Order::class);
        $this->drink = new Drink();
    }


}
