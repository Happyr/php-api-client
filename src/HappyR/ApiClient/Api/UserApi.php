<?php


namespace HappyR\ApiClient\Api;

use HappyR\ApiClient\Entity\Potential\Pattern;

/**
 * Class UserManagement
 *
 * @author Tobias Nyholm
 *
 */
class UserApi extends BaseApi
{
    /**
     * Create an user. If the email is not previously registered we will just
     * return a new User object. If, however, the email is previously registered then you (the API client)
     * have to ask the user to confirm his email.
     *
     * The first step is to ask the API-server to send an email to the user. Then you have to tell the user
     * to fetch new emails and find the email from HappyR. In that email there is a token that
     * he should enter to the API client. Simple as pie.
     *
     * Use the following two functions to confirm a user's email:
     *  - sendUserConfirmation($email)
     *  - validateUser($email, $token)
     *
     * @param string $email
     * @param bool $ignoreDuplicate if true you will not get a UserConflictException
     * @param string $name full name of the user
     * @param string $location like 'Street 22, city, state, country'
     *
     * @return null|User
     * @throws UserConflictException
     */
    public function createUser($email, $ignoreDuplicate=false, $name=null, $location=null)
    {
        $response=$this->httpClient->sendRequest('user',
            array(
                'email'=>$email,
                'name'=>$name,
                'location'=>$location,
                'ignore-duplicate'=>$ignoreDuplicate?1:0,
            ), 'POST');

        if ($response->getCode()==201) {
            //if success
            return $this->deserialize($response, 'HappyR\ApiClient\Entity\User');
        } elseif ($response->getCode()==409) {
            //if that email was previously registered
            throw new UserConflictException($email);
        }

        return null;
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
        $response=$this->httpClient->sendRequest(
            'user/confirmation/send',
            array(
                'email'=>$email
            ),
            'POST'
        );

        if ($response->getCode()==204) {
            return true;
        }

        return false;
    }

    /**
     * Validate a user with the email and token. The token was email to the user
     * from happyr.com when the sendUserConfirmation()-function was called
     *
     * @param string $email
     * @param string $token that was sent to the user by email
     *
     * @return null|User if successful. Null is returned on error.
     */
    public function validateUser($email, $token)
    {
        $response=$this->httpClient->sendRequest(
            'user/confirmation/validate',
            array(
                'email'=>$email,
                'token'=>$token
            )
        );

        if ($response->getCode()==200) {
            return $this->deserialize($response, 'HappyR\ApiClient\Entity\User\User');
        }

        return null;
    }

    /**
     * Create a new group
     *
     * @var Pattern|integer $pattern to be used in this group. (id or object)
     *
     * @return \HappyR\ApiClient\Entity\User\Group
     */
    public function createGroup($pattern)
    {
        $response=$this->httpClient->sendRequest('user/group/new', array(
            'pattern'=>$this->getId($pattern),
        ), 'POST');

        return $this->deserialize($response, 'HappyR\ApiClient\Entity\User\Group');
    }

    /**
     * Add a pattern to the group
     *
     * @param Group|integer $group
     * @param Pattern|integer $pattern
     *
     */
    public function addPatternToGroup($group, $pattern)
    {
        $this->httpClient->sendRequest(sprintf('user/group/%d/add-pattern', $this->getId($group)), array(
            'pattern'=>$this->getId($pattern),
        ), 'POST');
    }

    /**
     * Add an user to the group
     *
     * @param Group|integer $group
     * @param User|integer $user
     *
     */
    public function addUserToGroup($group, $user)
    {
        $this->httpClient->sendRequest(sprintf('user/group/%d/add-pattern', $this->getId($group)), array(
            'user'=>$this->getId($user),
        ), 'POST');
    }
}