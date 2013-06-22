<?php

namespace Happyr\ApiClient\Exceptions;

/**
 * Class HttpException
 *
 * A Exception...
 */
class HttpException extends \Exception
{
    protected $httpStatus;
    protected $httpResponse;

    /**
     * @param string $status
     * @param int $response
     */
    public function __construct($status, $response)
    {
        $this->httpStatus=$status;
        $this->httpResponse=$response;

        $message=$response;
        try{
            $xml = @simplexml_load_string($response);
            if(is_object($xml)){
                $message=$xml->exception['message'];
            }
        }
        catch(\Exception $e){
            $message=substr($response,0, 200);
        }

        parent::__construct($message, $status);
    }

    /**
     *
     *
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getHttpStatus().': '.$this->getMessage();
    }

    /**
     *
     *
     *
     * @return string
     */
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }

    /**
     *
     *
     *
     * @return int
     */
    public function getHttpResponse()
    {
        return $this->httpResponse;
    }
}
