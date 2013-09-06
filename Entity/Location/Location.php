<?php

namespace HappyR\ApiClient\Entity\Location;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Location
 *
 * This class represents a location
 */
class Location
{
    /**
     * @JMS\Type("string")
     */
    public $address;

    /**
     * @JMS\Type("string")
     */
    public $lng;

    /**
     * @JMS\Type("string")
     */
    public $lat;

    /**
     * @JMS\Type("HappyR\ApiClient\Entity\Location\Country")
     */
    public $country;

    /**
     * @JMS\Type("HappyR\ApiClient\Entity\Location\City")
     */
    public $city;

    /**
     * @JMS\Type("HappyR\ApiClient\Entity\Location\Municipality")
     */
    public $municipality;

    /**
     * @JMS\Type("HappyR\ApiClient\Entity\Location\ZipCode")
     */
    public $zipCode;

}