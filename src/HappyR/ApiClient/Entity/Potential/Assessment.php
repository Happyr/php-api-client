<?php

namespace HappyR\ApiClient\Entity\Potential;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Assessment
 *
 * @author Tobias Nyholm
 *
 * This is one of the options for the Statement
 */
class Assessment
{
    /**
     * @JMS\Type("integer")
     */
    public $value;

    /**
     * @JMS\Type("string")
     */
    public $label;
}
