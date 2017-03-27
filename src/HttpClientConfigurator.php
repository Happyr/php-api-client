<?php

namespace Happyr\ApiClient;

use Http\Client\HttpClient;
use Http\Client\Common\PluginClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\Authentication;
use Http\Message\UriFactory;
use Http\Client\Common\Plugin;

/**
 * Configure an HTTP client.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 *
 * @internal This class should not be used outside of the API Client, it is not part of the BC promise
 */
final class HttpClientConfigurator
{
    /**
     * @var string
     */
    private $endpoint = 'https://api.happyr.com';

    /**
     * @var string
     */
    private $apiUsername;

    /**
     * @var string
     */
    private $apiPassword;

    /**
     * @var UriFactory
     */
    private $uriFactory;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var Plugin[]
     */
    private $prependPlugins = [];

    /**
     * @var Plugin[]
     */
    private $appendPlugins = [];

    /**
     * @param HttpClient|null $httpClient
     * @param UriFactory|null $uriFactory
     */
    public function __construct(HttpClient $httpClient = null, UriFactory $uriFactory = null)
    {
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->uriFactory = $uriFactory ?: UriFactoryDiscovery::find();
    }

    /**
     * @return HttpClient
     */
    public function createConfiguredClient()
    {
        $plugins = $this->prependPlugins;

        $plugins[] = new Plugin\AddHostPlugin($this->uriFactory->createUri($this->endpoint));
        $plugins[] = new Plugin\HeaderDefaultsPlugin([
            'User-Agent' => 'Happyr/api-client (https://github.com/Happyr/php-api-client)',
        ]);

        if (null !== $this->apiUsername) {
            $plugins[] = new Plugin\AuthenticationPlugin(new Authentication\Wsse($this->apiUsername, $this->apiPassword));
        }

        return new PluginClient($this->httpClient, array_merge($plugins, $this->appendPlugins));
    }

    /**
     * @param string $endpoint
     *
     * @return HttpClientConfigurator
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * @param string $username
     * @param string $password
     *
     * @return HttpClientConfigurator
     */
    public function setApiCredentials($username, $password)
    {
        $this->apiUsername = $username;
        $this->apiPassword = $password;

        return $this;
    }

    /**
     * @param Plugin $plugin
     *
     * @return HttpClientConfigurator
     */
    public function appendPlugin(Plugin ...$plugin)
    {
        foreach ($plugin as $p) {
            $this->appendPlugins[] = $p;
        }

        return $this;
    }

    /**
     * @param Plugin $plugin
     *
     * @return HttpClientConfigurator
     */
    public function prependPlugin(Plugin ...$plugin)
    {
        $plugin = array_reverse($plugin);
        foreach ($plugin as $p) {
            array_unshift($this->prependPlugins, $p);
        }

        return $this;
    }
}
