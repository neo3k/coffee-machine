<?php

namespace App\Infrastructure\Drink\Specification;

use App\Domain\Drink\Exception\CriteriaException;
use App\Domain\Drink\ValueObject\Type;
use App\Domain\Shared\Utils;
use Symfony\Component\Console\Output\OutputInterface;

class AllowedTypeSpecification
{

    /**
     * @param Type $type
     * @param OutputInterface $output
     * @return bool|null
     */
    public function ensureIsAllowedDrinkType(Type $type, OutputInterface $output): ?bool
    {

        if (!in_array($type->toString(), $type->values(), true)) {
            $message = 'The drink type should be ' . Utils::implodeArrayFinalDelimiter(', ', ' or ', $type->values()) . '.';

            $output->write($message);

            throw new CriteriaException($message);
        }

        return true;
    }
}