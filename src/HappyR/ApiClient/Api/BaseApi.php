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
     * @var \HappyR\ApiClient\Http\Client httpClient
     *
     */
    protected $httpClient;

    /**
     * @var  serializer
     *
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
     * @param string $data The raw response from the API-server
     * @param string $class The full class path to the object beeing deserialized
     *
     * @return an instance of $class
     */
    protected function deserialize(Response &$response, $class)
    {
        return $this->serializer->deserialize($response->getBody(), $class, $response->getFormat());
    }


}