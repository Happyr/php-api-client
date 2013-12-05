<?php

namespace HappyR\ApiClient;

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
     * @var  configuration
     *
     * This is the configuration class
     */
    private $configuration;

    /**
     * @var  Client
     *
     * The connection is the class that is doing the actual http request
     */
    protected $connection;

    /**
     * @var  serializer
     *
     *
     */
    protected $serializer;


    /**
     * A standard constructor that take some optional parameters.
     * If you dont inject a configuration class in the constructor it will use
     * the static values written in Configuration.php
     *
     * @param Configuration $config
     * @param SerializerInterace $serializer
     * @param Client $connection
     */
    public function __construct(
            Configuration $config=null,
            SerializerInterface $serializer=null,
            Client $connection=null
    ) {
        //if we don't get a configuration object in the parameter, then create one now.
        if($config==null){
            $config=new Configuration();
        }

        if($serializer==null){
            $serializerClass=$config->serializerClass;
            $serializer=new $serializerClass();
        }

        if($connection==null){
            $connection=new Client($config);
        }

        $this->configuration=$config;
        $this->serializer=$serializer;
        $this->connection=$connection;
    }
}
