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
     * Create a new user. If the email is not previously registered on the API-server we will just
     * return a User object. If, however, the email is previously registered then you (the API client)
     * have to ask the user to confirm his email.
     *
     * The first step is to ask the API-server to send an email to the user. Then you have to tell the user
     * to fetch new emails and find the email from HappyRecruiting. In that email there is a token that
     * he should enter to the API client. Simple as pie.
     *
     * Use the following two functions to confirm a user's email:
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
        $response=$this->httpClient->sendRequest(
            'users',
            array(
                'email'=>$email
            ),
            'POST'
        );

        if($response->getCode()==201){//if success
            return $this->deserialize($response, 'HappyR\ApiClient\Entity\User');
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
        $response=$this->httpClient->sendRequest(
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
        $response=$this->httpClient->sendRequest(
            'users/confirmation/validate',
            array(
                'email'=>$email,
                'token'=>$token
            )
        );

        if($response->getCode()==200){
            return $this->deserialize($response, 'HappyR\ApiClient\Entity\User\User');
        }

        return false;
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
        ));

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
        $this->httpClient->sendRequest('user/group/'.$this->getId($group).'/add-pattern', array(
            'pattern'=>$this->getId($pattern),
        ));
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
        $this->httpClient->sendRequest('user/group/'.$this->getId($group).'/add-pattern', array(
            'user'=>$this->getId($user),
        ));
    }
}