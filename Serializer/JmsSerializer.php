<?php


namespace HappyR\ApiClient\Serializer;

use JMS\Serializer\SerializerBuilder;

/**
 * Class JmsSerializer
 *
 *
 */
class JmsSerializer extends SerializerBuilder implements SerializerInterface
{
    /**
     * @var \JMS\Serializer\Serializer serializer
     *
     *
     */
    protected $serializer;

    /**
     * Init the serializer
     */
    function __construct()
    {
        $this->serializer = SerializerBuilder::create()->build();
    }

    /**
     *
     *
     * @param string $data
     * @param string $type
     * @param string $format
     *
     * @return array|scalar|object|void
     */
    public function deserialize($data, $type, $format)
    {
        return $this->serializer->deserialize($data, $type, $format);
    }

    /**
     * Serializes the given data to the specified output format.
     *
     * @param object|array|scalar $data
     * @param string $format
     *
     * @return string
     */
    public function serialize($data, $format)
    {
        return $this->serializer->serialize($data, $format);
    }
}