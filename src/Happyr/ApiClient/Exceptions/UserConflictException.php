<?php

namespace Happyr\ApiClient\Exceptions;

/**
 * If you catch this exception you should try to send a confirmation email to the user.
 */
class UserConflictException extends \Exception
{
    protected $email;

    public function __construct($email)
    {
        $this->email=$email;

        parent::__construct('A user with that email is already registered.');
    }



    public function getEmail()
    {
        return $this->email;
    }

}
