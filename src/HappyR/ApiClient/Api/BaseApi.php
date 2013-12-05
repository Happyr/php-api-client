<?php


namespace HappyR\ApiClient\Api;

use HappyR\ApiClient\Http\Client;
use HappyR\ApiClient\Http\Response;
use HappyR\ApiClient\Serializer\SerializerInterface;

/**
 * Class BaseApi
 *
 * @author Tobias Nyholm
 *
 */
abstract class BaseApi
{
    /**
     * @var Client httpClient
     *
     */
    protected $httpClient;

    /**
     * @var SerializerInterface serializer
     *
     */
    protected $serializer;

    /**
     * @param Client $httpClient
     * @param SerializerInterface $serializer
     */
    public function __construct(Client $httpClient, SerializerInterface $serializer)
    {
        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
    }

    /**
     * Deserialize an object
     *
     * @param Response &$response
     * @param string $class the fqn of the class
     *
     * @return array|object instance of $class
     */
    protected function deserialize(Response &$response, $class)
    {
        return $this->serializer->deserialize($response->getBody(), $class, $response->getFormat());
    }
}