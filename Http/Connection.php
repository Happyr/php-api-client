<?php

namespace Happyr\ApiClient\Http;

use Happyr\ApiClient\Configuration;
use Happyr\ApiClient\Exceptions\HttpException;


class Connection
{
	protected $configuration;
	
	
	/**
	 * Init the connection with our current configuration
	 */
	public function __construct(Configuration $configuration)
	{
		$this->configuration=$configuration;
	}
	
	/**
	 * Make a POST call to the URI with $data
	 */
	public function post($uri, array $data=array(), &$httpStatus=null)
	{
		//urlify the data for the POST
		foreach($data as $key=>$value) {
			 $dataString .= $key.'='.$value.'&'; 
		}
		//remove the last '&'
		rtrim($dataString, '&');
		
		
		$ch=curl_init();	
		
		curl_setopt($ch,CURLOPT_POST, count($data));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $dataString);
		
		return $this->request($ch, $uri, $httpStatus);
	}
	
	/**
	 * Make a GET call to the URI
	 */
	public function get($uri, &$httpStatus=null)
	{
		$ch=curl_init();	
		
		return $this->request($ch, $uri, $httpStatus);
	}
	
	/**
	 * Send a request. This will return the response. 
	 * 
	 * @thorw HttpException if we got a response code bigger or equal to 300
	 * 
	 */
	protected function request(&$ch, $uri, &$httpStatus=null){
		//set url
		curl_setopt($ch,CURLOPT_URL, $this->buildUrl($uri));
		
		 // Set a referer and user agent
		if(isset($_SERVER['HTTP_HOST'])){
 			curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
		}
		curl_setopt($ch, CURLOPT_USERAGENT, 'HappyrApiClient/'.$this->configuration->version);

		curl_setopt($ch, CURLOPT_HEADER, 0); //do not include the http header in the result
   		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //return the data
   		curl_setopt($ch, CURLOPT_TIMEOUT, 10);// Timeout in seconds
   		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //follow redirects
   		
   		//get headers
   		$headers=array_merge(
			$this->getAcceptHeader(),
			$this->getAuthenticationHeader()	
		);
		
		//add headers
   		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			
		//execute post
		$response = curl_exec($ch);
		
		//get the http status code
		$httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		//if we got some non good http response code
		if($httpStatus>=300){
			//throw exceptions
			throw new HttpException($httpStatus, $response);
		}
		
		//close connection
		curl_close($ch);
		
		return $response;
	}
	
	/**
	 * Get the accept header. 
	 * We specify the api version here. 
	 * 
	 * We choose to use xml over json because of the better backwards compatibility
	 */
	protected function getAcceptHeader()
	{
		return array('Accept: application/vnd.happyrecruiting-v'.$this->configuration->version.'+'.$this->configuration->format);
	}
	
	/**
	 * Get the wsse authentication header
	 */
	protected function getAuthenticationHeader()
	{
		$wsse=new Wsse($this->configuration->username, $this->configuration->token);
		return $wsse->getHeaders();
	}
	
	/**
	 * Build the url with baseUrl and uri
	 */
	protected function buildUrl($uri){
		return $this->configuration->baseUrl.$uri;
	}
}
