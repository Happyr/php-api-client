<?php

namespace Happyr\ApiClient\Entity\Populus;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Profile
 *
 * This class represents a matching profile
 */
class Profile
{
    /**
     * @JMS\Type("integer")
     */
    public $id;

    /**
     * @JMS\Type("string")
     */
    public $name;

    /**
     * @JMS\Type("string")
     */
    public $description;
}
