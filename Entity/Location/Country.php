<?php

namespace HappyR\ApiClient\Entity\Location;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Country
 *
 * This class represents a country
 */
class Country
{
    /**
     * @JMS\Type("string")
     */
    public $name;
}