<?php

namespace Happyr\ApiClient\Entity\Populus;

use JMS\Serializer\Annotation as JMS;

/**
 * Class Score
 *
 * This class represents the score on the matching
 */
class Score
{
    /**
     * @JMS\Type("integer")
     */
    public $score;
}
