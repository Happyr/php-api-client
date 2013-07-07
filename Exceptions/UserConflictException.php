<?php

namespace HappyR\ApiClient\Exceptions;

/**
 * If you catch this exception you should try to send a confirmation email to the user.
 */
class UserConflictException extends \Exception
{
    protected $email;

    /**
     * @param string $email
     */
    public function __construct($email)
    {
        $this->email=$email;

        parent::__construct('A user with that email is already registered.');
    }


    /**
     *
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

}
