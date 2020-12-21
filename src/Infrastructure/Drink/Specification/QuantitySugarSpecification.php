<?php

namespace App\Infrastructure\Drink\Specification;

use App\Domain\Drink\Exception\CriteriaException;
use App\Domain\Drink\ValueObject\Sugar;
use Symfony\Component\Console\Output\OutputInterface;

class QuantitySugarSpecification
{

    /**
     * @param Sugar $sugar
     * @param OutputInterface $output
     * @return bool|null
     */
    public function ensureSugarIsBetweenAllowedQty(Sugar $sugar, OutputInterface $output): ?bool
    {
        if ($sugar->toInt() < $sugar->getAllowedQty()[0] || $sugar->toInt() > $sugar->getAllowedQty()[1]) {
            $message = 'The number of sugars should be between ' . $sugar->getAllowedQty()[0] . ' and ' .
                $sugar->getAllowedQty()[1] . '.';

            $output->write($message);

            throw new CriteriaException($message);
        }

        return true;
    }
}