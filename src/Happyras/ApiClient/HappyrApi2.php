<?php

namespace Happyr\ApiClient;

use Happyr\ApiClient\Http\Client;

/**
 * This is the API class that should be used with every api call
 * Every public function in this class represent a end point in the API
 */
class HappyrApi
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
     * @var string state
     *
     * To protect us from CSRF attacks
     *
     */
    protected $state;

    /**
     * A standard constructor that take some optional parameters.
     * If you don't inject a configuration class in the constructor it will use
     * the static values written in Configuration.php
     *
     * @param Configuration $config
     *
     */
    public function __construct(Configuration $config=null)
    {
        //if we don't get a configuration object in the parameter, then create one now.
        if ($config==null) {
            $config=new Configuration();
        }

        $this->configuration=$config;
    }

    /**
     * This function sends a request to the API directly without using the helper classes in Happyr\ApiClient\Api
     *
     * @param string $uri
     * @param array $data
     * @param string $httpVerb
     *
     * @return \Happyr\ApiClient\Http\Response\Response
     */
    public function api($uri, array $data=array(), $httpVerb='GET')
    {
        return $this->getHttpClient()->sendRequest($uri, $data, $httpVerb);
    }


    /**
     *
     * Get a Http client
     *
     * @param bool $forceNew if true we will create a new Client object
     *
     * @return Client
     */
    protected function getHttpClient($forceNew = false)
    {
        if (!$this->httpClient || $forceNew) {
            $this->httpClient=new Client($this->configuration);
        }

        return $this->httpClient;
    }

    /**
     *
     * @param \Happyr\ApiClient\Configuration $configuration
     *
     * @return $this
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     *
     * @return \Happyr\ApiClient\Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * Get the login url
     *
     * @param string $redirectUrl not urlencoded
     *
     * @return string
     */
    public function getLoginUrl($redirectUrl)
    {
        $this->establishCSRFTokenState();

        return sprintf(
            '%s/candidate/login/api_key=%s&state=%s&redirect_url=%s',
            $this->configuration->baseUrl,
            $this->configuration->identifier,
            $this->getState(),
            urlencode($redirectUrl)
        );
    }

    /**
     * Get Code
     *
     * @return null
     * @throws \Exception
     */
    protected function getCode()
    {
        if (isset($_REQUEST['code'])) {
            $state = $this->getState();
            //if state exists in session and in request and if they are equal
            if (null !== $state && isset($_REQUEST['state']) && $state === $_REQUEST['state']) {
                // CSRF state has done its job, so clear it
                $this->setState(null);

                return $_REQUEST['code'];
            } else {
                throw new \Exception('CSRF state token does not match one provided.');
            }
        }

        return null;
    }

    /**
     * Get the user token after login.
     *
     * @return string
     */
    public function getUserToken()
    {
        $code=$this->getCode();
        $token=$this->api('user/get-token', array('code'=>$code));

        return $token->getBody();
    }

    /**
     * Lays down a CSRF state token for this process.
     *
     */
    protected function establishCSRFTokenState()
    {
        if ($this->getState() === null) {
            $this->setState(md5(uniqid(mt_rand(), true)));
            $_SESSION['happyr_ac_state'] = $this->getState();
        }
    }

    /**
     *
     * @param string $state
     *
     * @return $this
     */
    protected function setState($state)
    {
        if ($state === null) {
            $_SESSION['happyr_ac_state']=null;
        }

        $this->state = $state;

        return $this;
    }

    /**
     *
     * @return string
     */
    protected function getState()
    {
        if ($this->state === null) {
            $this->state = isset($_SESSION['happyr_ac_state'])?$_SESSION['happyr_ac_state']:null;
        }

        return $this->state;
    }
}