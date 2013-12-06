<?php


namespace HappyR\ApiClient\Api;

use HappyR\ApiClient\Entity\Potential\Statement;

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
    public function getPatterns()
    {
        $response=$this->httpClient->sendRequest('patterns');

        return  $this->deserialize($response, 'array<HappyR\ApiClient\Entity\Potential\Pattern>');
    }

    /**
     * Get an Profile with the $id
     *
     * @param integer $id of the Profile
     *
     * @return Pattern
     */
    public function getPattern($id)
    {
        $response=$this->httpClient->sendRequest(sprintf('patterns/%d', $id));

        return $this->deserialize($response, 'HappyR\ApiClient\Entity\Potential\Pattern');
    }

    /**
     * Get the next statement for the user on the specific profile
     *
     * @param User|integer $user
     * @param Pattern|integer $pattern
     *
     * @return Statement|null If no more statements is available, return null.
     */
    public function getStatement($user, $pattern)
    {
        $response=$this->httpClient->sendRequest(
            sprintf('pattern/%d/next-statement', $this->getId($pattern)),
            array(
                'user'=>$this->getId($user),
            )
        );

        if($response->getCode()==204){
            return null;
        }

        return $this->deserialize($response, 'HappyR\ApiClient\Entity\Potential\Statement');
    }

    /**
     * Create an assessment, ie answer the question
     *
     * @param Statement|integer $statement
     * @param User|integer $user
     * @param Pattern|integer $pattern
     * @param integer $answer [1-5]. This is the value of an Assessment
     *
     * @return Statement|null
     */
    public function createAssessment($statement, $user, $pattern, $answer)
    {
        $response=$this->httpClient->sendRequest(
            sprintf('statement/%d',$this->getId($statement)),
            array(
                'answer'=>$answer,
                'user'=>$this->getId($user),
                'pattern'=>$this->getId($pattern),
            ),
            'POST'
        );

        if($response->getCode()==204){
            return null;
        }

        return $this->deserialize($response, 'HappyR\ApiClient\Entity\Potential\Statement');
    }

    /**
     * Get the Match for an user on a pattern
     *
     * @param User|integer $user
     * @param Pattern|integer $pattern
     *
     * @return \HappyR\ApiClient\Entity\Potential\Match|null Returns null if the user has to answer more questions
     */
    public function getMatch($user, $pattern)
    {
        $response=$this->httpClient->sendRequest('match', array(
            'user'=>$this->getId($user),
            'pattern'=>$this->getId($pattern),
        ));

        if($response->getCode()==412){
            //We need to answer more statements
            return null;
        }

        return $this->deserialize($response, 'HappyR\ApiClient\Entity\Potential\Match');
    }

    /**
     * Get the top users for a pattern
     *
     * @param Group|integer $group
     * @param Pattern|integer $pattern
     * @param integer $limit
     *
     *
     * @return array
     */
    public function getTopMatches($group, $pattern, $limit=1)
    {
        $response=$this->httpClient->sendRequest('match/top', array(
                'group'=>$this->getId($group),
                'pattern'=>$this->getId($pattern),
                'limit'=>$limit
            ));


        return $this->deserialize($response, 'array<HappyR\ApiClient\Entity\User\User>');
    }

} 