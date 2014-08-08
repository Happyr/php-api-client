<?php

namespace Happyr\ApiClient\Exceptions;

use Happyr\ApiClient\Http\Response\Response;

/**
 * Class HttpException
 *
 * A Exception...
 */
class HttpException extends \Exception
{
    /**
     * @var \Happyr\ApiClient\Http\Response\Response response
     *
     */
    protected $response;

    /**
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response=$response;
        $message = $response->getBody();
        try {
            $xml = @simplexml_load_string($response);
            if (is_object($xml)) {
                $message = $xml->exception['message'];
            }
        } catch (\Exception $e) {
            $message = substr($response, 0, 200);
        }

        parent::__construct($message, $response->getCode());
    }

    /**
     *
     *
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getHttpStatus() . ': ' . $this->getMessage();
    }

    /**
     * Get the HTTP status code
     *
     * @return int
     */
    public function getHttpStatus()
    {
        return $this->response->getCode();
    }

    /**
     * Get the HTTP response body
     *
     * @return string
     */
    public function getHttpResponse()
    {
        return $this->response->getBody();
    }

    /**
     *
     * @return \Happyr\ApiClient\Http\Response\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Get an empty response
     *
     *
     * @return Response
     */
    public function getEmptyResponse()
    {
        $response = clone $this->response;
        if ($response->getFormat()=='json') {
            $response->setBody('[]');
        } else {
            $response->setBody('<?xml version="1.0" encoding="UTF-8"?><result/>');
        }

        return $response;
    }
}