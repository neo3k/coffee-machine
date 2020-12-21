<?php

namespace App\Infrastructure\Drink\Income\Query;

use App\Domain\Entity\Income;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

abstract class Init
{
    protected ObjectRepository $incomeRepository;
    protected ObjectManager $em;

    public function __construct(ObjectManager $objectManager)
    {
        $this->em = $objectManager;
        $this->incomeRepository = $objectManager
            ->getRepository(Income::class);
    }
}