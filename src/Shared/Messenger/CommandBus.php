<?php

declare(strict_types=1);

namespace App\Shared\Messenger;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class CommandBus
{
    use HandleTrait;

    public function __construct(private readonly MessageBusInterface $commandBus)
    {
        $this->messageBus = $this->commandBus;
    }

    public function dispatch(object $command): mixed
    {
        return $this->handle($command);
    }
}
