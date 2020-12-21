<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Bus\Command;

use App\Application\Command\CommandBusInterface;
use App\Application\Command\CommandInterface;
use App\Infrastructure\Shared\Bus\MessageBusExceptionTrait;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Throwable;

final class MessengerCommandBus implements CommandBusInterface
{
    use MessageBusExceptionTrait;

    private MessageBusInterface $messageBus;

    private int $commandStatus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @throws Throwable
     */
    public function handle(CommandInterface $command): void
    {
        try {
            $wrapper = $this->messageBus->dispatch($command);
            $this->commandStatus = $wrapper->last(HandledStamp::class)->getResult();
        } catch (HandlerFailedException $e) {
            $this->throwException($e);
        }
    }

    /**
     * @return int
     */
    public function getCommandStatus(): int
    {
        return $this->commandStatus;
    }
}
