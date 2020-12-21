<?php

namespace App\Tests\Infrastructure\Drink\Specification;

use App\Domain\Drink\Exception\CriteriaException;
use App\Domain\Drink\ValueObject\Type;
use App\Infrastructure\Drink\Specification\AllowedTypeSpecification;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;

class AllowedTypeSpecificationTest extends TestCase
{

    protected Type $type;
    protected OutputInterface $output;

    /**
     * @test
     */
    public function ensure_is_allowed_drinktype(): void
    {
        $criteria = (new AllowedTypeSpecification())->ensureIsAllowedDrinkType(
            $this->type,
            $this->output
        );

        self::assertTrue($criteria);
    }

    /**
     * @test
     */
    public function do_not_order_if_it_is_not_a_allowed_drinktype(): void
    {
        $this->type = new Type('redbull');

        $this->expectException(CriteriaException::class);

        (new AllowedTypeSpecification())->ensureIsAllowedDrinkType(
            $this->type,
            $this->output
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->type = new Type('coffee');
        $this->output = $this->createMock(OutputInterface::class);
    }
}
