<?php

namespace HappyR\ApiClient\Entity;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Opus
 *
 * This class represents a job advert
 */
class Opus
{
    /**
     * @JMS\Type("integer")
     */
    public $id;

    /**
     * @JMS\Type("string")
     */
    public $headline;

    /**
     * @JMS\Type("string")
     */
    public $description;

    /**
     * @JMS\Type("Happyr\ApiClient\Entity\Location\Location")
     */
    public $location;

    /**
     * @JMS\Type("Happyr\ApiClient\Entity\Company")
     */
    public $company;

    /**
     * @JMS\Type("string")
     */
    public $createdAt;

}
