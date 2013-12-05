<?php

namespace HappyR\ApiClient\Entity\Location;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Municipality
 *
 * This class represents a municipality
 */
class Municipality
{
    /**
     * @JMS\Type("string")
     */
    public $name;

    /**
     * @JMS\Type("string")
     */
    public $code;
}