<?php

declare(strict_types=1);

namespace App\Domain\Drink;

use App\Domain\Drink\ValueObject\Money;
use App\Domain\Drink\ValueObject\Type;
use App\Domain\Drink\ValueObject\Order;
use App\Domain\Drink\ValueObject\Sugar;
use App\Infrastructure\Drink\Specification\AllowedTypeSpecification;
use App\Infrastructure\Drink\Specification\EnoughMoneySpecification;
use App\Infrastructure\Drink\Specification\QuantitySugarSpecification;
use App\Domain\Drink\Income\Repository\IncomeInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use App\Domain\Drink\Exception\CriteriaException;

class Drink
{
    private string $type;

    private float $money;

    public function create(
        OutputInterface $output,
        Order $order,
        AllowedTypeSpecification $allowedTypeSpecification,
        EnoughMoneySpecification $enoughMoneySpecification,
        QuantitySugarSpecification $quantitySugarSpecification,
        IncomeInterface $incomeRepository
    ): int {

        try {
            $allowedTypeSpecification->ensureIsAllowedDrinkType($order->getType(), $output);
            $enoughMoneySpecification->ensureHaveEnoughMoney($order->getType(), $order->getMoney(), $output);
            $quantitySugarSpecification->ensureSugarIsBetweenAllowedQty($order->getSugar(), $output);

        } catch (CriteriaException $e) {
            return Command::FAILURE;
        }

        $output->write(
            $this->generateOrderMessage($order->getType(), $order->getExtraHot(), $order->getSugar())
        );

        $drink = new self();
        $drink->setType($order->getType());
        $drink->setMoney($order->getMoney());

        $incomeRepository->store($drink);

        return Command::SUCCESS;
    }

    private function setType(Type $type): void
    {
        $this->type = $type->toString();
    }

    private function setMoney(Money $money): void
    {
        $this->money = $money->toFloat();
    }

    public function type(): string
    {
        return $this->type;
    }

    public function money(): float
    {
        return $this->money;
    }

    private function setOrderTypeMessage(Type $type): string
    {
        return 'You have ordered a ' . $type->toString();
    }

    private function setOrderSugarMessage(Sugar $sugars): string
    {
        return ($sugars->toInt() > 0) ? ' with ' . $sugars->toInt() . ' sugars (stick included)' : '';
    }

    private function setOrderExtraHotMessage(bool $extraHot): string
    {
        return $extraHot ? ' extra hot' : '';
    }

    private function generateOrderMessage(Type $type, bool $extraHot, Sugar $sugars): string
    {
        return ($this->setOrderTypeMessage($type) . $this->setOrderExtraHotMessage($extraHot) . $this->setOrderSugarMessage($sugars));
    }


}
