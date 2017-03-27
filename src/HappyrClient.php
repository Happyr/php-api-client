<?php

namespace Happyr\ApiClient;

use Happyr\ApiClient\Hydrator\ModelHydrator;
use Happyr\ApiClient\Hydrator\Hydrator;
use Http\Client\HttpClient;

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
     * @var RequestBuilder
     */
    private $requestBuilder;

    /**
     * The constructor accepts already configured HTTP clients.
     * Use the configure method to pass a configuration to the Client and create an HTTP Client.
     *
     * @param HttpClient          $httpClient
     * @param Hydrator|null       $hydrator
     * @param RequestBuilder|null $requestBuilder
     */
    public function __construct(
        HttpClient $httpClient,
        Hydrator $hydrator = null,
        RequestBuilder $requestBuilder = null
    ) {
        $this->httpClient = $httpClient;
        $this->hydrator = $hydrator ?: new ModelHydrator();
        $this->requestBuilder = $requestBuilder ?: new RequestBuilder();
    }

    /**
     * @param HttpClientConfigurator $httpClientConfigurator
     * @param Hydrator|null          $hydrator
     * @param RequestBuilder|null    $requestBuilder
     *
     * @return HappyrClient
     */
    public static function configure(
        HttpClientConfigurator $httpClientConfigurator,
        Hydrator $hydrator = null,
        RequestBuilder $requestBuilder = null
    ) {
        $httpClient = $httpClientConfigurator->createConfiguredClient();

        return new self($httpClient, $hydrator, $requestBuilder);
    }

    /**
     * @param string $apiKey
     *
     * @return HappyrClient
     */
    public static function create($apiUser, $apiPassword)
    {
        $httpClientConfigurator = (new HttpClientConfigurator())->setApiCredentials($apiUser, $apiPassword);

        return self::configure($httpClientConfigurator);
    }

    /**
     * @return Api\Interview
     */
    public function interview()
    {
        return new Api\Interview($this->httpClient, $this->hydrator, $this->requestBuilder);
    }

    /**
     * @return Api\Dimension
     */
    public function dimensions()
    {
        return new Api\Dimension($this->httpClient, $this->hydrator, $this->requestBuilder);
    }

    /**
     * @return Api\Match
     */
    public function match()
    {
        return new Api\Match($this->httpClient, $this->hydrator, $this->requestBuilder);
    }

    /**
     * @return Api\Norm
     */
    public function norm()
    {
        return new Api\Norm($this->httpClient, $this->hydrator, $this->requestBuilder);
    }

    /**
     * @return Api\ProfilePattern
     */
    public function profilePattern()
    {
        return new Api\ProfilePattern($this->httpClient, $this->hydrator, $this->requestBuilder);
    }

    /**
     * @return Api\Statement
     */
    public function statement()
    {
        return new Api\Statement($this->httpClient, $this->hydrator, $this->requestBuilder);
    }

    /**
     * @return Api\UserManagement
     */
    public function userManagement()
    {
        return new Api\UserManagement($this->httpClient, $this->hydrator, $this->requestBuilder);
    }
}
