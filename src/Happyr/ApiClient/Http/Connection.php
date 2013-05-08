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
	 * Send a request. This will return the response. 
	 * 
	 * @thorw HttpException if we got a response code bigger or equal to 300
	 * 
	 */
	public function sendRequest($uri, array $data=array(), $httpVerb='GET', &$httpStatus=null){
		$ch=curl_init();
		
		if($httpVerb=='POST'){
			$this->preparePostData($ch, $data);
			curl_setopt($ch,CURLOPT_URL, $this->buildUrl($uri));
		}
		elseif($httpVerb=='GET'){
			curl_setopt($ch,CURLOPT_URL, $this->buildUrl($uri, $data));
		}
		else{
			throw new \InvalidArgumentException('httpVerb must be eihter "GET" or "POST"');
		}
		
		
		
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
	protected function buildUrl($uri, array $filters= array()){
		$filterString='';
		
		//add the filter on the filter string
		if(count($filters)>0){
			$filterString='?';
			foreach($filters as $key=>$value){
				$filterString.=$key.'='.$value.'&';
			}
			rtrim($filterString,'&');
		}
		
		return $this->configuration->baseUrl.$uri.$filterString;
	}
	
	/**
	 * Load the curl object with the post data
	 */
	protected function preparePostData(&$ch, array $data=array())
	{
		$dataString='';
		
		//urlify the data for the POST
		foreach($data as $key=>$value) {
			 $dataString .= $key.'='.$value.'&'; 
		}
		//remove the last '&'
		rtrim($dataString, '&');
				
		curl_setopt($ch,CURLOPT_POST, count($data));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $dataString);
	}
}
