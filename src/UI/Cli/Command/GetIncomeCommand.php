<?php

namespace App\UI\Cli\Command;

use App\Domain\Entity\Income;
use App\Infrastructure\Drink\Income\Repository\IncomeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\Table;

class GetIncomeCommand extends Command
{
    private IncomeRepository $incomeRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->incomeRepository = $entityManager->getRepository(Income::class);

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('app:get-income');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Assert\AssertionFailedException
     * @throws \Throwable
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = array();
        foreach ($this->incomeRepository->findAll() as $profit) {
            $data[] = array(ucfirst($profit->getDrink()), $profit->getMoney());
        }

        $table = new Table($output);
        $table
            ->setHeaders(['Drink', 'Money'])
            ->setRows($data);
        $table->setStyle('box-double');
        $table->render();

        return Command::SUCCESS;
    }
}
