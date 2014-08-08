<?php

namespace HappyR\ApiClient\Http;

use HappyR\ApiClient\Configuration;
use HappyR\ApiClient\Exceptions\HttpException;
use HappyR\ApiClient\Http\Request\RequestInterface;
use HappyR\ApiClient\Http\Response\Response;

/**
 * Class Connection
 *
 * This class handles the connection to the API-Server
 */
class Client
{
    /**
     * @var \HappyR\ApiClient\Configuration configuration
     *
     */
    protected $configuration;

    /**
     * @var \HappyR\ApiClient\Http\Request\RequestInterface request
     *
     */
    protected $request;

    /**
     * Init the connection with our current configuration
     *
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $class=$configuration->httpRequestClass;
        $this->request = new $class();
    }

    /**
     * Make a request
     *
     * @param string $uri The uri to en endpoint.
     * @param array $data (optional) if it is a GET-request then data act as a filter. If it is a POST-request it will
     * be the post variables
     * @param string $httpVerb (optional) either GET or POST.
     * will contain the http response code
     * @param boolean $suppressExceptions, (optional) if true, we will catch all HttpExceptions that might be thrown by
     * the Connection class
     *
     * @return \HappyR\ApiClient\Http\Response
     * @throws HttpException
     */
    public function sendRequest($uri, array $data=array(), $httpVerb='GET')
    {
        //get headers
        $headers = array_merge($this->getAcceptHeader(), $this->getAuthenticationHeader());
        $headers['User-Agent'] = 'HappyRApiClient/'.$this->configuration->clientVersion;

        $response=$this->request->send($this->configuration->baseUrl.'/api/'.$uri, $data, $httpVerb, $headers);
        $response->setFormat($this->configuration->format);

        //if we got some non good http response code
        if ($response->getCode() >= 500 || $response->getCode() == 0) {
            $response = $this->handleError($response);
        }

        return $response;
    }

    /**
     * Handle stuff when an error occur
     *
     * @param string $body
     * @param int $httpStatus
     *
     * @return Response
     * @throws \HappyR\ApiClient\Exceptions\HttpException
     */
    protected function handleError(Response $response)
    {
        if ($this->configuration->debug) {
            echo ('Exception: '.$response->getBody()."\n");
        }

        $exception=new HttpException($response);

        if ($this->configuration->enableExceptions) {
            //throw exceptions
            throw $exception;
        }

        return $exception->getEmptyResponse();
    }

    /**
     * Get the accept header.
     * We specify the api version here.
     *
     * We choose to use xml over json because of the better backwards compatibility
     *
     * @return array
     */
    protected function getAcceptHeader()
    {
        return array(
            'Accept'=>'application/'.$this->configuration->format,
        );
    }

    /**
     * Get the WSSE authentication header
     *
     *
     * @return array
     */
    protected function getAuthenticationHeader()
    {
        $wsse = new Wsse($this->configuration->identifier, $this->configuration->secret);

        return $wsse->getHeaders();
    }
}