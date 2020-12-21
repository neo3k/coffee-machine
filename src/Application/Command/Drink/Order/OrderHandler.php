<?php

namespace App\Application\Command\Drink\Order;

use App\Domain\Drink\Drink;
use App\Application\Command\CommandHandlerInterface;
use App\Domain\Drink\Income\Repository\IncomeInterface;
use App\Infrastructure\Drink\Specification\AllowedTypeSpecification;
use App\Infrastructure\Drink\Specification\EnoughMoneySpecification;
use App\Infrastructure\Drink\Specification\QuantitySugarSpecification;

class OrderHandler implements CommandHandlerInterface
{
    private AllowedTypeSpecification $allowedTypeSpecification;
    private EnoughMoneySpecification $enoughMoneySpecification;
    private QuantitySugarSpecification $quantitySugarSpecification;
    private IncomeInterface $incomeRepository;

    public function __construct(
        AllowedTypeSpecification $allowedTypeSpecification,
        EnoughMoneySpecification $enoughMoneySpecification,
        QuantitySugarSpecification $quantitySugarSpecification,
        IncomeInterface $incomeRepository
    ) {
        $this->allowedTypeSpecification = $allowedTypeSpecification;
        $this->enoughMoneySpecification = $enoughMoneySpecification;
        $this->quantitySugarSpecification = $quantitySugarSpecification;
        $this->incomeRepository = $incomeRepository;
    }

    public function __invoke(OrderCommand $command): int
    {
        return (new Drink())->create(
            $command->output,
            $command->order,
            $this->allowedTypeSpecification,
            $this->enoughMoneySpecification,
            $this->quantitySugarSpecification,
            $this->incomeRepository
        );
    }
}
