<?php

namespace HappyR\ApiClient\Entity;

use JMS\Serializer\Annotation as JMS;

/**
 * Class User
 *
 * This class represents an user
 */
class User
{
    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("user_id")
     */
    public $id;

}
