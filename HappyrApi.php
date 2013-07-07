<?php

namespace Happyr\ApiClient;

use Happyr\ApiClient\Http\Connection;
use Happyr\ApiClient\Exceptions\HttpException;
use Happyr\ApiClient\Exceptions\UserConflictException;

use Happyr\ApiClient\Entity\User;
use Happyr\ApiClient\Entity\Populus\Profile;
use Happyr\ApiClient\Entity\Populus\Question;
use Happyr\ApiClient\Entity\Populus\Answer;
use Happyr\ApiClient\Serializer\SerializerInterface;


/**
 * This is the API class that should be used with every api call
 * Every public function in this class represent a end point in the API
 */
class HappyrApi
{
    /**
     * @var  configuration
     *
     * This is the configuration class
     */
    private $configuration;

    /**
     * @var  connection
     *
     * The connection is the class that is doing the actual http request
     */
    protected $connection;

    /**
     * @var  serializer
     *
     *
     */
    protected $serializer;


    /**
     * A standard constructor that take some optional parameters.
     * If you dont inject a configuration class in the constructor it will use
     * the static values written in Configuration.php
     *
     * @param Configuration $config
     * @param SerializerInterace $serializer
     * @param Connection $connection
     */
    public function __construct(
            Configuration $config=null,
            SerializerInterface $serializer=null,
            Connection $connection=null)
    {
        //if we dont get a configuration object in the parameter, then create one now.
        if($config==null){
            $config=new Configuration();
        }

        if($serializer==null){
            $serializerClass=$this->configuration->serializerClass;
            $serializer=new $serializerClass();
        }

        if($connection==null){
            $connection=new Connection($this->configuration);
        }

        $this->configuration=$config;
        $this->serializer=$serializer;
        $this->connection=$connection;
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
     * @return \Happyr\ApiClient\Http\Response
     * @throws HttpException
     */
    protected function sendRequest($uri, array $data=array(), $httpVerb='GET')
    {
        try{
            $response=$this->connection->sendRequest($uri,$data,$httpVerb);
        }
        catch(HttpException $e){
            if($this->configuration->debug){
                echo ("Exception: ".$e."\n");
            }

            if($this->configuration->enableExceptions){
                throw $e;//re-throw exception
            }

            //TODO fix error handeling

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
     *
     * @param string $data The raw response from the API-server
     * @param string $class The full class path to the object beeing deserialized
     *
     * @return an instance of $class
     */
    protected function deserialize($data, $class)
    {
        return $this->serializer->deserialize($data, $class, $this->configuration->format);
    }

    /**
     * Get the companies that are available
     *
     * @return array<Company>, an array with Company objects
     */
    public function getCompanies()
    {
        $response=$this->sendRequest('companies');

        return $this->deserialize($response->getBody(), 'array<Happyr\ApiClient\Entity\Company>');
    }

    /**
     * Get a company with the $id
     *
     * @param integer $id of the company
     *
     * @return Company
     */
    public function getCompany($id)
    {
        $response=$this->sendRequest('companies/'.$id);

        return $this->deserialize($response->getBody(), 'Happyr\ApiClient\Entity\Company');
    }

    /**
     * Get the current active opuses
     * An Opus is a job advert
     *
     * @return array<Opus>, an array with Opus objects
     */
    public function getOpuses()
    {
        $response=$this->sendRequest('opuses');

        return  $this->deserialize($response->getBody(), 'array<Happyr\ApiClient\Entity\Opus>');
    }

    /**
     * Get an Opus with the $id
     *
     * @param integer $id of the opus
     *
     * @return Opus
     */
    public function getOpus($id)
    {
        $response=$this->sendRequest('opuses/'.$id);

        return $this->deserialize($response->getBody(), 'Happyr\ApiClient\Entity\Opus');
    }

    /**
     * Get a list of available Populus Profiles
     * A populus profile is a pattern that we match the user potential with. A good match
     * gets a high Populus Score
     *
     * @return array<Profile>, an array with Profile objects
     */
    public function getPopulusProfiles()
    {
        $response=$this->sendRequest('populus/profiles');

        return  $this->deserialize($response->getBody(), 'array<Happyr\ApiClient\Entity\Populus\Profile>');
    }

    /**
     * Get an Profile with the $id
     *
     * @param integer $id of the Profile
     *
     * @return Profile
     */
    public function getPopulusProfile($id)
    {
        $response=$this->sendRequest('populus/profiles/'.$id);

        return $this->deserialize($response->getBody(), 'Happyr\ApiClient\Entity\Populus\Profile');
    }

    /**
     * Get the next question for the user on the specific profile
     *
     * @param User $user
     * @param Profile $profile
     *
     * @return Question, a Question object. If no more questions is available, return null.
     */
    public function getPopulusQuestion(User $user, Profile $profile)
    {
        $response=$this->sendRequest(
            'populus/question',
            array(
                'user_id'=>$user->id,
                'profile_id'=>$profile->id
            ),
            'GET'
        );

        if($response->getCode()==204){
            return null;
        }

        return  $this->deserialize($response->getBody(), 'Happyr\ApiClient\Entity\Populus\Question');
    }

    /**
     * Post an answer for the question
     *
     * @param User $user
     * @param Question $question
     * @param Answer $answer
     *
     * @return bool true if the answer was successfully posted. Otherwise false
     */
    public function postPopulusAnswer(User $user, Question $question, Answer $answer)
    {
        $response=$this->sendRequest(
            'populus/question/'.$question->id.'/answer',
            array(
                'answer'=>$answer->id,
                'user_id'=>$user->id
            ),
            'POST'
        );
        if($response->getCode()==201){
            return true;
        }

        return false;
    }

    /**
     * Get the score for the user on the specific profile
     *
     * @param User $user
     * @param Profile $profile
     *
     * @return integer between 0 and 100 (inclusive). False is returned if not all the questions are answered.
     */
    public function getPopulusScore(User $user, Profile $profile)
    {
        $response=$this->sendRequest(
            'populus/score',
            array(
                'user_id'=>$user->id,
                'profile_id'=>$profile->id
            ),
            'GET'
        );

        if($response->getCode()==412){
            //We need to answer more questions
            return false;
        }

        return $this->deserialize($response->getBody(), 'Happyr\ApiClient\Entity\Populus\Score');
    }

    /**
     * Create a new user. If the email is not previously registered on the API-server we will just
     * return a User object. If, however, the email is previously registered then you (the API client)
     * have to ask the user to confirm his email.
     *
     * The first step is to ask the API-server to send an email to the user. Then you have to tell the user
     * to fetch new emails and find the email from HappyRecruiting. In that email there is a token that
     * he should enter to the API client. Simple as pie.
     *
     * Use the following two functions to confrim a user's email:
     *  - sendUserConfirmation($email)
     *  - validateUser($email, $token)
     *
     *
     * @param string $email of the user you want to create.
     *
     * @return User if successful. Boolean false if error.
     * @throws UserConflictException if you need to confirm the users email
     */
    public function createUser($email)
    {
        $response=$this->sendRequest(
            'users',
            array(
                'email'=>$email
            ),
            'POST'
        );

        if($response->getCode()==201){//if success
            return $this->deserialize($response->getBody(), 'Happyr\ApiClient\Entity\User');
        }
        elseif($response->getCode()==409){//if that email was previously registered
            throw new UserConflictException($email);
        }

        return false;
    }

    /**
     * Send an email to the user to ask him to confirm his email.
     * The email contains a token that should be used with the
     * validateUser()-function
     *
     * @param string $email
     *
     * @return boolean true if successful. Otherwise false.
     */
    public function sendUserConfirmation($email)
    {
        $response=$this->sendRequest(
            'users/confirmation/send',
            array(
                'email'=>$email
            ),
            'POST'
        );

        if($response->getCode()==200){
            return true;
        }

        return false;
    }

    /**
     * Validate a user with the email and token. The token was email to the user
     * from happyrecruiting.se when the sendUserConfirmation()-function was called
     *
     * @param string $email
     * @param string $token that was sent to the user by email
     *
     * @return User if successful. Boolean false if error.
     */
    public function validateUser($email, $token)
    {
        $response=$this->sendRequest(
            'users/confirmation/validate',
            array(
                'email'=>$email,
                'token'=>$token
            ),
            'GET'
        );

        if($response->getCode()==200){
            return $this->deserialize($response->getBody(), 'Happyr\ApiClient\Entity\User');
        }

        return false;
    }
}
