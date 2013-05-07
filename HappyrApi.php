<?php

namespace Happyr\ApiClient;

use Happyr\ApiClient\Http\Connection;
use Happyr\ApiClient\Exceptions\HttpException;

use Happyr\ApiClient\Entity\User;
use Happyr\ApiClient\Entity\Populus\Profile;

use JMS\Serializer\SerializerBuilder;


/**
 * This is the API class that should be used with every api call
 * Every public function in this class represent a end point in the api
 */
class HappyrApi
{
	private $configuration;
	protected $connection;
	private $debug=true;
	
	public function __construct($username=null, $apiToken=null)
	{
		$this->configuration=new Configuration($username,$apiToken);
		$this->connection=new Connection($this->configuration);
	}
	
	
	/**
	 * Make a request
	 */
	protected function sendRequest($uri, array $filters=array(), array $data=array(), &$httpStatus=null, $suppressExceptions=true)
	{
		try{
			$response=$this->connection->sendRequest($uri,$filters,$data,$httpStatus);
		}
		catch(HttpException $e){
			if($this->debug){
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
		$response=$this->sendRequest('companies');
		return  $this->deserialize($response, 'array<Happyr\ApiClient\Entity\Company>');
	}
	
	/**
	 * Returns a company
	 * 
	 * @param integer id. 
	 */
	public function getCompany($id)
	{
		$response=$this->sendRequest('companies/'.$id);
		return $this->deserialize($response, 'Happyr\ApiClient\Entity\Company');
	}
	
	
	/**
	 * Returns an array with Opus objects
	 * A Opus is a job advert
	 */
	public function getOpuses()
	{
		$response=$this->sendRequest('opuses');
		return  $this->deserialize($response, 'array<Happyr\ApiClient\Entity\Opus>');
	}
	
	/**
	 * Returns an opus
	 * 
	 * @param integer id. 
	 */
	public function getOpus($id)
	{
		$response=$this->sendRequest('opuses/'.$id);
		return $this->deserialize($response, 'Happyr\ApiClient\Entity\Opus');
	}
	
	/**
	 * Returns an array with populus profile objects
	 * A populus profile is a pattern that we match the user potential with. A good match
	 * gets a high populus score
	 */
	public function getPopulusProfiles()
	{
		$response=$this->sendRequest('populus/profiles');
		return  $this->deserialize($response, 'array<Happyr\ApiClient\Entity\Populus\Profile>');
	}
	
	/**
	 * Returns an opus
	 * 
	 * @param integer id. 
	 */
	public function getPopulusProfile($id)
	{
		$response=$this->sendRequest('opuses/'.$id);
		return $this->deserialize($response, 'Happyr\ApiClient\Entity\Populus\Profile');
	}
	
	/**
	 * Get the next question for the user on the specific profile
	 */
	public function getPopulusQuestion(User $user, Profile $profile)
	{
		$response=$this->sendRequest('populus/question',array('user_id'=>$user->id,'profile_id'=>$profile->id));
		//die($response);
		return  $this->deserialize($response, 'Happyr\ApiClient\Entity\Populus\Question');
	}
	
	/**
	 * Get the score for the user on the specific profile
	 * 
	 * @return integer between 0 and 100 (inclusive). False is returned if not all the questions are answered.
	 * 
	 */
	public function getPopulusScore(User $user, Profile $profile)
	{
		$httpStatus=0;
		$response=$this->sendRequest('populus/score', array('user_id'=>$user->id,'profile_id'=>$profile->id), array(),$httpStatus);
		
		$score= $this->deserialize($response, 'Happyr\ApiClient\Entity\Populus\Score');
		
		if($httpStatus==412){
			//We need to answer more questions
			return false;
		}
		return $score;
		
	}
	
}
