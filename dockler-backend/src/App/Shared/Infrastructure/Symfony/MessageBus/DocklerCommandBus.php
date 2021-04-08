<?php

namespace App\App\Shared\Infrastructure\Symfony\MessageBus;

use Symfony\Component\Messenger\MessageBusInterface;

class DocklerCommandBus extends AbstractDocklerBus
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        parent::__construct($messageBus);
    }
}
