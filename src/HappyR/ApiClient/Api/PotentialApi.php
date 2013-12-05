<?php


namespace HappyR\ApiClient\Api;


/**
 * Class PotentialApi
 *
 * @author Tobias Nyholm
 *
 */
class PotentialApi extends BaseApi
{

    /**
     * Get a list of available Potential Profiles
     * A potential profile is a pattern that we match the user potential with. A good match
     * gets a high Potential Score
     *
     * @return array<Profile>, an array with Profile objects
     */
    public function getPotentialProfiles()
    {
        $response=$this->httpClient->sendRequest('potential/profile-patterns');

        return  $this->deserialize($response, 'array<HappyR\ApiClient\Entity\Potential\Profile>');
    }

    /**
     * Get an Profile with the $id
     *
     * @param integer $id of the Profile
     *
     * @return Profile
     */
    public function getPotentialProfile($id)
    {
        $response=$this->httpClient->sendRequest('potential/profile-patterns/'.$id);

        return $this->deserialize($response->getBody(), 'HappyR\ApiClient\Entity\Potential\Profile');
    }

    /**
     * Get the next statement for the user on the specific profile
     *
     * @param User $user
     * @param Profile $profile
     *
     * @return Statement, a Statement object. If no more statements is available, return null.
     */
    public function getPotentialStatement(User $user, Profile $profile)
    {
        $response=$this->httpClient->sendRequest(
            'potential/statement',
            array(
                'user_id'=>$user->id,
                'pattern_id'=>$profile->id
            ),
            'GET'
        );

        if($response->getCode()==204){
            return null;
        }

        return  $this->deserialize($response, 'HappyR\ApiClient\Entity\Potential\Statement');
    }

    /**
     * Post an answer for the statement
     *
     * @param User $user
     * @param Statement $statement
     * @param Answer $answer
     *
     * @return bool true if the answer was successfully posted. Otherwise false
     */
    public function postPotentialAnswer(User $user, Statement $statement, Answer $answer)
    {
        $response=$this->httpClient->sendRequest(
            'potential/statement/'.$statement->id.'/answer',
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
     * @return integer between 0 and 100 (inclusive). False is returned if not all the statements are answered.
     */
    public function getPotentialScore(User $user, Profile $profile)
    {
        $response=$this->httpClient->sendRequest(
            'potential/score',
            array(
                'user_id'=>$user->id,
                'pattern_id'=>$profile->id
            ),
            'GET'
        );

        if($response->getCode()==412){
            //We need to answer more statements
            return false;
        }

        return $this->deserialize($response, 'HappyR\ApiClient\Entity\Potential\Score');
    }

} 