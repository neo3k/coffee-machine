<?php

namespace App\Tests\Infrastructure\Drink\Specification;

use App\Domain\Drink\Exception\CriteriaException;
use App\Domain\Drink\ValueObject\Sugar;
use App\Infrastructure\Drink\Specification\QuantitySugarSpecification;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;

class QuantitySugarSpecificationTest extends TestCase
{

    protected Sugar $sugar;
    protected OutputInterface $output;

    /**
     * @test
     */
    public function ensure_sugar_is_between_allowed_qty(): void
    {
        $criteria = (new QuantitySugarSpecification())->ensureSugarIsBetweenAllowedQty(
            $this->sugar,
            $this->output
        );

        self::assertTrue($criteria);
    }

    /**
     * @test
     */
    public function do_not_order_if_sugar_is_not_between_allowed_qty(): void
    {
        $this->sugar = new Sugar(20);

        $this->expectException(CriteriaException::class);

        (new QuantitySugarSpecification())->ensureSugarIsBetweenAllowedQty(
            $this->sugar,
            $this->output
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->sugar = new Sugar(2);
        $this->output = $this->createMock(OutputInterface::class);
    }
}
