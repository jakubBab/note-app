<?php

namespace App\App\Shared\Infrastructure\Symfony\MessageBus;

use Symfony\Component\Messenger\MessageBusInterface;

class DocklerEventBus extends AbstractDocklerBus
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        parent::__construct($eventBus);
    }
}
