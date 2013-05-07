<?php

namespace Happyr\ApiClient;

use Happyr\ApiClient\Http\Connection;
use Happyr\ApiClient\Exceptions\HttpException;
use Happyr\ApiClient\Exceptions\UserConflictException;


use Happyr\ApiClient\Entity\User;
use Happyr\ApiClient\Entity\Populus\Profile;
use Happyr\ApiClient\Entity\Populus\Question;
use Happyr\ApiClient\Entity\Populus\Answer;


use JMS\Serializer\SerializerBuilder;


/**
 * This is the API class that should be used with every api call
 * Every public function in this class represent a end point in the api
 */
class HappyrApi
{
	private $configuration;
	protected $connection;
	private $debug=false;
	
	public function __construct($username=null, $apiToken=null)
	{
		$this->configuration=new Configuration($username,$apiToken);
		$this->connection=new Connection($this->configuration);
	}
	
	
	/**
	 * Make a request
	 */
	protected function sendRequest($uri, array $data=array(), $httpVerb='GET', &$httpStatus=null, $suppressExceptions=true)
	{
		try{
			$response=$this->connection->sendRequest($uri,$data,$httpVerb,$httpStatus);
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
		return  $this->deserialize($response, 'Happyr\ApiClient\Entity\Populus\Question');
	}
	
	/**
	 * Post an answer for the question
	 */
	public function postPopulusAnswer(User $user, Question $question, Answer $answer)
	{
		$httpStatus=0;
		$response=$this->sendRequest(
					'populus/question/'.$question->id.'/answer',
					array('answer'=>$answer->id,'user_id'=>$user->id),
					'POST',
					$httpStatus
		);
		if($httpStatus==201){
			return true;
		}
		
		return false;
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
		$response=$this->sendRequest('populus/score', array('user_id'=>$user->id,'profile_id'=>$profile->id), 'GET',$httpStatus);
		
		$score= $this->deserialize($response, 'Happyr\ApiClient\Entity\Populus\Score');
		
		if($httpStatus==412){
			//We need to answer more questions
			return false;
		}
		return $score;
		
	}
	
	/**
	 * Create a new user. 
	 * 
	 * @return boolean false if error. If successful we will return a User.
	 * @throws UserConflictException if you need to verify the users email
	 */
	public function createUser($email)
	{
		$httpStatus=0;
		$response=$this->sendRequest(
					'users',
					array('email'=>$email),
					'POST',
					$httpStatus
		);
		//die($response);
		if($httpStatus==201){
			return $this->deserialize($response, 'Happyr\ApiClient\Entity\User');
		}
		elseif($httpStatus==409){
			throw new UserConflictException($email);
		}
		
		return false;
	}
	
	/**
	 * Send an email to the user to ask him to confirm his email. 
	 * The email contains a token that should be used with the 
	 * validateUser()-function
	 */
	public function sendUserConfirmation($email)
	{
		$httpStatus=0;
		$response=$this->sendRequest(
					'users/confirmation/send',
					array('email'=>$email),
					'POST',
					$httpStatus
		);
		if($httpStatus==200){
			return true;
		}
		
		
		return false;
	}
	
	/**
	 * Validate a user with the email and token. The token was email to the user
	 * from happyrecruiting.se when the sendUserConfirmation()-function was called
	 * 
	 * @return boolean false if error. If successful we will return a User.
	 */
	public function validateUser($email, $token)
	{
		$httpStatus=0;
		$response=$this->sendRequest(
					'users/confirmation/validate',
					array('email'=>$email, 'token'=>$token),
					'GET',
					$httpStatus
		);
		if($httpStatus==200){
			return $this->deserialize($response, 'Happyr\ApiClient\Entity\User');
		}
		
		return false;
	}
}
