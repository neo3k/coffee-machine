<?php

namespace App\Tests\UI\Cli\Command;

use App\Tests\UI\Cli\AbstractConsoleTestCase;
use App\UI\Cli\Command\GetIncomeCommand;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Tester\CommandTester;

class GetIncomeCommandTest extends AbstractConsoleTestCase
{
    protected $entityManagerInterface;
    protected CommandTester $commandTester;


    /**
     * @test
     */
    public function show_income_table_success(): void
    {
        /** @var EntityManagerInterface $entityManagerInterface */
        $entityManagerInterface = $this->service(EntityManagerInterface::class);

        $commandTester = $this->app($command = new GetIncomeCommand($entityManagerInterface), 'app:get-income');

        $commandTester->execute(
            array(
                'command' => 'app:get-income'
            )
        );

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString(
            '╔═══════╤═══════╗
║ Drink │ Money ║
╚═══════╧═══════╝
',
            $output
        );
    }

}
