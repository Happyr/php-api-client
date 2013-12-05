<?php


namespace HappyR\ApiClient\Api;

use HappyR\ApiClient\Http\Client;

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
     * @param Client $httpClient
     */
    public function __construct(Client &$httpClient)
    {
        $this->httpClient = $httpClient;
    }


    /**
     * Deserialize an object
     *
     * @param string $data The raw response from the API-server
     * @param string $class The full class path to the object beeing deserialized
     *
     * @return an instance of $class
     */
    protected function deserialize($data, $class)
    {
        return $this->serializer->deserialize($data, $class, $this->configuration->format);
    }


}