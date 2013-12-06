<?php

namespace HappyR\ApiClient\Http;

use HappyR\ApiClient\Configuration;
use HappyR\ApiClient\Exceptions\HttpException;
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
     * Init the connection with our current configuration
     *
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
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
        $request=$this->buildRequest($uri, $data, $httpVerb);

        //execute request
        $body = $request->execute();

        //get the http status code
        $httpStatus = $request->getInfo(CURLINFO_HTTP_CODE);

        //close connection
        $request->close();

        /*
         * Start to create a response
         */

        //if we got some non good http response code
        if ($httpStatus >= 300 || $httpStatus == 0) {
            $response = $this->handleError($body, $httpStatus);
        } else {
            $response = new Response($body, $httpStatus);
        }

        $response->setFormat($this->configuration->format);

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
    protected function handleError(&$body, $httpStatus)
    {
        if ($this->configuration->debug) {
            echo ('Exception: '.$body."\n");
        }

        if ($this->configuration->enableExceptions) {
            //throw exceptions
            throw new HttpException($httpStatus, $body);
        }

        //return empty result
        $response=new Response('<?xml version="1.0" encoding="UTF-8"?><result/>', $httpStatus);

        if ($this->configuration->format=='json') {
            $response->setBody('[]');
        }

        return $response;
    }

    /**
     * Send a request. This will return the response.
     *
     * @param string $uri
     * @param array $data
     * @param string $httpVerb
     *
     * @return Response
     * @throws \HappyR\ApiClient\Exceptions\HttpException if we got a response code bigger or equal to 300
     * @throws \InvalidArgumentException
     */
    protected function buildRequest($uri, array $data = array(), $httpVerb = 'GET')
    {
        $httpRequestClass = $this->configuration->httpRequestClass;
        $request = new $httpRequestClass();

        switch ($httpVerb) {
            case 'POST':
                $this->preparePostData($request, $data);
                $request->setOption(CURLOPT_URL, $this->buildUrl($uri));
                break;
            case 'GET':
                $request->setOption(CURLOPT_URL, $this->buildUrl($uri, $data));
                break;
            default:
                throw new \InvalidArgumentException('HTTP method must be either "GET" or "POST"');
        }

        // Set a referrer and user agent
        if (isset($_SERVER['HTTP_HOST'])) {
            $request->setOption(CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
        }
        $request->setOption(CURLOPT_USERAGENT, 'HappyRApiClient/' . $this->configuration->clientVersion);

        //do not include the http header in the result
        $request->setOption(CURLOPT_HEADER, 0);

        //return the data
        $request->setOption(CURLOPT_RETURNTRANSFER, true);

        // Timeout in seconds
        $request->setOption(CURLOPT_TIMEOUT, 10);

        //follow redirects
        $request->setOption(CURLOPT_FOLLOWLOCATION, true);

        //get headers
        $headers = array_merge(
            $this->getAcceptHeader(),
            $this->getAuthenticationHeader()
        );

        //add headers
        $request->setOption(CURLOPT_HTTPHEADER, $headers);

        return $request;
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
            'Accept: application/'.$this->configuration->format,
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
        $wsse = new Wsse($this->configuration->username, $this->configuration->token);

        return $wsse->getHeaders();
    }

    /**
     * Build the url with baseUrl and uri
     *
     * @param string $uri
     * @param array $filters
     *
     * @return string
     */
    protected function buildUrl($uri, array $filters = array())
    {
        $filterString = '';

        //add the filter on the filter string
        if (count($filters) > 0) {
            $filterString = '?';
            foreach ($filters as $key => $value) {
                $filterString .= $key . '=' . $value . '&';
            }
            rtrim($filterString, '&');
        }

        return $this->configuration->baseUrl . $uri . $filterString;
    }

    /**
     * Load the curl object with the post data
     *
     * @param array $data
     *
     */
    protected function preparePostData(RequestInterface &$request, array $data = array())
    {
        $dataString = '';

        //urlify the data for the POST
        foreach ($data as $key => $value) {
            $dataString .= $key . '=' . $value . '&';
        }
        //remove the last '&'
        rtrim($dataString, '&');

        $request->setOption(CURLOPT_POST, count($data));
        $request->setOption(CURLOPT_POSTFIELDS, $dataString);
    }
}
