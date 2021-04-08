<?php

namespace App\App\Shared\UI\Response;

use JMS\Serializer\SerializationContext;

class SerializedEntityResponse
{
    private SerializerWrapper $serializerWrapper;

    public function __construct(SerializerWrapper $serializerWrapper)
    {
        $this->serializerWrapper = $serializerWrapper;
    }

    public function fromEntity($entity, $group = null)
    {
        return $this->decode($entity, $group);
    }

    public function fromArray(array $array, $group = null)
    {
        return $this->decode($array, $group);
    }

    private function decode($toSerialize, $group)
    {
        $serializationContext = $group === null ? SerializationContext::create()->enableMaxDepthChecks() :
            SerializationContext::create()->enableMaxDepthChecks()->setGroups($group);

        $serializationContext->setSerializeNull(true);

        return json_decode($this->serializerWrapper->getSerializer()->serialize($toSerialize, 'json', $serializationContext), true);
    }
}
