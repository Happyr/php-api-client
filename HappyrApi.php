<?php

namespace Happyr\ApiClient;

use Happyr\ApiClient\Http\Connection;
use Happyr\ApiClient\Exceptions\HttpException;
use JMS\Serializer\SerializerBuilder;


/**
 * This is the API class that should be used with every api call
 * Every public function in this class represent a end point in the api
 */
class HappyrApi
{
	private $configuration;
	protected $connection;
	private final $debug=true;
	
	public function __construct($username=null, $apiToken=null)
	{
		$this->configuration=new Configuration($username,$apiToken);
		$this->connection=new Connection($this->configuration);
	}
	
	
	/**
	 * Make a GET request
	 */
	protected function get($uri, &$httpStatus=null, $suppressExceptions=true)
	{
		try{
			$response=$this->connection->get($uri,$httpStatus);
		}
		catch(HttpException $e){
			if($debug){
				echo ("Exception: ".$e."\n");
			}     
			
			if(!$suppressExceptions){
				throw $e;//rethrow exception
			}		
			
			//return empty result
			if($this->configuration->format=='xml'){
				return '<?xml version="1.0" encoding="UTF-8"?><result/>';
			}
			elseif($this->configuration->format=='json'){
				return '[]';
			}
			
		}
		
		return $response;
	}
	
	/**
	 * Deserialize an object
	 */
	protected function deserialize($data, $class)
	{
		return SerializerBuilder::create()->build()->deserialize($data, $class, $this->configuration->format);
	}
	
	/**
	 * Returns an array with Company objects
	 */
	public function getCompanies()
	{
		$response=$this->get('companies');
		return  $this->deserialize($response, 'array<Happyr\ApiClient\Entity\Company>');
	}
	
	/**
	 * Retirns a company
	 * 
	 * @param integer id. 
	 */
	public function getCompany($id)
	{
		$response=$this->get('companies/'.$id);
		return $this->deserialize($response, 'Happyr\ApiClient\Entity\Company');
	}
	
}
