<?php

namespace App\Application\Command\Drink\Order;

use App\Domain\Drink\ValueObject\Type;
use App\Domain\Drink\ValueObject\Money;
use App\Domain\Drink\ValueObject\Sugar;
use App\Domain\Drink\ValueObject\Order;
use App\Application\Command\CommandInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class OrderCommand implements CommandInterface
{
    /** @psalm-readonly */
    public Order $order;

    public OutputInterface $output;

    /**
     * OrderCommand constructor.
     * @param string $drinkType
     * @param float $money
     * @param int $sugar
     * @param bool $extraHot
     * @param OutputInterface $output
     */
    public function __construct(string $drinkType, float $money, int $sugar, bool $extraHot, OutputInterface $output)
    {
        $this->order = new Order(
            Type::fromString($drinkType),
            Money::fromFloat($money),
            Sugar::fromInt($sugar),
            $extraHot
        );

        $this->output = $output;
    }
}
