<?php

namespace HappyR\ApiClient\Entity\User;

use JMS\Serializer\Annotation as JMS;

/**
 * Class User
 *
 * @author Tobias Nyholm
 *
 *
 */
class User
{
    /**
     * @JMS\Type("integer")
     */
    public $id;
}
