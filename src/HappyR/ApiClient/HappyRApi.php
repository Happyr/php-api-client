<?php

namespace HappyR\ApiClient;

use HappyR\ApiClient\Api\PotentialApi;
use HappyR\ApiClient\Api\UserApi;
use HappyR\ApiClient\Http\Client;
use HappyR\ApiClient\Exceptions\HttpException;
use HappyR\ApiClient\Exceptions\UserConflictException;

use HappyR\ApiClient\Entity\User;
use HappyR\ApiClient\Entity\Potential\Profile;
use HappyR\ApiClient\Entity\Potential\Statement;
use HappyR\ApiClient\Entity\Potential\Answer;
use HappyR\ApiClient\Http\Response;
use HappyR\ApiClient\Serializer\SerializerInterface;


/**
 * This is the API class that should be used with every api call
 * Every public function in this class represent a end point in the API
 */
class HappyRApi
{
    /**
     * @var Configuration configuration
     *
     * This is the configuration class
     */
    private $configuration;

    /**
     * @var Client httpClient
     *
     * The connection is the class that is doing the actual http request
     */
    protected $httpClient;


    /**
     * @var SerializerInterace serializer
     *
     */
    protected $serializer;

    /**
     * @var PotentialApi potentialApi
     *
     */
    protected $potentialApi;

    /**
     * @var UserApi userApi
     *
     */
    protected $userApi;

    /**
     * A standard constructor that take some optional parameters.
     * If you don't inject a configuration class in the constructor it will use
     * the static values written in Configuration.php
     *
     * @param Configuration $config

     */
    public function __construct(Configuration $config=null)
    {
        //if we don't get a configuration object in the parameter, then create one now.
        if($config==null){
            $config=new Configuration();
        }

        $this->configuration=$config;
    }

    /**
     *
     * @param \HappyR\ApiClient\SerializerInterface $serializer
     *
     * @return $this
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;

        return $this;
    }

    /**
     *
     * @return \HappyR\ApiClient\SerializerInterace
     */
    protected function getSerializer()
    {
        if (!$this->serializer) {
            $class = $this->configuration->serializerClass;
            $this->serializer=new $class();
        }

        return $this->serializer;
    }

    /**
     *
     * @param \HappyR\ApiClient\Http\Client $httpClient
     *
     * @return $this
     */
    public function setHttpClient(Client $httpClient)
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    /**
     *
     * @return \HappyR\ApiClient\Http\Client
     */
    protected function getHttpClient()
    {
        if (!$this->httpClient) {
            $class = $this->configuration->httpRequestClass;
            $this->httpClient=new $class();
        }

        return $this->httpClient;
    }

    /**
     * Get the potential api
     *
     * @param bool $forceNew if true we will create a new PotentialApi object
     *
     * @return UserApi
     */
    public function getPotentialApi($forceNew = false)
    {

        if (!$this->potentialApi || $forceNew) {
            $this->potentialApi = new PotentialApi($this->getHttpClient(), $this->getSerializer());
        }

        return $this->potentialApi;
    }

    /**
     * Get the user api
     *
     * @param bool $forceNew if true we will create a new UserApi object
     *
     * @return UserApi
     */
    public function getUserApi($forceNew = false)
    {
        if (!$this->userApi || $forceNew) {
            $this->userApi = new UserApi($this->getHttpClient(), $this->getSerializer());
        }

        return $this->userApi;
    }
}
