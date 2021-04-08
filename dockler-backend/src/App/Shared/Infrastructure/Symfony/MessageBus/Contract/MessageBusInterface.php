<?php

namespace App\App\Shared\Infrastructure\Symfony\MessageBus\Contract;

use Symfony\Component\Messenger\Envelope;

interface MessageBusInterface
{
    public function publish(array $events): void;

    public function dispatch($message, array $stamps = []): Envelope;
}
