<?php

namespace App\App\Shared\UI\Response;

use JMS\Serializer\SerializerInterface;

class SerializerWrapper
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function getSerializer(): object
    {
        return $this->serializer;
    }
}
