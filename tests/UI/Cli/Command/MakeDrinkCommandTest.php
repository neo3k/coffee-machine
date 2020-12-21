<?php

namespace App\Tests\UI\Cli\Command;

use App\Application\Command\CommandBusInterface;
use App\Tests\UI\Cli\AbstractConsoleTestCase;
use App\UI\Cli\Command\MakeDrinkCommand;
use Symfony\Component\Console\Tester\CommandTester;

class MakeDrinkCommandTest extends AbstractConsoleTestCase
{
    protected $commandBus;
    protected CommandTester $commandTester;

    /**
     * @dataProvider ordersProvider
     */
    public function test_drink_machine_returns_the_expected_output(
        string $drinkType,
        float $money,
        int $sugars,
        int $extraHot,
        string $expectedOutput
    ): void {

        /** @var CommandBusInterface $commandBus */
        $commandBus = $this->service(CommandBusInterface::class);
        $commandTester = $this->app($commandBus = new MakeDrinkCommand($commandBus), 'app:order-drink');

        $commandTester->execute(
            array(
                'command' => $commandBus->getName(),

                // pass arguments to the helper
                'drink-type' => $drinkType,
                'money' => $money,
                'sugars' => $sugars,
                '--extra-hot' => $extraHot
            )
        );

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        self::assertSame($expectedOutput, $output);
    }

    /**
     * @test
     */
    public function order_drink_command_integration_with_bus_success(): void
    {
        $drinkType = 'tea';
        $money = 0.4;
        $sugars = 2;

        /** @var CommandBusInterface $commandBus */
        $commandBus = $this->service(CommandBusInterface::class);
        $commandTester = $this->app($command = new MakeDrinkCommand($commandBus), 'app:order-drink');

        $commandTester->execute(
            [
                'command' => $command->getName(),
                'drink-type' => $drinkType,
                'money' => $money,
                'sugars' => $sugars,
                '--extra-hot' => null
            ]
        );

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('You have ordered a tea extra hot with 2 sugars (stick included)', $output);
    }

    /**
     * @test
     */
    public function do_not_order_if_it_is_not_a_allowed_drinktype_output(): void
    {
        $drinkType = 'cliper';
        $money = 0.4;
        $sugars = 2;

        /** @var CommandBusInterface $commandBus */
        $commandBus = $this->service(CommandBusInterface::class);
        $commandTester = $this->app($command = new MakeDrinkCommand($commandBus), 'app:order-drink');

        $commandTester->execute(
            [
                'command' => $command->getName(),
                'drink-type' => $drinkType,
                'money' => $money,
                'sugars' => $sugars,
                '--extra-hot' => null
            ]
        );

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('The drink type should be tea, coffee or chocolate.', $output);
    }

    /**
     * @test
     */
    public function do_not_order_if_there_is_not_enough_money_output(): void
    {
        $drinkType = 'coffee';
        $money = 0.1;
        $sugars = 2;

        /** @var CommandBusInterface $commandBus */
        $commandBus = $this->service(CommandBusInterface::class);
        $commandTester = $this->app($command = new MakeDrinkCommand($commandBus), 'app:order-drink');

        $commandTester->execute(
            [
                'command' => $command->getName(),
                'drink-type' => $drinkType,
                'money' => $money,
                'sugars' => $sugars,
                '--extra-hot' => null
            ]
        );

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('The coffee costs 0.5.', $output);
    }

    /**
     * @test
     */
    public function do_not_order_if_sugar_is_not_between_allowed_qty_output(): void
    {
        $drinkType = 'coffee';
        $money = 0.5;
        $sugars = 20;

        /** @var CommandBusInterface $commandBus */
        $commandBus = $this->service(CommandBusInterface::class);
        $commandTester = $this->app($command = new MakeDrinkCommand($commandBus), 'app:order-drink');

        $commandTester->execute(
            [
                'command' => $command->getName(),
                'drink-type' => $drinkType,
                'money' => $money,
                'sugars' => $sugars,
                '--extra-hot' => null
            ]
        );

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('The number of sugars should be between 0 and 2.', $output);
    }

    public function ordersProvider(): array
    {
        return [
            [
                'chocolate', 0.7, 1, 0, 'You have ordered a chocolate with 1 sugars (stick included)'
            ],
            [
                'tea', 0.4, 0, 1, 'You have ordered a tea extra hot'
            ],
            [
                'coffee', 2, 2, 1, 'You have ordered a coffee extra hot with 2 sugars (stick included)'
            ],
            [
                'coffee', 0.2, 2, 1, 'The coffee costs 0.5.'
            ],
            [
                'chocolate', 0.3, 2, 1, 'The chocolate costs 0.6.'
            ],
            [
                'tea', 0.1, 2, 1, 'The tea costs 0.4.'
            ],
            [
                'tea', 0.5, -1, 1, 'The number of sugars should be between 0 and 2.'
            ],
            [
                'tea', 0.5, 3, 1, 'The number of sugars should be between 0 and 2.'
            ],
        ];
    }

}
