<?php

namespace App\Infrastructure\Drink\Specification;

use App\Domain\Drink\Exception\CriteriaException;
use App\Domain\Drink\ValueObject\Type;
use App\Domain\Drink\ValueObject\Money;
use App\Domain\Drink\ValueObject\Price;
use Symfony\Component\Console\Output\OutputInterface;

class EnoughMoneySpecification
{

    /**
     * @param Type $type
     * @param Money $money
     * @param OutputInterface $output
     * @return bool|null
     */
    public function ensureHaveEnoughMoney(Type $type, Money $money, OutputInterface $output): ?bool
    {
        $price = (new Price())->getPriceByType($type->toString());

        if ($price > $money->toFloat()) {
            $message = 'The ' . $type->toString() . ' costs ' . $price . '.';

            $output->write($message);

            throw new CriteriaException($message);
        }

        return true;
    }
}