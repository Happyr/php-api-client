<?php

namespace Happyr\ApiClient\Exceptions;

class HttpException extends \Exception
{
	protected $httpStatus;
	protected $httpResponse;
	
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
	
	public function __toString()
	{
		return $this->getHttpStatus().': '.$this->getMessage();
	}
	
	public function getHttpStatus()
	{
		return $this->httpStatus;
	}
	
	public function getHttpResponse()
	{
		return $this->httpResponse;
	}
}
