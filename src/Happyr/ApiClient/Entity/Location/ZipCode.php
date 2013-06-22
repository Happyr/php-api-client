<?php

namespace Happyr\ApiClient\Entity\Location;

use JMS\Serializer\Annotation as JMS;

/**
 * Class ZipCode
 *
 * This class represents a zip code
 */
class ZipCode
{
    /**
     * @JMS\Type("string")
     */
    public $name;

}