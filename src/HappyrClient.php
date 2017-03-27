<?php

namespace Happyr\ApiClient;

use Happyr\ApiClient\Hydrator\Hydrator;
use Happyr\ApiClient\Hydrator\ModelHydrator;
use Http\Client\HttpClient;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
final class HappyrClient
{
    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var Hydrator
     */
    private $hydrator;

    /**
     * @var RequestFactory
     */
    private $requestFactory;

    /**
     * The constructor accepts already configured HTTP clients.
     * Use the configure method to pass a configuration to the Client and create an HTTP Client.
     *
     * @param HttpClient          $httpClient
     * @param Hydrator|null       $hydrator
     * @param RequestFactory|null $requestFactory
     */
    public function __construct(
        HttpClient $httpClient,
        Hydrator $hydrator = null,
        RequestFactory $requestFactory = null
    ) {
        $this->httpClient = $httpClient;
        $this->hydrator = $hydrator ?: new ModelHydrator();
        $this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
    }

    /**
     * @param HttpClientConfigurator $httpClientConfigurator
     * @param Hydrator|null          $hydrator
     * @param RequestFactory|null    $requestFactory
     *
     * @return HappyrClient
     */
    public static function configure(
        HttpClientConfigurator $httpClientConfigurator,
        Hydrator $hydrator = null,
        RequestFactory $requestFactory = null
    ) {
        $httpClient = $httpClientConfigurator->createConfiguredClient();

        return new self($httpClient, $hydrator, $requestFactory);
    }

    /**
     * @param string $identifier
     * @param string $secret
     *
     * @return HappyrClient
     */
    public static function create($identifier, $secret)
    {
        $httpClientConfigurator = (new HttpClientConfigurator())->setApiCredentials($identifier, $secret);

        return self::configure($httpClientConfigurator);
    }

    /**
     * @return Api\Interview
     */
    public function interview()
    {
        return new Api\Interview($this->httpClient, $this->hydrator, $this->requestFactory);
    }

    /**
     * @return Api\Dimension
     */
    public function dimensions()
    {
        return new Api\Dimension($this->httpClient, $this->hydrator, $this->requestFactory);
    }

    /**
     * @return Api\Match
     */
    public function match()
    {
        return new Api\Match($this->httpClient, $this->hydrator, $this->requestFactory);
    }

    /**
     * @return Api\Norm
     */
    public function norm()
    {
        return new Api\Norm($this->httpClient, $this->hydrator, $this->requestFactory);
    }

    /**
     * @return Api\ProfilePattern
     */
    public function profilePattern()
    {
        return new Api\ProfilePattern($this->httpClient, $this->hydrator, $this->requestFactory);
    }

    /**
     * @return Api\Statement
     */
    public function statement()
    {
        return new Api\Statement($this->httpClient, $this->hydrator, $this->requestFactory);
    }

    /**
     * @return Api\UserManagement
     */
    public function userManagement()
    {
        return new Api\UserManagement($this->httpClient, $this->hydrator, $this->requestFactory);
    }
}
