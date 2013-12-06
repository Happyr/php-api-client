<?php

namespace HappyR\ApiClient\Entity\Potential;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Profile
 *
 * This class represents a matching profile
 */
class Pattern
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

    /**
     * A string like "en", "sv", etc
     *
     * @JMS\Type("string")
     */
    public $language;

    /**
     * Is the pattern "public" or "private"
     *
     * @JMS\Type("string")
     */
    public $type;
}
