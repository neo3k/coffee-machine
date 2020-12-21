<?php

namespace App\Tests\Infrastructure\Drink\Specification;

use App\Domain\Drink\Exception\CriteriaException;
use App\Infrastructure\Drink\Specification\EnoughMoneySpecification;
use App\Domain\Drink\ValueObject\Type;
use App\Domain\Drink\ValueObject\Money;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;

class EnoughMoneySpecificationTest extends TestCase
{
    protected Type $type;
    protected Money $money;
    protected OutputInterface $outputInterface;

    /**
     * @test
     */
    public function ensure_have_enough_money(): void
    {
        $criteria = (new EnoughMoneySpecification())->ensureHaveEnoughMoney(
            $this->type,
            $this->money,
            $this->outputInterface
        );

        self::assertTrue($criteria);
    }

    /**
     * @test
     */
    public function do_not_order_if_there_is_not_enough_money(): void
    {
        $this->money = new Money(0.3);

        $this->expectException(CriteriaException::class);

        (new EnoughMoneySpecification())->ensureHaveEnoughMoney(
            $this->type,
            $this->money,
            $this->outputInterface
        );

    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->type = new Type('coffee');
        $this->money = new Money(0.5);
        $this->outputInterface = $this->createMock(OutputInterface::class);
    }
}
