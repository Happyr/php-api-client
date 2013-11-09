<?php

namespace HappyR\ApiClient\Entity\Location;

use JMS\Serializer\Annotation as JMS;

/**
 * Class City
 *
 * This class represents a city
 */
class City
{
    /**
     * @JMS\Type("string")
     */
    public $name;
}