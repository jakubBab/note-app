<?php

namespace App\App\Shared\Infrastructure\Symfony\MessageBus;

use App\App\Shared\Infrastructure\Symfony\MessageBus\Contract\MessageBusInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface as BaseMessageBusInterface;

abstract class AbstractDocklerBus implements MessageBusInterface
{
    private BaseMessageBusInterface $messageBus;

    public function __construct(BaseMessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    public function publish(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatch($event);
        }
    }

    public function dispatch($message, array $stamps = []): Envelope
    {
        return $this->messageBus->dispatch($message, $stamps);
    }
}
